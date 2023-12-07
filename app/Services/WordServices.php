<?php

namespace App\Services;

use App\Exports\DetectionReportExport;
use App\Models\Admin\AgreeAuthorizeRecords;
use PhpOffice\PhpWord\TemplateProcessor;
// use PhpOffice\PhpWord\IOFactory;
// use PhpOffice\PhpWord\PhpWord;
// use PhpOffice\PhpWord\Writer\PDF;
use App\Models\Admin\DetectionReport;
use App\Models\Admin\Reporter;
use App\Models\Admin\CompanyInfo as Company;
use App\Models\Admin\Regulations;
use App\Models\Admin\CarBrand;
use App\Models\Admin\CarModel;
use App\Models\Admin\CumulativeAuthorizedUsageRecords;
use App\Models\Admin\ExportAuthorizeRecords;
use stdClass;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\File;
use Ilovepdf\Ilovepdf;
use Maatwebsite\Excel\Facades\Excel;

class WordServices
{
    const MOVE_IN_CONTRACT = 'MOVE_IN_CONTRACT';
    const APPLICATION_LETTER = 'APPLICATION_LETTER';
    const DATA_ENTRY_EXCEL = 'DATA_ENTRY_EXCEL';
    const POWER_OF_ATTORNEY = 'POWER_OF_ATTORNEY';
    const MOVE_OUT_AFFIDAVIT = 'MOVE_OUT_AFFIDAVIT';
    const AFFIDAVIT_LETTER = 'AFFIDAVIT_LETTER';
    const DATA_AFFIDAVIT_EXCEL = 'DATA_AFFIDAVIT_EXCEL';
    const POSTPONE_CONTRACT = 'POSTPONE_CONTRACT';
    const POSTPONE_APPLICATION_LETTER = 'POSTPONE_APPLICATION_LETTER';
    const DATA_POSTPONE_EXCEL = 'DATA_POSTPONE_EXCEL';

    function updateWordDocument($fileType = null, $data_id, $options = array())
    {
        switch ($fileType) {
            case self::MOVE_IN_CONTRACT: // 檢測報告移入合約書
                $templatefileName = 'Template_檢測報告移入協會合約書.docx';
                $templatefilePath = public_path('template_doc/' . $templatefileName);
                return $this->setMoveInContract($data_id, $templatefilePath);
                break;
            case self::APPLICATION_LETTER: // 申請函
                $templatefileName = 'Template_申請函.docx';
                $templatefilePath = public_path('template_doc/' . $templatefileName);
                return $this->setApplicationLetter($data_id, $templatefilePath);
                break;
            case self::DATA_ENTRY_EXCEL: // 登錄清冊
                return $this->setDataEntryExcel($data_id);
                break;
            case self::POWER_OF_ATTORNEY: // 授權書
                $templatefileName = 'Template_授權書.docx';
                $templatefilePath = public_path('template_doc/' . $templatefileName);
                return $this->setPowerOfAttorney($data_id, $templatefilePath, $options['auth_input'], $options['mode'], $options['auth_export_id']);
                break;
            case self::MOVE_OUT_AFFIDAVIT: // 檢測報告移出切結書
                $templatefileName = 'Template_檢測報告移出協會切結書.docx';
                $templatefilePath = public_path('template_doc/' . $templatefileName);
                return $this->setMoveOutAffidavit($data_id, $templatefilePath);
                break;
            case self::AFFIDAVIT_LETTER: // 檢測報告移出函文
                $templatefileName = 'Template_檢測報告(移出)函文.docx';
                $templatefilePath = public_path('template_doc/' . $templatefileName);
                return $this->setAffidavitLetter($data_id, $templatefilePath);
                break;
            case self::DATA_AFFIDAVIT_EXCEL: // 移出清冊
                return $this->setDataAffidavitExcel($data_id);
                break;
            case self::POSTPONE_CONTRACT: // 檢測報告展延合約書
                $templatefileName = 'Template_檢測報告展延合約書.docx';
                $templatefilePath = public_path('template_doc/' . $templatefileName);
                return $this->setPostponeContract($data_id, $templatefilePath);
            case self::POSTPONE_APPLICATION_LETTER: // 展延申請函
                $templatefileName = 'Template_申請函.docx';
                $templatefilePath = public_path('template_doc/' . $templatefileName);
                return $this->setPostponeApplicationLetter($data_id, $templatefilePath);
                break;
            case self::DATA_POSTPONE_EXCEL: // 展延清冊
                return $this->setDataPostponeExcel($data_id);
                break;
        }
    }

