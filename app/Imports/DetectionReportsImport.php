<?php

namespace App\Imports;

use App\Models\Admin\CarBrand;
use App\Models\Admin\CarModel;
use App\Models\Admin\DetectionReport;
use App\Models\Admin\InspectionInstitution;
use App\Models\Admin\Regulations;
use App\Models\Admin\Reporter;
use App\Repositories\Admin\DetectionReportRepository;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class DetectionReportsImport implements ToModel, WithHeadingRow, WithColumnFormatting
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        // $expiration_date_end = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['reports_expiration_date_end']));
        // if ($this->validateDateTimeWithCarbon($row['reports_expiration_date_end'] ?? '')) {
        $expiration_date_end = Carbon::parse(Date::excelToDateTimeObject((int)$row['reports_expiration_date_end']))->format('Y-m-d');
        // }

        $reporter_info = Reporter::where('reporter_name', 'LIKE', '%'.$row['reports_reporter'] ?? null.'%')->value('id');
        if ($reporter_info == null || $reporter_info == '') {
            if ($row['reports_reporter'] == '') {
                $reporter = $reporter_info;
            } else {
                $createReporter = Reporter::create(['reporter_name' => $row['reports_reporter'], 'reporter_gui_number' => '', 'reporter_address' => '', 'reporter_phone' => '', 'reporter_fax' => '', 'reporter_seal' => '']);
                $reporter = $createReporter->id;
            }
        } else {
            $reporter = $reporter_info;
        }

        $brand_info = CarBrand::where('brand_name', 'LIKE', '%'.$row['reports_car_brand'] ?? null.'%')->value('id');
        if ($brand_info == null || $brand_info == '') {
            if ($row['reports_car_brand'] == '') {
                $brand = $brand_info;
            } else {
                $createBrand = CarBrand::create(['brand_name' => $row['reports_car_brand']]);
                $brand = $createBrand->id;
            }
        } else {
            $brand = $brand_info;
        }

        $model_info = CarModel::where('model_name', 'LIKE', '%'.$row['reports_car_model'] ?? null.'%')->where('car_brand_id', $brand)->value('id');
        if ($model_info == '' || $model_info == null) {
            if ($row['reports_car_model'] == '') {
                $model = $model_info;
            } else {
                $createModel = CarModel::create(['car_brand_id' => $brand, 'model_name' => $row['reports_car_model']]);
                $model = $createModel->id;
            }
        } else {
            $model = $model_info;
        }

        $ii_info = InspectionInstitution::where('ii_name', 'LIKE', '%'.$row['reports_inspection_institution'] ?? null.'%')->value('id');
        if ($ii_info == null || $ii_info == '') {
            if ($row['reports_inspection_institution'] == '') {
                $ii = $ii_info;
            } else {
                $createIi = InspectionInstitution::create(['ii_name' => $row['reports_inspection_institution']]);
                $ii = $createIi->id;
            }
        } else {
            $ii = $ii_info;
        }

        $test_date = null;
        if (preg_match('/^[0-9]{1,3}\/(0[1-9]|1[0-2])\/(0[1-9]|[12][0-9]|3[01])$/', $row['reports_test_date'])) {
            list($year, $month, $day) = explode('/', $row['reports_test_date']);

            $gregorianYear = $year + 1911;
            $gregorianDate = "{$gregorianYear}-{$month}-{$day}";
            $test_date = $gregorianDate;

            // $year = (int)substr($row['reports_test_date'], 0, 3) + 1911;
            // $month = substr($row['reports_test_date'], 4, 2);
            // $day = substr($row['reports_test_date'], 7, 2);

            // $convertedDate = Carbon::create($year, $month, $day);

            // $test_date =  $convertedDate->toDateString();
        }

        $report_date = null;
        if (preg_match('/^[0-9]{1,3}\/(0[1-9]|1[0-2])\/(0[1-9]|[12][0-9]|3[01])$/', $row['reports_date'])) {
            list($year, $month, $day) = explode('/', $row['reports_date']);

            $gregorianYear = $year + 1911;
            $gregorianDate = "{$gregorianYear}-{$month}-{$day}";
            $report_date = $gregorianDate;
            // $year = (int)substr($row['reports_date'], 0, 3) + 1911;
            // $month = substr($row['reports_date'], 4, 2);
            // $day = substr($row['reports_date'], 7, 2);

            // $convertedDate = Carbon::create($year, $month, $day);

            // $report_date =  $convertedDate->toDateString();
        }


        $reports_regulations = [];
        // $regs = preg_split('/[、]/', $row['reports_regulations']);
        $regs = explode('、', $row['reports_regulations']);
        foreach ($regs as $reg) {
            $englishAndNumbers = Str::of($reg)->match('/[A-Za-z0-9 .\/]+/');
            $chinese = Str::of($reg)->match('/[\x{4e00}-\x{9fa5}]+/u');
            if ($englishAndNumbers == '' && $chinese == '') continue;
            $reg_info = Regulations::where('regulations_num', $englishAndNumbers)->value('regulations_num');
            if ($reg_info != null || $reg_info != '') {
                array_push($reports_regulations, $reg_info);
            } else {
                Regulations::create(['regulations_num' => $englishAndNumbers, 'regulations_name' => $chinese]);
                array_push($reports_regulations, $englishAndNumbers);
            }
        }

        $reports_authorize_status = DetectionReportRepository::REPLIED;
        if ($row['reports_num'] == '' || $row['letter_id'] == '' || $row['reports_reply'] == '' ||
        $expiration_date_end == '' || $reporter == '' || $brand == '' ||
        $model == '' || $ii == '' || $row['reports_regulations'] == [] ||
        $test_date == '' || $report_date == '') {
            $reports_authorize_status = DetectionReportRepository::UNDELIVERY;
        }

        return new DetectionReport([
            //
            'letter_id' => $row['letter_id'] ?? null,
            'reports_num' => $row['reports_num'] ?? '',
            'reports_expiration_date_end' => $expiration_date_end,
            'reports_reporter' => $reporter,
            'reports_car_brand' => $brand,
            'reports_car_model' => $model,
            'reports_inspection_institution' => $ii,
            'reports_regulations' => $reports_regulations,
            'reports_car_model_code' => $row['reports_car_model_code'] ?? null,
            'reports_test_date' => $test_date,
            'reports_date' => $report_date,
            'reports_vin' => $row['reports_vin'] ?? null,
            'reports_authorize_count_before' => $row['reports_authorize_count_before'] ?? 0,
            'reports_authorize_count_current' => $row['reports_authorize_count_before'] ?? 0,
            'reports_f_e' => $row['reports_f_e'] ?? null,
            'reports_reply' => $row['reports_reply'] ?? null,
            'reports_note' => $row['reports_note'] ?? null,
            'reports_authorize_status' => $reports_authorize_status
        ]);
    }

    public function columnFormats(): array
    {
        return [
            'D' => NumberFormat::FORMAT_DATE_YYYYMMDD,
        ];
    }

    function validateDateTimeWithCarbon($date, $format = 'Y/m/d')
    {
        try {
            $carbonDate = Carbon::createFromFormat($format, $date);
            return $carbonDate->format($format) === $date;
        } catch (\Exception $e) {
            return false;
        }
    }
}
