<?php

namespace App\Services;

use PhpOffice\PhpWord\TemplateProcessor;
// use PhpOffice\PhpWord\IOFactory;
// use PhpOffice\PhpWord\PhpWord;
// use PhpOffice\PhpWord\Writer\PDF;
use App\Models\Admin\DetectionReport;
use App\Models\Admin\Reporter;
use App\Models\Admin\CompanyInfo as Company;
use stdClass;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\File;
use Ilovepdf\Ilovepdf;

class WordServices
{
    function updateWordDocument($fileType = null, $data_id, $options = array())
    {
        switch ($fileType) {
            case 'move_in_contract': // 檢測報告移入合約書
                $templatefileName = 'Template_檢測報告移入協會合約書.docx';
                $templatefilePath = public_path('template_doc/' . $templatefileName);
                return $this->setMoveInContract($data_id, $templatefilePath, $templatefileName);
                break;
            case 'application_letter': // 申請函
                break;
            default:
                $templatefileName = 'Template_檢測報告移入協會合約書.docx';
                $templatefilePath = public_path('template_doc/' . $templatefileName);
                break;
        }
    }

    public function setMoveInContract($data_id, $filePath) {

        $templateProcessor = new TemplateProcessor($filePath);

        $detection_reports = DetectionReport::whereIn('id', $data_id)->get();

        $reports_reporter = Reporter::find($detection_reports[0]->reports_reporter);

        $templateProcessor->setValue('reports_reporter', $reports_reporter->reporter_name);
        $templateProcessor->setValue('reporter_num', $reports_reporter->reporter_gui_number);
        $templateProcessor->setValue('reporter_address', $reports_reporter->reporter_address);
        $templateProcessor->setValue('reporter_phone', $reports_reporter->reporter_phone);
        $templateProcessor->setValue('reporter_fax', $reports_reporter->reporter_fax);
        $templateProcessor->setImageValue('image_sign_reporter', public_path('uploads/'.$reports_reporter->repoter_seal));

        $company = Company::first();
        $templateProcessor->setValue('com_name', $company->com_name);
        $templateProcessor->setValue('com_gui_number', $company->com_gui_number);
        $templateProcessor->setValue('com_address', $company->com_address);
        $templateProcessor->setValue('com_phone', $company->com_phone);
        $templateProcessor->setValue('com_fax', $company->com_fax);
        $templateProcessor->setImageValue('image_sign_com', public_path('uploads/'.$company->com_seal));

        $reports_date = Carbon::today();

        $start_date_y = ((Int)$reports_date->year) - 1911;
        $start_date_m = $reports_date->month;
        $start_date_d = $reports_date->day;
        $templateProcessor->setValue('rpf_y', $start_date_y);
        $templateProcessor->setValue('rpf_m', $start_date_m);
        $templateProcessor->setValue('rpf_d', $start_date_d);
        $templateProcessor->setValue('rps_y', $start_date_y);
        $templateProcessor->setValue('rps_m', $start_date_m);
        $templateProcessor->setValue('rps_d', $start_date_d);

        $reports_expiration_date_end = Carbon::parse($detection_reports[0]->reports_expiration_date_end);
        $expiration_date_y = ((Int)$reports_expiration_date_end->year) - 1911;
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
                'reports_index' => $index,
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

        $folderWordPath = 'files/contract_test/'.$reports_reporter->reporter_name.'/word/'.$month_year;
        $folderPdfPath = 'files/contract_test/'.$reports_reporter->reporter_name.'/pdf/'.$month_year;

        $fullWordPath = $folderWordPath . $wordName;
        $fullPdfPath = $folderPdfPath . $pdfName;

        $newWordFilePath = public_path($fullWordPath);
        $newPdfFilePath = public_path($fullPdfPath);

        if (!File::exists($folderWordPath)) {
            File::makeDirectory($folderWordPath, 0777, true);// 使用 File 類別建立資料夾
        }

        if (!File::exists($folderPdfPath)) {
            File::makeDirectory($folderPdfPath, 0777, true); // 使用 File 類別建立資料夾
        }

        $templateProcessor->saveAs($newWordFilePath);

        $ilovepdf = new Ilovepdf('project_public_0972a67458e4dd3ac4561edec19a48ed_pWfxHf7de3bcb072e2b66fc59b5cf8ded47d7','secret_key_f428272dfee9a265364aeadf9d895a8a_UMGYM186d525137876fd82fbc8a61f341c725');
        $myTask = $ilovepdf->newTask('officepdf');
        $file1 = $myTask->addFile($newWordFilePath);
        $myTask->execute();
        $myTask->download(public_path($folderPdfPath));

        return json_encode([
            'status' => 'success',
            'file_name' => '檢測報告移入協會合約書_' . $reports_reporter->reporter_name . '_' . $fullTime,
            'word' => $fullWordPath,
            'pdf' => $fullPdfPath,
        ]);
    }

    public function setApplicationLetter($data_id, $filePath) {

    }
}
