<?php

namespace App\Exports;

use App\Models\Admin\DetectionReport;
use App\Models\Admin\AuthorizeStatus;
use App\Models\Admin\CarBrand;
use App\Models\Admin\CarFuelCategory;
use App\Models\Admin\CarModel;
use App\Models\Admin\CarPattern;
use App\Models\Admin\InspectionInstitution;
use App\Models\Admin\Reporter;
use App\Models\Admin\Regulations;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Events\BeforeSheet;

class DetectionReportExport implements FromCollection, ShouldAutoSize, WithMapping, WithHeadingRow, WithEvents, WithStyles
{
    protected $data_id;

    protected $type;

    const REPORTS_FULL = "REPORTS_FULL";

    const REPORTS_SIMPLE = "REPORTS_SIMPLE";

    const HEADER_FULL_BY_ID = [
        '項次',
        '檢測報告編號',
        '發函文號',
        '授權狀態',
        '有效期限-迄',
        '報告所有人',
        '廠牌',
        '車型',
        '檢測機構',
        '法規項目',
        '車種代號',
        '測試日期',
        '報告日期',
        '代表車車身碼',
        '移入前授權使用次數',
        '移入後累計授權次數',
        'F/E',
        '車輛型式',
        '門數',
        '汽缸數',
        '座位數',
        '燃油類別',
        '車安回函',
        '說明'
    ];

    const HEADER_FULL = [
        '項次',
        '檢測報告編號',
        '發函文號',
        '授權狀態',
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
        '移入前授權使用次數',
        '移入後累計授權次數',
        'F/E',
        '車輛型式',
        '門數',
        '汽缸數',
        '座位數',
        '燃油類別',
        '車安回函',
        '說明'
    ];

    const HEADER_SIMPLE = [
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
        '移入前授權使用次數',
        '移入後累計授權次數',
        'F/E'
    ];

    public function __construct($data_id = null, $type = self::REPORTS_SIMPLE)
    {
        $this->data_id = $data_id;

        $this->type = $type;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        if ($this->data_id == null) {
            $detectionReport = DetectionReport::all();
        } else {
            if (is_array($this->data_id)) {
                $data_ids = $this->data_id;
            } else {
                $data_ids = explode(',', $this->data_id);
            }
            $detectionReport = DetectionReport::whereIn('id', $data_ids)->get();
        }

        $processDetection = $detectionReport->map(function ($detectionReport, $index) {
            return ['item' => $detectionReport, 'index' => $index];

        });

        switch ($this->type) {
            case self::REPORTS_FULL:
                if ($this->data_id == null) {
                    $processDetection->prepend(['item' => self::HEADER_FULL, 'index' => '']);
                } else {
                    $processDetection->prepend(['item' => self::HEADER_FULL_BY_ID, 'index' => '']);
                }
                break;

            case self::REPORTS_SIMPLE:
                $processDetection->prepend(['item' => self::HEADER_SIMPLE, 'index' => '']);
                break;
        }

        // dd ($processDetection);
        return $processDetection;
    }