    public function setMoveInContract($data_id, $filePath)
    {

        $templateProcessor = new TemplateProcessor($filePath);

        $data_id_string = implode(',', $data_id);
        $detection_reports = DetectionReport::whereIn('id', $data_id)->orderByRaw("FIELD(id, $data_id_string)")->get();

        $reports_reporter = Reporter::find($detection_reports[0]->reports_reporter);

        $templateProcessor->setValue('reports_reporter', $reports_reporter->reporter_name);
        $templateProcessor->setValue('reporter_num', $reports_reporter->reporter_gui_number);
        $templateProcessor->setValue('reporter_address', $reports_reporter->reporter_address);
        $templateProcessor->setValue('reporter_phone', $reports_reporter->reporter_phone);
        $templateProcessor->setValue('reporter_fax', $reports_reporter->reporter_fax);
        $templateProcessor->setImageValue('image_sign_reporter', public_path('uploads/'.$reports_reporter->reporter_seal));
        // $templateProcessor->setImageValue('image_sign_reporter', public_path('assets/img/sign_test_icon/sign_com.png'));

        $company = Company::first();
        $templateProcessor->setValue('com_name', $company->com_name);
        $templateProcessor->setValue('com_gui_number', $company->com_gui_number);
        $templateProcessor->setValue('com_address', $company->com_address);
        $templateProcessor->setValue('com_phone', $company->com_phone);
        $templateProcessor->setValue('com_fax', $company->com_fax);
        $templateProcessor->setImageValue('image_sign_com', public_path('uploads/'.$company->com_seal));
        // $templateProcessor->setImageValue('image_sign_com', public_path('assets/img/sign_test_icon/sign_com.png'));

        $reports_date = Carbon::today();

        $start_date_y = ((int)$reports_date->year) - 1911;
        $start_date_m = $reports_date->month;
        $start_date_d = $reports_date->day;
        $templateProcessor->setValue('rpf_y', $start_date_y);
        $templateProcessor->setValue('rpf_m', $start_date_m);
        $templateProcessor->setValue('rpf_d', $start_date_d);
        $templateProcessor->setValue('rps_y', $start_date_y);
        $templateProcessor->setValue('rps_m', $start_date_m);
        $templateProcessor->setValue('rps_d', $start_date_d);

        $reports_expiration_date_end = Carbon::parse($detection_reports[0]->reports_expiration_date_end);
        $expiration_date_y = ((int)$reports_expiration_date_end->year) - 1911;
        $expiration_date_m = $reports_expiration_date_end->month;
        $expiration_date_d = $reports_expiration_date_end->day;
        $templateProcessor->setValue('rpt_y', $expiration_date_y);
        $templateProcessor->setValue('rpt_m', $expiration_date_m);
        $templateProcessor->setValue('rpt_d', $expiration_date_d);

        $tb_values = array();

        foreach ($detection_reports as $index => $value) {
            $reports_regulations = '';
            foreach ($value->reports_regulations as $i => $info) {
                if ($i == 0) {
                    $reports_regulations .= $info;
                } else {
                    $reports_regulations .= ', ' . $info;
                }
            }
            array_push($tb_values, [
                'reports_index' => ($index + 1),
                'reports_num' => $value->reports_num,
                'reports_regulations' => $reports_regulations,
                'reports_self_count' => '0',
                'reports_authorize_count_before' => $value->reports_authorize_count_before,
                'reports_authorize_count_before' => $value->reports_authorize_count_before
            ]);
        }

        // dd($tb_values);

        $templateProcessor->cloneRowAndSetValues('reports_index', $tb_values);

        $time = Carbon::now();
        $fullTime = $time->format('Y-m-d_H-i-s');
        $month_year = $time->format('Ym');

        $wordName = '/檢測報告移入協會合約書_' . $reports_reporter->reporter_name . '_' . $fullTime . '.docx';
        $pdfName = '/檢測報告移入協會合約書_' . $reports_reporter->reporter_name . '_' . $fullTime . '.pdf';

        $folderWordPath = 'files/contract_s1/' . $reports_reporter->reporter_name . '/word/' . $month_year;
        $folderPdfPath = 'files/contract_s1/' . $reports_reporter->reporter_name . '/pdf/' . $month_year;

        $fullWordPath = $folderWordPath . $wordName;
        $fullPdfPath = $folderPdfPath . $pdfName;

        $newWordFilePath = public_path($fullWordPath);
        $newPdfFilePath = public_path($fullPdfPath);

        if (!File::exists($folderWordPath)) {
            File::makeDirectory($folderWordPath, 0777, true); // 使用 File 類別建立資料夾
        }

        if (!File::exists($folderPdfPath)) {
            File::makeDirectory($folderPdfPath, 0777, true); // 使用 File 類別建立資料夾
        }

        $templateProcessor->saveAs($newWordFilePath);

        $key2 = ['publicKey' => 'project_public_0972a67458e4dd3ac4561edec19a48ed_pWfxHf7de3bcb072e2b66fc59b5cf8ded47d7', 'secretKey' => 'secret_key_f428272dfee9a265364aeadf9d895a8a_UMGYM186d525137876fd82fbc8a61f341c725'];
        $key0 = ['publicKey' => 'project_public_f836502ed5f152f32db3c629ea4e5e82_MGHoj609fd77dc53495844616498db7ad600c', 'secretKey' => 'secret_key_aa4949f7e3438233c7616c9d2dc9aed9_B1lHnd6b086e1d99ace45e9cec81f8b2c8d97'];
        $key1 = ['publicKey' => 'project_public_a2b3acf35565b86653184bfb72cbe84f_OA2Umd21be5a86ceee9d663ccd7719e1133cf', 'secretKey' => 'secret_key_cc3a4552e6a37a60ed0ad49fe054ff57_ccgD2bc2e2820e351f8f860332455148ce8e0'];

        $pdfKey = [$key0, $key1, $key2];

        $maxAttempts = 3; // 最大重試次數
        $attempts = 0; // 目前的嘗試次數

        while ($attempts < $maxAttempts) {

            $ilovepdf = new Ilovepdf($pdfKey[$attempts]['publicKey'], $pdfKey[$attempts]['secretKey']);
            try {
                // 嘗試要執行的操作
                // 例如：資料庫查詢、外部API調用等
                $myTask = $ilovepdf->newTask('officepdf');
                $file1 = $myTask->addFile($newWordFilePath);
                $myTask->execute();
                $myTask->download(public_path($folderPdfPath));

                break; // 如果操作成功，跳出循環
            } catch (\Exception $e) {
                $attempts++; // 增加嘗試次數
                if ($attempts == $maxAttempts) {
                    // 如果達到最大嘗試次數，可以選擇拋出異常或者處理錯誤
                    throw $e;
                }

                // 可選：在重試之前暫停一段時間
                sleep(1); // 休息1秒
            }
        }

        // return json_encode([
        //     'status' => 'success',
        //     'file_name' => '檢測報告移入協會合約書_' . $reports_reporter->reporter_name . '_' . $fullTime,
        //     'word' => $fullWordPath,
        //     'pdf' => $fullPdfPath,
        // ]);
        return \Response::json([
            'contract_file_name' => '檢測報告移入協會合約書_' . $reports_reporter->reporter_name . '_' . $fullTime,
            'word' => $fullWordPath,
            'pdf' => $fullPdfPath,
        ]);
    }

