<?php

namespace App\Exports;

use App\Models\Admin\DetectionReport;
use App\Models\Admin\CarBrand;
use App\Models\Admin\CarModel;
use App\Models\Admin\InspectionInstitution;
use App\Models\Admin\Reporter;
use App\Models\Admin\Regulations;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DetectionReportExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    protected $data_id;

    public function __construct($data_id)
    {
        $this->data_id = $data_id;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $detectionReport = DetectionReport::whereIn('id', $this->data_id)->get();

        $processDetection = $detectionReport->map(function ($detectionReport, $index) {
            $reporter = (Reporter::find($detectionReport->reports_reporter))->reporter_name;
            $brand = (CarBrand::find($detectionReport->reports_car_brand))->brand_name;
            $model = (CarModel::find($detectionReport->reports_car_model))->model_name;
            $ii = (InspectionInstitution::find($detectionReport->reports_inspection_institution))->ii_name;
            $regulations = '';
            foreach ($detectionReport->reports_regulations as $i => $reg) {
                $regulation = Regulations::where('regulations_num', $reg)->first();
                if ($i == 0) {
                    $regulations .= $regulation->regulations_num . ' ' . $regulation->regulations_name;
                } else {
                    $regulations .= '，' . $regulation->regulations_num . ' ' . $regulation->regulations_name;
                }
            }
            $reports_expiration_date_end = Carbon::parse($detectionReport->reports_expiration_date_end)->format('Y/m/d');
            $td = Carbon::parse($detectionReport->reports_test_date);
            $reports_test_date = ((int)$td->year - 1911) . '/' . str_pad($td->month, 2, "0", STR_PAD_LEFT) . '/' . str_pad($td->day, 2, "0", STR_PAD_LEFT);

            $d = Carbon::parse($detectionReport->reports_date);
            $reports_date = ((int)$d->year - 1911) . '/' . str_pad($d->month, 2, "0", STR_PAD_LEFT) . '/' . str_pad($d->day, 2, "0", STR_PAD_LEFT);

            return [
                'index' => $index + 1,
                'reports_num' => $detectionReport->reports_num,
                'reports_expiration_date_end' => $reports_expiration_date_end,
                'reports_reporter' => $reporter,
                'reports_car_brand' => $brand,
                'reports_car_model' => $model,
                'reports_inspection_institution' => $ii,
                'reports_regulations' => $regulations,
                'reports_car_model_code' => $detectionReport->reports_car_model_code,
                'reports_test_date' => $reports_test_date,
                'reports_date' => $reports_date,
                'reports_note' => $detectionReport->reports_vin, // 登錄清冊備註欄為車身碼
                'reports_authorize_count_current' => (string)$detectionReport->reports_authorize_count_current,
                'reports_f_e' => $detectionReport->reports_f_e,
            ];

        });

        return $processDetection;
    }

    public function headings(): array
    {
        return [
            '項次',
            '檢測報告編號',
            '有效期限-迄',
            '報告所有者',
            '車輛廠牌',
            '車型名稱',
            '檢測機構',
            '法規項目',
            '車種代號',
            '測試日期',
            '報告製作日期',
            '備註',
            '次數',
            'F/E'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // 設置整個工作表的字體大小
        $sheet->getStyle('A1:Z1000')->getFont()->setSize(12);

        // 設置標題行的字體大小
        // $sheet->getStyle('A1:Z1')->getFont()->setSize(16);
    }
}