    public function map($items): array
    {
        $detectionReport = $items['item'];
        $index = $items['index'];

        if ($index == '') {
            switch ($this->type) {
                case self::REPORTS_FULL:
                    $dd = [
                        'index' => $detectionReport[0],
                        'reports_num' => $detectionReport[1],
                        'letter_id' => $detectionReport[2],
                        'reports_authorize_status' => $detectionReport[3],
                        'reports_expiration_date_end' => $detectionReport[4],
                        'reports_reporter' => $detectionReport[5],
                        'reports_car_brand' => $detectionReport[6],
                        'reports_car_model' => $detectionReport[7],
                        'reports_inspection_institution' => $detectionReport[8],
                        'reports_regulations' => $detectionReport[9],
                        'reports_car_model_code' => $detectionReport[10],
                        'reports_test_date' => $detectionReport[11],
                        'reports_date' => $detectionReport[12],
                        'reports_vin' => $detectionReport[13],
                        'reports_authorize_count_before' => $detectionReport[14],
                        'reports_authorize_count_current' => $detectionReport[15],
                        'reports_f_e' => $detectionReport[16],
                        'reports_vehicle_pattern' => $detectionReport[17],
                        'reports_vehicle_doors' => $detectionReport[18],
                        'reports_vehicle_cylinders' => $detectionReport[19],
                        'reports_vehicle_seats' => $detectionReport[20],
                        'reports_vehicle_fuel_category' => $detectionReport[21],
                        'reports_reply' => $detectionReport[22],
                        'reports_note' => $detectionReport[23]
                    ];
                    break;

                case self::REPORTS_SIMPLE:
                    $dd = [
                        'index' => $detectionReport[0],
                        'reports_authorize_status' => $detectionReport[1],
                        'reports_expiration_date_end' => $detectionReport[2],
                        'reports_reporter' => $detectionReport[3],
                        'reports_car_brand' => $detectionReport[4],
                        'reports_car_model' => $detectionReport[5],
                        'reports_inspection_institution' => $detectionReport[6],
                        'reports_regulations' => $detectionReport[7],
                        'reports_car_model_code' => $detectionReport[8],
                        'reports_test_date' => $detectionReport[9],
                        'reports_date' => $detectionReport[10],
                        'reports_vin' => $detectionReport[11],
                        'reports_authorize_count_before' => $detectionReport[12],
                        'reports_authorize_count_current' => $detectionReport[13],
                        'reports_f_e' => $detectionReport[14],
                    ];
                    break;
            }

            return $dd;
        } else {
            $reporter = (Reporter::find($detectionReport->reports_reporter))->reporter_name;
            $status = (AuthorizeStatus::find($detectionReport->reports_authorize_status))->status_name;
            $brand = (CarBrand::find($detectionReport->reports_car_brand))->brand_name;
            $model = (CarModel::find($detectionReport->reports_car_model))->model_name;
            $ii = (InspectionInstitution::find($detectionReport->reports_inspection_institution))->ii_name;
            $regulations = '';
            if ($detectionReport->reports_regulations == null || $detectionReport->reports_regulations == '' || count($detectionReport->reports_regulations) == 0) {
                $regulations = '無';
            } else {
                foreach ($detectionReport->reports_regulations as $i => $reg) {
                    $regulation = Regulations::where('regulations_num', $reg)->first();
                    if ($i == 0) {
                        $regulations .= $regulation->regulations_num . ' ' . $regulation->regulations_name;
                    } else {
                        $regulations .= '，' . $regulation->regulations_num . ' ' . $regulation->regulations_name;
                    }
                }
            }
            $carPattern = (CarPattern::find($detectionReport->reports_vehicle_pattern))->pattern_name ?? '';
            $carFuelCategory = (CarFuelCategory::find($detectionReport->reports_vehicle_fuel_category))->category_name ?? '';
            $reports_expiration_date_end = Carbon::parse($detectionReport->reports_expiration_date_end)->format('Y/m/d');
            $td = Carbon::parse($detectionReport->reports_test_date);
            $reports_test_date = ((int)$td->year - 1911) . '/' . str_pad($td->month, 2, "0", STR_PAD_LEFT) . '/' . str_pad($td->day, 2, "0", STR_PAD_LEFT);

            $d = Carbon::parse($detectionReport->reports_date);
            $reports_date = ((int)$d->year - 1911) . '/' . str_pad($d->month, 2, "0", STR_PAD_LEFT) . '/' . str_pad($d->day, 2, "0", STR_PAD_LEFT);


            switch ($this->type) {
                case self::REPORTS_FULL:
                    return [
                        'index' => $index + 1,
                        'reports_num' => $detectionReport->reports_num,
                        'letter_id' => $detectionReport->letter_id,
                        'reports_authorize_status' => $status,
                        'reports_expiration_date_end' => $reports_expiration_date_end,
                        'reports_reporter' => $reporter,
                        'reports_car_brand' => $brand,
                        'reports_car_model' => $model,
                        'reports_inspection_institution' => $ii,
                        'reports_regulations' => $regulations,
                        'reports_car_model_code' => $detectionReport->reports_car_model_code,
                        'reports_test_date' => $reports_test_date,
                        'reports_date' => $reports_date,
                        'reports_vin' => $detectionReport->reports_vin, // 登錄清冊備註欄為車身碼
                        'reports_authorize_count_before' => (string)$detectionReport->reports_authorize_count_before,
                        'reports_authorize_count_current' => (string)$detectionReport->reports_authorize_count_current,
                        'reports_f_e' => $detectionReport->reports_f_e,
                        'reports_vehicle_pattern' => $carPattern,
                        'reports_vehicle_doors' => $detectionReport->reports_vehicle_doors,
                        'reports_vehicle_cylinders' => $detectionReport->reports_vehicle_cylinders,
                        'reports_vehicle_seats' => $detectionReport->reports_vehicle_seats,
                        'reports_vehicle_fuel_category' => $carFuelCategory,
                        'reports_reply' => $detectionReport->reports_reply,
                        'reports_note' => $detectionReport->reports_note,
                    ];
                    break;

                case self::REPORTS_SIMPLE:
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
                        'reports_vin' => $detectionReport->reports_vin, // 登錄清冊備註欄為車身碼
                        'reports_authorize_count_before' => (string)$detectionReport->reports_authorize_count_before,
                        'reports_authorize_count_current' => (string)$detectionReport->reports_authorize_count_current,
                        'reports_f_e' => $detectionReport->reports_f_e,
                    ];
                    break;
            }
        }

    }

    // public function title(): string
    // {
    //     if ($this->data_id == null) {
    //         return '檢測報告總表';
    //     } else {
    //         return '外匯車授權管理系統';
    //     }
    // }

    /**
     * @return int
     */
    // public function startRow(): int
    // {
    //     return 2;
    // }

    // public function headings(): array
    // {
    //     if ($this->data_id == null) {
    //         return [
    //             '項次',
    //             '檢測報告編號',
    //             '有效期限-迄',
    //             '報告所有者',
    //             '車輛廠牌',
    //             '車型名稱',
    //             '檢測機構',
    //             '法規項目',
    //             '車種代號',
    //             '測試日期',
    //             '報告製作日期',
    //             '備註',
    //             '移入前授權使用次數',
    //             '移入後累計授權次數',
    //             'F/E'
    //         ];
    //     } else {
    //         return [
    //             '檢測報告編號',
    //             '發函文號',
    //             '授權狀態',
    //             '有效期限-迄',
    //             '報告所有人',
    //             '廠牌',
    //             '車型',
    //             '檢測機構',
    //             '法規項目',
    //             '車種代號',
    //             '測試日期',
    //             '報告日期',
    //             '代表車車身碼',
    //             '移入前授權使用次數',
    //             '移入後累計授權次數',
    //             'F/E',
    //             '車安回函',
    //             '說明'
    //         ];
    //     }
    // }

    public function styles(Worksheet $sheet)
    {
        // 設置整個工作表的字體大小
        $sheet->getStyle('A2:X2000')->getFont()->setSize(12);

        // 設置標題行的字體大小
        $sheet->getStyle('A1:X1')->getFont()->setSize(16);
        // $sheet->getStyle('A2:R2')->getFont()->setSize(13);

        // 合併 A1 至最後一個標題的欄位
        // $sheet->mergeCells('A1:' . $sheet->getHighestDataColumn() . '1');

        // // 設定樣式
        // $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        // $sheet->getStyle('A1')->getFont()->setBold(true);

        // // 設定大標題
        // if ($this->data_id == null) {
        //     $sheet->setCellValue('A1', '檢測報告總表');
        // } else {
        //     $sheet->setCellValue('A1', '外匯車授權管理系統');
        // }
    }

        public function registerEvents(): array
        {
            return [
                AfterSheet::class => function(AfterSheet $event) {
                    // $event->sheet->getDelegate()->mergeCells('A1:S1'); // 根據需要合併的欄位調整
                    // // 設置標題樣式
                    // $event->sheet->getDelegate()->getStyle('A1')->getFont()->setBold(true);
                    // $event->sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // 置中

                    // if ($this->data_id == null) {
                    //     $event->sheet->setCellValue('A1', '檢測報告總表');
                    // } else {
                    //     $event->sheet->setCellValue('A1', '外匯車授權管理系統');
                    // }

                    $event->sheet->getStyle('A2:X2')->applyFromArray([
                        'font' => [
                            'bold' => true
                        ]
                        // 其他樣式屬性...
                    ]);
                },
                BeforeSheet::class => function(BeforeSheet $event) {


                    if ($this->data_id == null) {
                        $event->sheet->setCellValue('A1', '檢測報告總表');
                        $event->sheet->getDelegate()->mergeCells('A1:O1'); // 根據需要合併的欄位調整
                    } else {
                        $event->sheet->setCellValue('A1', '外匯車授權管理系統');
                        $event->sheet->getDelegate()->mergeCells('A1:X1'); // 根據需要合併的欄位調整
                    }

                    // 設置標題樣式
                    $event->sheet->getDelegate()->getStyle('A1')->getFont()->setBold(true);
                    $event->sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // 置中

                    // $event->sheet->getStyle('A2:S2')->applyFromArray([
                    //     'font' => [
                    //         'bold' => true
                    //     ]
                    //     // 其他樣式屬性...
                    // ]);
                },
            ];
        }
}