    public function setApplicationLetter($data_id, $filePath)
    {

        $templateProcessor = new TemplateProcessor($filePath);

        $data_id_string = implode(',', $data_id);
        $detection_reports = DetectionReport::whereIn('id', $data_id)->orderByRaw("FIELD(id, $data_id_string)")->get();

        $reports_letter_id= $detection_reports[0]->letter_id;

        $reports_date = Carbon::today();
        $date_y = ((int)$reports_date->year) - 1911;
        $date_m = str_pad($reports_date->month, 2, "0", STR_PAD_LEFT);
        $date_d = str_pad($reports_date->day, 2, "0", STR_PAD_LEFT);

        $templateProcessor->setValue('rf_y', $date_y);
        $templateProcessor->setValue('rf_m', $date_m);
        $templateProcessor->setValue('rf_d', $date_d);
        $templateProcessor->setValue('rf_letter_id', $reports_letter_id);
        $templateProcessor->setValue('rf_count', count($detection_reports));

        $time = Carbon::now();
        $fullTime = $time->format('Y-m-d_H-i-s');
        $month_year = $time->format('Ym');

        $wordName = '/申請函_' . $fullTime . '.docx';
        $pdfName = '/申請函_' . $fullTime . '.pdf';

        $folderWordPath = 'files/letter_s1/word/' . $month_year;
        $folderPdfPath = 'files/letter_s1/pdf/' . $month_year;

        $fullWordPath = $folderWordPath . $wordName;
        $fullPdfPath = $folderPdfPath . $pdfName;

        $newWordFilePath = public_path($fullWordPath);
        $newPdfFilePath = public_path($fullPdfPath);

        if (!File::exists($folderWordPath)) {
            File::makeDirectory($folderWordPath, 0777, true); // 使用 File 類別建立資料夾
        }

        if (!File::exists($folderPdfPath)) {
            File::makeDirectory($folderPdfPath, 0777, true); // 使用 File 類別建立資料夾
        }

        $templateProcessor->saveAs($newWordFilePath);

        $key2 = ['publicKey' => 'project_public_0972a67458e4dd3ac4561edec19a48ed_pWfxHf7de3bcb072e2b66fc59b5cf8ded47d7', 'secretKey' => 'secret_key_f428272dfee9a265364aeadf9d895a8a_UMGYM186d525137876fd82fbc8a61f341c725'];
        $key0 = ['publicKey' => 'project_public_f836502ed5f152f32db3c629ea4e5e82_MGHoj609fd77dc53495844616498db7ad600c', 'secretKey' => 'secret_key_aa4949f7e3438233c7616c9d2dc9aed9_B1lHnd6b086e1d99ace45e9cec81f8b2c8d97'];
        $key1 = ['publicKey' => 'project_public_a2b3acf35565b86653184bfb72cbe84f_OA2Umd21be5a86ceee9d663ccd7719e1133cf', 'secretKey' => 'secret_key_cc3a4552e6a37a60ed0ad49fe054ff57_ccgD2bc2e2820e351f8f860332455148ce8e0'];

        $pdfKey = [$key0, $key1, $key2];

        $maxAttempts = 3; // 最大重試次數
        $attempts = 0; // 目前的嘗試次數

        while ($attempts < $maxAttempts) {

            $ilovepdf = new Ilovepdf($pdfKey[$attempts]['publicKey'], $pdfKey[$attempts]['secretKey']);
            try {
                // 嘗試要執行的操作
                // 例如：資料庫查詢、外部API調用等
                $myTask = $ilovepdf->newTask('officepdf');
                $file1 = $myTask->addFile($newWordFilePath);
                $myTask->execute();
                $myTask->download(public_path($folderPdfPath));

                break; // 如果操作成功，跳出循環
            } catch (\Exception $e) {
                $attempts++; // 增加嘗試次數
                if ($attempts == $maxAttempts) {
                    // 如果達到最大嘗試次數，可以選擇拋出異常或者處理錯誤
                    throw $e;
                }

                // 可選：在重試之前暫停一段時間
                sleep(1); // 休息1秒
            }
        }

        // return json_encode([
        //     'status' => 'success',
        //     'file_name' => '申請函_' . $reports_reporter->reporter_name . '_' . $fullTime,
        //     'word' => $fullWordPath,
        //     'pdf' => $fullPdfPath,
        // ]);
        return \Response::json([
            'apply_letter_file_name' => '申請函_' . $fullTime,
            'word' => $fullWordPath,
            'pdf' => $fullPdfPath,
        ]);
    }

    public function setDataEntryExcel($data_id)
    {
        $time = Carbon::now();
        $fullTime = $time->format('Y-m-d_H-i-s');
        $month_year = $time->format('Ym');

        $fileName = '附件一、檢測報告登錄清冊 登錄 (' . count($data_id) . ') _' . $fullTime . '.xlsx';

        $folderPath = 'files/excel_s1/' . $month_year;

        if (!File::exists($folderPath)) {
            File::makeDirectory($folderPath, 0777, true); // 使用 File 類別建立資料夾
        }

        // 將檔案保存到 public 目錄下
        $path = Excel::store(new DetectionReportExport($data_id), $folderPath . '/'. $fileName, 's2');

        // return json_encode([
        //     'status' => 'success',
        //     'path' => $folderPath . '/'. $fileName,
        // ]);
        return \Response::json([
            'data_entry_file_name' => '附件一、檢測報告登錄清冊 登錄 (' . count($data_id) . ') _' . $fullTime,
            'excel' => $folderPath . '/'. $fileName,
        ]);
    }

