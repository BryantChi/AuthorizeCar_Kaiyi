<?php

namespace App\Console\Commands;

use App\Models\Admin\CumulativeAuthorizedUsageRecords;
use App\Models\Admin\DetectionReport;
use App\Models\Admin\ExportAuthorizeRecords;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FixDuplicateSerialNumbersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:serial-numbers {--dry-run : 只顯示會修改的資料，不實際執行} {--force : 跳過確認直接執行}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '修復重複的授權使用序號末3碼';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $dryRun = $this->option('dry-run');
        $force = $this->option('force');

        if ($dryRun) {
            $this->info('=== 乾跑模式：只顯示會修改的資料 ===');
        } else if (!$force) {
            if (!$this->confirm('此操作將修改資料庫中的序號資料，建議先備份資料庫。是否繼續？')) {
                $this->info('操作已取消');
                return 0;
            }
        }

        // 取得所有有授權記錄的報告ID
        $reportIds = CumulativeAuthorizedUsageRecords::select('reports_id')
            ->distinct()
            ->pluck('reports_id');

        $this->info("找到 {$reportIds->count()} 個檢測報告需要檢查");

        $fixedCount = 0;
        $errorCount = 0;

        $progressBar = $this->output->createProgressBar($reportIds->count());

        foreach ($reportIds as $reportId) {
            try {
                $fixed = $this->fixReportSerialNumbers($reportId, $dryRun);
                if ($fixed) {
                    $fixedCount++;
                }
            } catch (\Exception $e) {
                $errorCount++;
                $this->error("處理報告ID {$reportId} 時發生錯誤: " . $e->getMessage());
            }
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine(2);

        $this->info("完成！共修復 {$fixedCount} 個報告的序號");
        if ($errorCount > 0) {
            $this->warn("有 {$errorCount} 個報告處理失敗");
        }

        return 0;
    }

    /**
     * 修復單個報告的序號
     */
    private function fixReportSerialNumbers($reportId, $dryRun)
    {
        $report = DetectionReport::find($reportId);
        if (!$report) {
            return false;
        }

        // 取得該報告所有有效的累計授權記錄（按創建時間排序）
        $records = CumulativeAuthorizedUsageRecords::where('reports_id', $reportId)
            ->where('quantity', '>', 0)
            ->orderBy('created_at', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        if ($records->isEmpty()) {
            return false;
        }

        $needsFix = false;
        $expectedSerial = 1;

        // 檢查是否有序號需要修復
        foreach ($records as $record) {
            if ($record->authorization_serial_number != $expectedSerial) {
                $needsFix = true;
                break;
            }
            $expectedSerial++;
        }

        if (!$needsFix) {
            return false;
        }

        $this->newLine();
        $this->info("報告 {$report->reports_num} (ID: {$reportId}) 需要修復序號");

        if ($dryRun) {
            $this->line("  現有序號: " . $records->pluck('authorization_serial_number')->implode(', '));
            $this->line("  正確序號: " . implode(', ', range(1, $records->count())));
            return true;
        }

        // 執行修復
        DB::transaction(function () use ($records, $report, $reportId) {
            $counter = 0;
            foreach ($records as $record) {
                $counter++;
                $oldSerial = $record->authorization_serial_number;

                if ($oldSerial != $counter) {
                    // 更新 CumulativeAuthorizedUsageRecords 的序號
                    $record->authorization_serial_number = $counter;
                    $record->save();

                    // 更新對應的 ExportAuthorizeRecords JSON
                    $this->updateExportAuthNumId(
                        $record->export_id,
                        $report->reports_num,
                        $report->reports_expiration_date_end,
                        $report->reports_f_e,
                        $oldSerial,
                        $counter
                    );
                }
            }

            // 更新 DetectionReport 的 reports_authorize_count_current
            $report->reports_authorize_count_current = $counter;
            $report->save();

            $this->line("  已修復，新的 count_current = {$counter}");
        });

        return true;
    }

    /**
     * 更新 ExportAuthorizeRecords 的 JSON 欄位中的授權序號
     */
    private function updateExportAuthNumId($exportId, $reportNum, $expirationDate, $fe, $oldSerial, $newSerial)
    {
        if (!$exportId) {
            return;
        }

        $export = ExportAuthorizeRecords::find($exportId);
        if (!$export || !$export->export_authorize_auth_num_id) {
            return;
        }

        $authNumIds = $export->export_authorize_auth_num_id;
        if (!is_array($authNumIds)) {
            return;
        }

        // 計算日期部分
        $expDate = \Carbon\Carbon::parse($expirationDate);
        $dateY = $expDate->year - 1911;
        $dateM = str_pad($expDate->month, 2, "0", STR_PAD_LEFT);
        $dateD = str_pad($expDate->day, 2, "0", STR_PAD_LEFT);
        $feStr = $fe ?? '';

        // 舊的授權序號格式
        $oldSid = $reportNum . '-Y' . $feStr . $dateY . $dateM . $dateD . '-' . str_pad($oldSerial, 3, "0", STR_PAD_LEFT);
        // 新的授權序號格式
        $newSid = $reportNum . '-Y' . $feStr . $dateY . $dateM . $dateD . '-' . str_pad($newSerial, 3, "0", STR_PAD_LEFT);

        // 替換陣列中的值
        $updated = false;
        foreach ($authNumIds as $index => $sid) {
            if ($sid === $oldSid) {
                $authNumIds[$index] = $newSid;
                $updated = true;
                break;
            }
        }

        if ($updated) {
            $export->export_authorize_auth_num_id = $authNumIds;
            $export->save();
        }
    }
}