    public function setPowerOfAttorney($data_id, $filePath, $auth_input, $mode = null, $auth_export_id = null)
    {
        $templateProcessor = new TemplateProcessor($filePath);

        $authorize_date = Carbon::today();
        $date_y = ((int)$authorize_date->year) - 1911;
        $date_m = str_pad($authorize_date->month, 2, "0", STR_PAD_LEFT);
        $date_d = str_pad($authorize_date->day, 2, "0", STR_PAD_LEFT);

        $tb_values = array();
        $export_authorize_auth_num_id = array();
        $export_authorize_reports_nums = array();
        $export_authorize_path = array();

        if ($mode == 'edit') {
            $export_id = $auth_export_id;
            $exports = ExportAuthorizeRecords::find($export_id);
            AgreeAuthorizeRecords::where('export_id', $export_id)->delete();
            if ($exports->export_authorize_num != $auth_input[4]) {
                CumulativeAuthorizedUsageRecords::where('export_id', $export_id)->update(['quantity' => 0, 'authorize_num' => $exports->export_authorize_num . ' => ' . $auth_input[4]]);
            } else {
                CumulativeAuthorizedUsageRecords::where('export_id', $export_id)->update(['quantity' => 0]);
            }

            $reports_data = DetectionReport::whereIn('id', $exports->reports_ids)->get();
            foreach ($reports_data as $info) {
                $dr = DetectionReport::find($info->id);
                $dr->reports_authorize_count_current -= 1;
                $dr->save();
            }
        } else {
            $exportAuthRecord = [
                'reports_ids' => json_encode($data_id),
                'export_authorize_num' => $auth_input[4],
                'export_authorize_com' => $auth_input[0],
                'export_authorize_brand' => $auth_input[1],
                'export_authorize_model' => $auth_input[2],
                'export_authorize_vin' => $auth_input[3],
                'export_authorize_auth_num_id' => json_encode($export_authorize_auth_num_id), // 授權序號
                'export_authorize_reports_nums' => json_encode($export_authorize_reports_nums),
                'export_authorize_path' => json_encode($export_authorize_path),
            ];
            $exportInsert = ExportAuthorizeRecords::create($exportAuthRecord);
            $export_id = $exportInsert->id;
        }

        $data_id_string = implode(',', $data_id);
        $detection_reports = DetectionReport::whereIn('id', $data_id)->orderByRaw("FIELD(id, $data_id_string)")->get();
        foreach ($detection_reports as $index => $value) {
            if ($value->reports_authorize_count_current < $value->reports_authorize_count_before) {
                $value->reports_authorize_count_current = ($value->reports_authorize_count_before + 1);
            } else {
                $value->reports_authorize_count_current += 1;
            }
            $reports_regulations = '';
            foreach ($value->reports_regulations as $i => $info) {
                $regulation = Regulations::where('regulations_num', $info)->first();
                if ($i == 0) {
                    $reports_regulations .= $info . ' ' . $regulation->regulations_name;
                } else {
                    $reports_regulations .= ', ' . $info . ' ' . $regulation->regulations_name;
                }
            }
            $expiration_date = Carbon::parse($value->reports_expiration_date_end);
            $expiration_date_y = ((int)$expiration_date->year) - 1911;
            $expiration_date_m = str_pad($expiration_date->month, 2, "0", STR_PAD_LEFT);
            $expiration_date_d = str_pad($expiration_date->day, 2, "0", STR_PAD_LEFT);
            $fe = '';
            if ($value->reports_f_e != null) $fe = $value->reports_f_e;
            $authorize_sid = $value->reports_num . '-Y' . $fe . $expiration_date_y . $expiration_date_m . $expiration_date_d . '-' . str_pad($value->reports_authorize_count_current, 3, "0", STR_PAD_LEFT);
            array_push($tb_values, [
                'reports_regulations' => $reports_regulations,
                'reports_num' => $value->reports_num,
                'reports_authorize_sid' => $authorize_sid,
            ]);
            array_push($export_authorize_auth_num_id, $authorize_sid);
            array_push($export_authorize_reports_nums, $value->reports_num);

            $value->save();

            // 同意授權使用證明書記錄 逐個新增紀錄
            $agreeAuthRecord = [
                'export_id' => $export_id,
                'reports_id' => $value->id,
                'authorize_num' => $auth_input[4],
                'reports_num' => $value->reports_num,
                'authorize_date' => $date_m . '/' . $date_d,
                'authorize_year' => $authorize_date->year,
                'car_brand_id' => $auth_input[1],
                'car_model_id' => $auth_input[2],
                'reports_vin' => $auth_input[3],
                'reports_regulations' => json_encode($value->reports_regulations),
                'licensee' => $auth_input[0],
                'Invoice_title' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
            AgreeAuthorizeRecords::insert($agreeAuthRecord);

            $caur = [
                'export_id' => $export_id,
                'authorization_serial_number' => $value->reports_authorize_count_current,
                'reports_id' => $value->id,
                'authorize_num' => $auth_input[4],
                'reports_num' => $value->reports_num,
                'applicant' => $value->reports_reporter,
                'reports_vin' => $auth_input[3],
                'quantity' => 1,
                'authorization_date' => $date_y . '/' . $date_m . '/' . $date_d,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
            CumulativeAuthorizedUsageRecords::insert($caur);

        }

        // dd($tb_values);

        $brand = CarBrand::find($auth_input[1]);
        $model = CarModel::find($auth_input[2]);
        $templateProcessor->setValue('authorize_com', $auth_input[0]);
        $templateProcessor->setValue('authorize_brand', $brand->brand_name);
        $templateProcessor->setValue('authorize_model', $model->model_name);
        $templateProcessor->setValue('authorize_vin', $auth_input[3]);
        $templateProcessor->setValue('auth_num', $auth_input[4]);

        $templateProcessor->cloneRowAndSetValues('reports_regulations', $tb_values);

        $templateProcessor->setValue('a_y', $date_y);
        $templateProcessor->setValue('a_m', $date_m);
        $templateProcessor->setValue('a_d', $date_d);

        $company = Company::first();
        $templateProcessor->setImageValue('image_sign_com', ["path" => public_path('uploads/'.$company->com_seal), "width" => 280, "height" => '']);
        // $templateProcessor->setImageValue('image_sign_com', ["path" => public_path('assets/img/sign_test_icon/sign_com.png'), "width" => 150, "height" => '']);

        $time = Carbon::now();
        $fullTime = $time->format('Y-m-d_H-i-s');
        $month_year = $time->format('Ym');

        $wordName = '/授權書_' . $auth_input[0] . '_' . $fullTime . '.docx';
        $pdfName = '/授權書_' . $auth_input[0] . '_' . $fullTime . '.pdf';

        $folderWordPath = 'files/autorize/word/' . $month_year;
        $folderPdfPath = 'files/autorize/pdf/' . $month_year;

        $fullWordPath = $folderWordPath . $wordName;
        $fullPdfPath = $folderPdfPath . $pdfName;

        $newWordFilePath = public_path($fullWordPath);
        $newPdfFilePath = public_path($fullPdfPath);

        if (!File::exists($folderWordPath)) {
            File::makeDirectory($folderWordPath, 0777, true); // 使用 File 類別建立資料夾
        }

        if (!File::exists($folderPdfPath)) {
            File::makeDirectory($folderPdfPath, 0777, true); // 使用 File 類別建立資料夾
        }

        $templateProcessor->saveAs($newWordFilePath);


        $export_authorize_path = [
            'authorize_file_name' => '授權書_' . $auth_input[0] . '_' . $fullTime,
            'word' => $fullWordPath,
            'pdf' => $fullPdfPath,
        ];
        $exportAuthRecord = [
            'reports_ids' => json_encode($data_id),
            'export_authorize_num' => $auth_input[4],
            'export_authorize_com' => $auth_input[0],
            'export_authorize_brand' => $auth_input[1],
            'export_authorize_model' => $auth_input[2],
            'export_authorize_vin' => $auth_input[3],
            'export_authorize_auth_num_id' => json_encode($export_authorize_auth_num_id), // 授權序號
            'export_authorize_reports_nums' => json_encode($export_authorize_reports_nums),
            'export_authorize_path' => json_encode($export_authorize_path),
        ];
        ExportAuthorizeRecords::where('id', $export_id)->update($exportAuthRecord);

        $key2 = ['publicKey' => 'project_public_0972a67458e4dd3ac4561edec19a48ed_pWfxHf7de3bcb072e2b66fc59b5cf8ded47d7', 'secretKey' => 'secret_key_f428272dfee9a265364aeadf9d895a8a_UMGYM186d525137876fd82fbc8a61f341c725'];
        $key0 = ['publicKey' => 'project_public_f836502ed5f152f32db3c629ea4e5e82_MGHoj609fd77dc53495844616498db7ad600c', 'secretKey' => 'secret_key_aa4949f7e3438233c7616c9d2dc9aed9_B1lHnd6b086e1d99ace45e9cec81f8b2c8d97'];
        $key1 = ['publicKey' => 'project_public_a2b3acf35565b86653184bfb72cbe84f_OA2Umd21be5a86ceee9d663ccd7719e1133cf', 'secretKey' => 'secret_key_cc3a4552e6a37a60ed0ad49fe054ff57_ccgD2bc2e2820e351f8f860332455148ce8e0'];

        $pdfKey = [$key0, $key1, $key2];

        $maxAttempts = 3; // 最大重試次數
        $attempts = 0; // 目前的嘗試次數

        while ($attempts < $maxAttempts) {

            $ilovepdf = new Ilovepdf($pdfKey[$attempts]['publicKey'], $pdfKey[$attempts]['secretKey']);
            try {
                // 嘗試要執行的操作
                // 例如：資料庫查詢、外部API調用等
                $myTask = $ilovepdf->newTask('officepdf');
                $file1 = $myTask->addFile($newWordFilePath);
                $myTask->execute();
                $myTask->download(public_path($folderPdfPath));

                break; // 如果操作成功，跳出循環
            } catch (\Exception $e) {
                $attempts++; // 增加嘗試次數
                if ($attempts == $maxAttempts) {
                    // 如果達到最大嘗試次數，可以選擇拋出異常或者處理錯誤
                    throw $e;
                }

                // 可選：在重試之前暫停一段時間
                sleep(1); // 休息1秒
            }
        }


        // return json_encode([
        //     'status' => 'success',
        //     'file_name' => '申請函_' . $reports_reporter->reporter_name . '_' . $fullTime,
        //     'word' => $fullWordPath,
        //     'pdf' => $fullPdfPath,
        // ]);
        return \Response::json([
            'authorize_file_name' => '授權書_' . $auth_input[0] . '_' . $fullTime,
            'word' => $fullWordPath,
            'pdf' => $fullPdfPath,
        ]);
    }

    public function setMoveOutAffidavit($data_id, $filePath)
    {
        $templateProcessor = new TemplateProcessor($filePath);

        $detection_reports = DetectionReport::whereIn('id', $data_id)->get();

        $reports_reporter = Reporter::find($detection_reports[0]->reports_reporter);

        $templateProcessor->setValue('reports_reporter', $reports_reporter->reporter_name);
        $templateProcessor->setValue('reporter_num', $reports_reporter->reporter_gui_number);
        $templateProcessor->setValue('reporter_address', $reports_reporter->reporter_address);
        $templateProcessor->setValue('reporter_phone', $reports_reporter->reporter_phone);
        $templateProcessor->setValue('reporter_fax', $reports_reporter->reporter_fax);
        $templateProcessor->setImageValue('image_sign_reporter', public_path('uploads/'.$reports_reporter->reporter_seal));
        // $templateProcessor->setImageValue('image_sign_reporter', public_path('assets/img/sign_test_icon/sign_com.png'));

        $company = Company::first();
        $templateProcessor->setValue('com_name', $company->com_name);
        $templateProcessor->setValue('com_gui_number', $company->com_gui_number);
        $templateProcessor->setValue('com_address', $company->com_address);
        $templateProcessor->setValue('com_phone', $company->com_phone);
        $templateProcessor->setValue('com_fax', $company->com_fax);
        $templateProcessor->setImageValue('image_sign_com', public_path('uploads/'.$company->com_seal));
        // $templateProcessor->setImageValue('image_sign_com', public_path('assets/img/sign_test_icon/sign_com.png'));

        $reports_date = Carbon::today();

        $start_date_y = ((int)$reports_date->year) - 1911;
        $start_date_m = $reports_date->month;
        $start_date_d = $reports_date->day;
        $templateProcessor->setValue('rps_y', $start_date_y);
        $templateProcessor->setValue('rps_m', $start_date_m);
        $templateProcessor->setValue('rps_d', $start_date_d);

        // $reports_expiration_date_end = Carbon::parse($detection_reports[0]->reports_expiration_date_end);
        // $expiration_date_y = ((int)$reports_expiration_date_end->year) - 1911;
        // $expiration_date_m = $reports_expiration_date_end->month;
        // $expiration_date_d = $reports_expiration_date_end->day;
        // $templateProcessor->setValue('rpt_y', $expiration_date_y);
        // $templateProcessor->setValue('rpt_m', $expiration_date_m);
        // $templateProcessor->setValue('rpt_d', $expiration_date_d);

        $tb_values = array();

        foreach ($detection_reports as $index => $value) {
            $reports_regulations = '';
            foreach ($value->reports_regulations as $i => $info) {
                if ($i == 0) {
                    $reports_regulations .= $info;
                } else {
                    $reports_regulations .= ', ' . $info;
                }
            }
            array_push($tb_values, [
                'reports_index' => ($index + 1),
                'reports_num' => $value->reports_num,
                // 'reports_regulations' => $reports_regulations,
                // 'reports_self_count' => '0',
                'reports_authorize_count_before' => $value->reports_authorize_count_before,
                'reports_authorize_count_after' => $value->reports_authorize_count_current - (int) $value->reports_authorize_count_before,
                'reports_authorize_count_total' => ($value->reports_authorize_count_current - (int) $value->reports_authorize_count_before) + (int) $value->reports_authorize_count_before
            ]);
        }

        // dd($tb_values);

        $templateProcessor->cloneRowAndSetValues('reports_index', $tb_values);

        $time = Carbon::now();
        $fullTime = $time->format('Y-m-d_H-i-s');
        $month_year = $time->format('Ym');

        $wordName = '/檢測報告移出協會切結書_' . $reports_reporter->reporter_name . '_' . $fullTime . '.docx';
        $pdfName = '/檢測報告移出協會切結書_' . $reports_reporter->reporter_name . '_' . $fullTime . '.pdf';

        $folderWordPath = 'files/affidavit/' . $reports_reporter->reporter_name . '/word/' . $month_year;
        $folderPdfPath = 'files/affidavit/' . $reports_reporter->reporter_name . '/pdf/' . $month_year;

        $fullWordPath = $folderWordPath . $wordName;
        $fullPdfPath = $folderPdfPath . $pdfName;

        $newWordFilePath = public_path($fullWordPath);
        $newPdfFilePath = public_path($fullPdfPath);

        if (!File::exists($folderWordPath)) {
            File::makeDirectory($folderWordPath, 0777, true); // 使用 File 類別建立資料夾
        }

        if (!File::exists($folderPdfPath)) {
            File::makeDirectory($folderPdfPath, 0777, true); // 使用 File 類別建立資料夾
        }

        $templateProcessor->saveAs($newWordFilePath);

        $key2 = ['publicKey' => 'project_public_0972a67458e4dd3ac4561edec19a48ed_pWfxHf7de3bcb072e2b66fc59b5cf8ded47d7', 'secretKey' => 'secret_key_f428272dfee9a265364aeadf9d895a8a_UMGYM186d525137876fd82fbc8a61f341c725'];
        $key0 = ['publicKey' => 'project_public_f836502ed5f152f32db3c629ea4e5e82_MGHoj609fd77dc53495844616498db7ad600c', 'secretKey' => 'secret_key_aa4949f7e3438233c7616c9d2dc9aed9_B1lHnd6b086e1d99ace45e9cec81f8b2c8d97'];
        $key1 = ['publicKey' => 'project_public_a2b3acf35565b86653184bfb72cbe84f_OA2Umd21be5a86ceee9d663ccd7719e1133cf', 'secretKey' => 'secret_key_cc3a4552e6a37a60ed0ad49fe054ff57_ccgD2bc2e2820e351f8f860332455148ce8e0'];

        $pdfKey = [$key0, $key1, $key2];

        $maxAttempts = 3; // 最大重試次數
        $attempts = 0; // 目前的嘗試次數

        while ($attempts < $maxAttempts) {

            $ilovepdf = new Ilovepdf($pdfKey[$attempts]['publicKey'], $pdfKey[$attempts]['secretKey']);
            try {
                // 嘗試要執行的操作
                // 例如：資料庫查詢、外部API調用等
                $myTask = $ilovepdf->newTask('officepdf');
                $file1 = $myTask->addFile($newWordFilePath);
                $myTask->execute();
                $myTask->download(public_path($folderPdfPath));

                break; // 如果操作成功，跳出循環
            } catch (\Exception $e) {
                $attempts++; // 增加嘗試次數
                if ($attempts == $maxAttempts) {
                    // 如果達到最大嘗試次數，可以選擇拋出異常或者處理錯誤
                    throw $e;
                }

                // 可選：在重試之前暫停一段時間
                sleep(1); // 休息1秒
            }
        }

        // return json_encode([
        //     'status' => 'success',
        //     'file_name' => '檢測報告移出協會切結書_' . $reports_reporter->reporter_name . '_' . $fullTime,
        //     'word' => $fullWordPath,
        //     'pdf' => $fullPdfPath,
        // ]);
        return \Response::json([
            'affidavit_file_name' => '檢測報告移出協會切結書_' . $reports_reporter->reporter_name . '_' . $fullTime,
            'word' => $fullWordPath,
            'pdf' => $fullPdfPath,
        ]);
    }

    public function setAffidavitLetter($data_id, $filePath)
    {
        $templateProcessor = new TemplateProcessor($filePath);

        $detection_reports = DetectionReport::whereIn('id', $data_id)->get();

        $reports_letter_id= $detection_reports[0]->letter_id;

        $reports_date = Carbon::today();
        $date_y = ((int)$reports_date->year) - 1911;
        $date_m = str_pad($reports_date->month, 2, "0", STR_PAD_LEFT);
        $date_d = str_pad($reports_date->day, 2, "0", STR_PAD_LEFT);

        $templateProcessor->setValue('rf_y', $date_y);
        $templateProcessor->setValue('rf_m', $date_m);
        $templateProcessor->setValue('rf_d', $date_d);
        $templateProcessor->setValue('rf_letter_id', $reports_letter_id);
        $templateProcessor->setValue('rf_count', count($detection_reports));

        $time = Carbon::now();
        $fullTime = $time->format('Y-m-d_H-i-s');
        $month_year = $time->format('Ym');

        $wordName = '/檢測報告移出函文_' . $fullTime . '.docx';
        $pdfName = '/檢測報告移出函文_' . $fullTime . '.pdf';

        $folderWordPath = 'files/affidavit_letter/word/' . $month_year;
        $folderPdfPath = 'files/affidavit_letter/pdf/' . $month_year;

        $fullWordPath = $folderWordPath . $wordName;
        $fullPdfPath = $folderPdfPath . $pdfName;

        $newWordFilePath = public_path($fullWordPath);
        $newPdfFilePath = public_path($fullPdfPath);

        if (!File::exists($folderWordPath)) {
            File::makeDirectory($folderWordPath, 0777, true); // 使用 File 類別建立資料夾
        }

        if (!File::exists($folderPdfPath)) {
            File::makeDirectory($folderPdfPath, 0777, true); // 使用 File 類別建立資料夾
        }

        $templateProcessor->saveAs($newWordFilePath);

        $key2 = ['publicKey' => 'project_public_0972a67458e4dd3ac4561edec19a48ed_pWfxHf7de3bcb072e2b66fc59b5cf8ded47d7', 'secretKey' => 'secret_key_f428272dfee9a265364aeadf9d895a8a_UMGYM186d525137876fd82fbc8a61f341c725'];
        $key0 = ['publicKey' => 'project_public_f836502ed5f152f32db3c629ea4e5e82_MGHoj609fd77dc53495844616498db7ad600c', 'secretKey' => 'secret_key_aa4949f7e3438233c7616c9d2dc9aed9_B1lHnd6b086e1d99ace45e9cec81f8b2c8d97'];
        $key1 = ['publicKey' => 'project_public_a2b3acf35565b86653184bfb72cbe84f_OA2Umd21be5a86ceee9d663ccd7719e1133cf', 'secretKey' => 'secret_key_cc3a4552e6a37a60ed0ad49fe054ff57_ccgD2bc2e2820e351f8f860332455148ce8e0'];

        $pdfKey = [$key0, $key1, $key2];

        $maxAttempts = 3; // 最大重試次數
        $attempts = 0; // 目前的嘗試次數

        while ($attempts < $maxAttempts) {

            $ilovepdf = new Ilovepdf($pdfKey[$attempts]['publicKey'], $pdfKey[$attempts]['secretKey']);
            try {
                // 嘗試要執行的操作
                // 例如：資料庫查詢、外部API調用等
                $myTask = $ilovepdf->newTask('officepdf');
                $file1 = $myTask->addFile($newWordFilePath);
                $myTask->execute();
                $myTask->download(public_path($folderPdfPath));

                break; // 如果操作成功，跳出循環
            } catch (\Exception $e) {
                $attempts++; // 增加嘗試次數
                if ($attempts == $maxAttempts) {
                    // 如果達到最大嘗試次數，可以選擇拋出異常或者處理錯誤
                    throw $e;
                }

                // 可選：在重試之前暫停一段時間
                sleep(1); // 休息1秒
            }
        }

        // return json_encode([
        //     'status' => 'success',
        //     'file_name' => '檢測報告移出函文_' . $reports_reporter->reporter_name . '_' . $fullTime,
        //     'word' => $fullWordPath,
        //     'pdf' => $fullPdfPath,
        // ]);
        return \Response::json([
            'affidavit_letter_file_name' => '檢測報告移出函文_' . $fullTime,
            'word' => $fullWordPath,
            'pdf' => $fullPdfPath,
        ]);
    }

    public function setDataAffidavitExcel($data_id)
    {
        $time = Carbon::now();
        $fullTime = $time->format('Y-m-d_H-i-s');
        $month_year = $time->format('Ym');

        $fileName = '附件一、檢測報告移出清冊 移出 (' . count($data_id) . ') _' . $fullTime . '.xlsx';

        $folderPath = 'files/affidavit＿excel/' . $month_year;

        if (!File::exists($folderPath)) {
            File::makeDirectory($folderPath, 0777, true); // 使用 File 類別建立資料夾
        }

        // 將檔案保存到 public 目錄下
        $path = Excel::store(new DetectionReportExport($data_id), $folderPath . '/'. $fileName, 's2');

        // return json_encode([
        //     'status' => 'success',
        //     'path' => $folderPath . '/'. $fileName,
        // ]);
        return \Response::json([
            'data_affidavit_file_name' => '附件一、檢測報告移出清冊 移出 (' . count($data_id) . ') _' . $fullTime,
            'excel' => $folderPath . '/'. $fileName,
        ]);
    }

    public function setPostponeContract($data_id, $filePath)
    {

        $templateProcessor = new TemplateProcessor($filePath);

        $data_id_string = implode(',', $data_id);
        $detection_reports = DetectionReport::whereIn('id', $data_id)->orderByRaw("FIELD(id, $data_id_string)")->get();

        $reports_reporter = Reporter::find($detection_reports[0]->reports_reporter);

        $templateProcessor->setValue('reports_reporter', $reports_reporter->reporter_name);
        $templateProcessor->setValue('reporter_num', $reports_reporter->reporter_gui_number);
        $templateProcessor->setValue('reporter_address', $reports_reporter->reporter_address);
        $templateProcessor->setValue('reporter_phone', $reports_reporter->reporter_phone);
        $templateProcessor->setValue('reporter_fax', $reports_reporter->reporter_fax);
        $templateProcessor->setImageValue('image_sign_reporter', public_path('uploads/'.$reports_reporter->reporter_seal));
        // $templateProcessor->setImageValue('image_sign_reporter', public_path('assets/img/sign_test_icon/sign_com.png'));

        $company = Company::first();
        $templateProcessor->setValue('com_name', $company->com_name);
        $templateProcessor->setValue('com_gui_number', $company->com_gui_number);
        $templateProcessor->setValue('com_address', $company->com_address);
        $templateProcessor->setValue('com_phone', $company->com_phone);
        $templateProcessor->setValue('com_fax', $company->com_fax);
        $templateProcessor->setImageValue('image_sign_com', public_path('uploads/'.$company->com_seal));
        // $templateProcessor->setImageValue('image_sign_com', public_path('assets/img/sign_test_icon/sign_com.png'));

        $reports_date = Carbon::today();

        $start_date_y = ((int)$reports_date->year) - 1911;
        $start_date_m = $reports_date->month;
        $start_date_d = $reports_date->day;
        $templateProcessor->setValue('rpf_y', $start_date_y);
        $templateProcessor->setValue('rpf_m', $start_date_m);
        $templateProcessor->setValue('rpf_d', $start_date_d);
        $templateProcessor->setValue('rps_y', $start_date_y);
        $templateProcessor->setValue('rps_m', $start_date_m);
        $templateProcessor->setValue('rps_d', $start_date_d);

        $reports_expiration_date_end = Carbon::parse($detection_reports[0]->reports_expiration_date_end);
        $expiration_date_y = ((int)$reports_expiration_date_end->year) - 1911;
        $expiration_date_m = $reports_expiration_date_end->month;
        $expiration_date_d = $reports_expiration_date_end->day;
        $templateProcessor->setValue('rpt_y', $expiration_date_y);
        $templateProcessor->setValue('rpt_m', $expiration_date_m);
        $templateProcessor->setValue('rpt_d', $expiration_date_d);

        $tb_values = array();

        foreach ($detection_reports as $index => $value) {
            $reports_regulations = '';
            foreach ($value->reports_regulations as $i => $info) {
                if ($i == 0) {
                    $reports_regulations .= $info;
                } else {
                    $reports_regulations .= ', ' . $info;
                }
            }
            array_push($tb_values, [
                'reports_index' => ($index + 1),
                'reports_num' => $value->reports_num,
                'reports_regulations' => $reports_regulations
            ]);
        }

        // dd($tb_values);

        $templateProcessor->cloneRowAndSetValues('reports_index', $tb_values);

        $time = Carbon::now();
        $fullTime = $time->format('Y-m-d_H-i-s');
        $month_year = $time->format('Ym');

        $wordName = '/檢測報告移入協會合約書_' . $reports_reporter->reporter_name . '_' . $fullTime . '.docx';
        $pdfName = '/檢測報告移入協會合約書_' . $reports_reporter->reporter_name . '_' . $fullTime . '.pdf';

        $folderWordPath = 'files/postpone_contract/' . $reports_reporter->reporter_name . '/word/' . $month_year;
        $folderPdfPath = 'files/postpone_contract/' . $reports_reporter->reporter_name . '/pdf/' . $month_year;

        $fullWordPath = $folderWordPath . $wordName;
        $fullPdfPath = $folderPdfPath . $pdfName;

        $newWordFilePath = public_path($fullWordPath);
        $newPdfFilePath = public_path($fullPdfPath);

        if (!File::exists($folderWordPath)) {
            File::makeDirectory($folderWordPath, 0777, true); // 使用 File 類別建立資料夾
        }

        if (!File::exists($folderPdfPath)) {
            File::makeDirectory($folderPdfPath, 0777, true); // 使用 File 類別建立資料夾
        }

        $templateProcessor->saveAs($newWordFilePath);

        $key2 = ['publicKey' => 'project_public_0972a67458e4dd3ac4561edec19a48ed_pWfxHf7de3bcb072e2b66fc59b5cf8ded47d7', 'secretKey' => 'secret_key_f428272dfee9a265364aeadf9d895a8a_UMGYM186d525137876fd82fbc8a61f341c725'];
        $key0 = ['publicKey' => 'project_public_f836502ed5f152f32db3c629ea4e5e82_MGHoj609fd77dc53495844616498db7ad600c', 'secretKey' => 'secret_key_aa4949f7e3438233c7616c9d2dc9aed9_B1lHnd6b086e1d99ace45e9cec81f8b2c8d97'];
        $key1 = ['publicKey' => 'project_public_a2b3acf35565b86653184bfb72cbe84f_OA2Umd21be5a86ceee9d663ccd7719e1133cf', 'secretKey' => 'secret_key_cc3a4552e6a37a60ed0ad49fe054ff57_ccgD2bc2e2820e351f8f860332455148ce8e0'];

        $pdfKey = [$key0, $key1, $key2];

        $maxAttempts = 3; // 最大重試次數
        $attempts = 0; // 目前的嘗試次數

        while ($attempts < $maxAttempts) {

            $ilovepdf = new Ilovepdf($pdfKey[$attempts]['publicKey'], $pdfKey[$attempts]['secretKey']);
            try {
                // 嘗試要執行的操作
                // 例如：資料庫查詢、外部API調用等
                $myTask = $ilovepdf->newTask('officepdf');
                $file1 = $myTask->addFile($newWordFilePath);
                $myTask->execute();
                $myTask->download(public_path($folderPdfPath));

                break; // 如果操作成功，跳出循環
            } catch (\Exception $e) {
                $attempts++; // 增加嘗試次數
                if ($attempts == $maxAttempts) {
                    // 如果達到最大嘗試次數，可以選擇拋出異常或者處理錯誤
                    throw $e;
                }

                // 可選：在重試之前暫停一段時間
                sleep(1); // 休息1秒
            }
        }

        // return json_encode([
        //     'status' => 'success',
        //     'file_name' => '檢測報告移入協會合約書_' . $reports_reporter->reporter_name . '_' . $fullTime,
        //     'word' => $fullWordPath,
        //     'pdf' => $fullPdfPath,
        // ]);
        return \Response::json([
            'postpone_contract_file_name' => '檢測報告移入協會合約書_' . $reports_reporter->reporter_name . '_' . $fullTime,
            'word' => $fullWordPath,
            'pdf' => $fullPdfPath,
        ]);
    }

    public function setPostponeApplicationLetter($data_id, $filePath)
    {

        $templateProcessor = new TemplateProcessor($filePath);

        $data_id_string = implode(',', $data_id);
        $detection_reports = DetectionReport::whereIn('id', $data_id)->orderByRaw("FIELD(id, $data_id_string)")->get();

        $reports_letter_id= $detection_reports[0]->letter_id;

        $reports_date = Carbon::today();
        $date_y = ((int)$reports_date->year) - 1911;
        $date_m = str_pad($reports_date->month, 2, "0", STR_PAD_LEFT);
        $date_d = str_pad($reports_date->day, 2, "0", STR_PAD_LEFT);

        $templateProcessor->setValue('rf_y', $date_y);
        $templateProcessor->setValue('rf_m', $date_m);
        $templateProcessor->setValue('rf_d', $date_d);
        $templateProcessor->setValue('rf_letter_id', $reports_letter_id);
        $templateProcessor->setValue('rf_count', count($detection_reports));

        $time = Carbon::now();
        $fullTime = $time->format('Y-m-d_H-i-s');
        $month_year = $time->format('Ym');

        $wordName = '/展延申請函_' . $fullTime . '.docx';
        $pdfName = '/展延申請函_' . $fullTime . '.pdf';

        $folderWordPath = 'files/postpone_letter/word/' . $month_year;
        $folderPdfPath = 'files/postpone_letter/pdf/' . $month_year;

        $fullWordPath = $folderWordPath . $wordName;
        $fullPdfPath = $folderPdfPath . $pdfName;

        $newWordFilePath = public_path($fullWordPath);
        $newPdfFilePath = public_path($fullPdfPath);

        if (!File::exists($folderWordPath)) {
            File::makeDirectory($folderWordPath, 0777, true); // 使用 File 類別建立資料夾
        }

        if (!File::exists($folderPdfPath)) {
            File::makeDirectory($folderPdfPath, 0777, true); // 使用 File 類別建立資料夾
        }

        $templateProcessor->saveAs($newWordFilePath);

        $key2 = ['publicKey' => 'project_public_0972a67458e4dd3ac4561edec19a48ed_pWfxHf7de3bcb072e2b66fc59b5cf8ded47d7', 'secretKey' => 'secret_key_f428272dfee9a265364aeadf9d895a8a_UMGYM186d525137876fd82fbc8a61f341c725'];
        $key0 = ['publicKey' => 'project_public_f836502ed5f152f32db3c629ea4e5e82_MGHoj609fd77dc53495844616498db7ad600c', 'secretKey' => 'secret_key_aa4949f7e3438233c7616c9d2dc9aed9_B1lHnd6b086e1d99ace45e9cec81f8b2c8d97'];
        $key1 = ['publicKey' => 'project_public_a2b3acf35565b86653184bfb72cbe84f_OA2Umd21be5a86ceee9d663ccd7719e1133cf', 'secretKey' => 'secret_key_cc3a4552e6a37a60ed0ad49fe054ff57_ccgD2bc2e2820e351f8f860332455148ce8e0'];

        $pdfKey = [$key0, $key1, $key2];

        $maxAttempts = 3; // 最大重試次數
        $attempts = 0; // 目前的嘗試次數

        while ($attempts < $maxAttempts) {

            $ilovepdf = new Ilovepdf($pdfKey[$attempts]['publicKey'], $pdfKey[$attempts]['secretKey']);
            try {
                // 嘗試要執行的操作
                // 例如：資料庫查詢、外部API調用等
                $myTask = $ilovepdf->newTask('officepdf');
                $file1 = $myTask->addFile($newWordFilePath);
                $myTask->execute();
                $myTask->download(public_path($folderPdfPath));

                break; // 如果操作成功，跳出循環
            } catch (\Exception $e) {
                $attempts++; // 增加嘗試次數
                if ($attempts == $maxAttempts) {
                    // 如果達到最大嘗試次數，可以選擇拋出異常或者處理錯誤
                    throw $e;
                }

                // 可選：在重試之前暫停一段時間
                sleep(1); // 休息1秒
            }
        }

        // return json_encode([
        //     'status' => 'success',
        //     'file_name' => '申請函_' . $reports_reporter->reporter_name . '_' . $fullTime,
        //     'word' => $fullWordPath,
        //     'pdf' => $fullPdfPath,
        // ]);
        return \Response::json([
            'postpone_apply_letter_file_name' => '展延申請函_' . $fullTime,
            'word' => $fullWordPath,
            'pdf' => $fullPdfPath,
        ]);
    }

    public function setDataPostponeExcel($data_id)
    {
        $time = Carbon::now();
        $fullTime = $time->format('Y-m-d_H-i-s');
        $month_year = $time->format('Ym');

        $fileName = '附件一、檢測報告展延清冊 展延 (' . count($data_id) . ') _' . $fullTime . '.xlsx';

        $folderPath = 'files/postpone_excel/' . $month_year;

        if (!File::exists($folderPath)) {
            File::makeDirectory($folderPath, 0777, true); // 使用 File 類別建立資料夾
        }

        // 將檔案保存到 public 目錄下
        $path = Excel::store(new DetectionReportExport($data_id), $folderPath . '/'. $fileName, 's2');

        // return json_encode([
        //     'status' => 'success',
        //     'path' => $folderPath . '/'. $fileName,
        // ]);
        return \Response::json([
            'data_postpone_file_name' => '附件一、檢測報告展延清冊 展延 (' . count($data_id) . ') _' . $fullTime,
            'excel' => $folderPath . '/'. $fileName,
        ]);
    }
}
