<?php

namespace App\Http\Controllers\Admin;

use App\Exports\DetectionReportExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreDetectionReportRequest;
use App\Http\Requests\Admin\UpdateDetectionReportRequest;
use App\Models\Admin\DetectionReport;
use App\Models\Admin\AuthorizeStatus as AuthStatus;
use App\Models\Admin\CarBrand;
use App\Models\Admin\CarModel;
use App\Models\Admin\Regulations;
use App\Models\Admin\Reporter;
use App\Models\Admin\InspectionInstitution;
use App\Repositories\Admin\DetectionReportRepository as DetectionReportRep;
use Illuminate\Http\Request;
use Flash;
use Response;
use App\Services\WordServices;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Ilovepdf\Ilovepdf;
use ImageManager;
use Maatwebsite\Excel\Facades\Excel;

class DetectionReportController extends Controller
{
    private $detectionReportRep;

    public function __construct(DetectionReportRep $detectionReportRep)
    {
        $this->detectionReportRep = $detectionReportRep;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->detectionReportRep::autoCheckAuthorizedStatus();
        //
        // $model = DetectionReport::orderBy('updated_at', 'DESC')->paginate(15);
        $model = DetectionReport::orderBy('updated_at', 'DESC')->get();
        // $model = $this->detectionReportRepository->getAllDetectionReports();

        return view('admin.detection_report.index', ['detectionReports' => $model]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $auth_status = AuthStatus::whereIn('id', [
            DetectionReportRep::NEW, DetectionReportRep::UNDELIVERY,
            DetectionReportRep::DELIVERY, DetectionReportRep::REPLIED
        ])->get();

        $reporter = Reporter::all();

        $regulations = Regulations::all();

        $carBrand = CarBrand::all();

        $inspectionInstitution = InspectionInstitution::all()->pluck('ii_name', 'id');

        return view('admin.detection_report.create', ['authStatus' => $auth_status, 'reporter' => $reporter, 'regulations' => $regulations, 'brand' => $carBrand, 'inspectionInstitution' => $inspectionInstitution, 'mode' => 'create']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDetectionReportRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDetectionReportRequest $request)
    {
        //

        $validated = $request->validated();

        $input = $request->all();

        // if (($input['letter_id'] == '' && $input['letter_id'] == null) || ($input['reports_reply'] == '' && $input['reports_reply'] == null)) {
        //     $input['reports_authorize_status'] = '2';
        // } else {
        //     $input['reports_authorize_status'] = '3';
        // }
        $input['reports_authorize_status'] = '2';

        $detectionReport = DetectionReport::create($request->all());

        // Flash::error('功能開發中!!!');

        // return redirect(route('admin.detectionReports.create'));

        Flash::success('DetectionReport saved successfully.');

        return redirect(route('admin.detectionReports.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DetectionReport  $detectionReport
     * @return \Illuminate\Http\Response
     */
    public function show(DetectionReport $detectionReport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DetectionReport  $detectionReport
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $detectionReport = DetectionReport::find($id);

        if (empty($detectionReport)) {
            Flash::error('Detection Report not found');

            return redirect(route('admin.detectionReports.index'));
        }

        $base_status = [DetectionReportRep::UNDELIVERY, DetectionReportRep::DELIVERY,
                DetectionReportRep::REPLIED];

        switch ($detectionReport->reports_authorize_status) {
            case DetectionReportRep::UNDELIVERY :
                $status = $base_status;
                array_push($status, DetectionReportRep::AUTHORIZATION);
                break;
            case DetectionReportRep::AUTHORIZATION :
                $status = $base_status;
                array_push($status, DetectionReportRep::ACTION_FOR_POSTPONE);
                array_push($status, DetectionReportRep::ACTION_FOR_MOVE_OUT);
                break;
            case DetectionReportRep::OUT_OF_TIME :
                $status = $base_status;
                array_push($status, DetectionReportRep::ACTION_FOR_POSTPONE);
                break;
            case DetectionReportRep::REACH_LIMIT_280 :
                $status = $base_status;
                array_push($status, DetectionReportRep::ACTION_FOR_MOVE_OUT);
            case DetectionReportRep::WAIT_FOR_POSTPONE :
                $status = $base_status;
                array_push($status, DetectionReportRep::ACTION_FOR_POSTPONE);
                break;
            case DetectionReportRep::WAIT_FOR_MOVE_OUT :
                $status = $base_status;
                array_push($status, DetectionReportRep::ACTION_FOR_MOVE_OUT);
                break;
            case DetectionReportRep::ACTION_FOR_MOVE_OUT :
                $status = $base_status;
                array_push($status, DetectionReportRep::AUTHORIZATION);
                array_push($status, DetectionReportRep::MOVE_OUT);
                break;
            case DetectionReportRep::ACTION_FOR_POSTPONE :
                $status = $base_status;
                array_push($status, DetectionReportRep::AUTHORIZATION);
                break;
            default :
                $status = $base_status;
                break;
        }

        $auth_status = AuthStatus::whereIn('id', $status)->get();
        // 暫時的需移除
        // $auth_status = AuthStatus::all();

        $reporter = Reporter::all();

        $regulations = Regulations::all();

        $carBrand = CarBrand::all();

        $inspectionInstitution = InspectionInstitution::all()->pluck('ii_name', 'id');

        return view('admin.detection_report.edit', ['detectionReport' => $detectionReport, 'authStatus' => $auth_status, 'reporter' => $reporter, 'regulations' => $regulations, 'brand' => $carBrand, 'inspectionInstitution' => $inspectionInstitution, 'mode' => 'edit']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDetectionReportRequest  $request
     * @param  \App\Models\DetectionReport  $detectionReport
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDetectionReportRequest $request, $id)
    {
        //
        $detectionReport = DetectionReport::find($id);

        if (empty($detectionReport)) {
            Flash::error('Detection Report not found');

            return redirect(route('admin.detectionReports.index'));
        }

        $input = $request->all();

        $today = Carbon::now();
        $expiration_date = Carbon::parse($detectionReport->reports_expiration_date_end);

        if (empty($input['reports_authorize_status'])) {
            $input['reports_authorize_status'] = $detectionReport->reports_authorize_status;
        }

        switch ($input['reports_authorize_status']) {
            case DetectionReportRep::REPLIED :
            case DetectionReportRep::AUTHORIZATION :
                if (!empty($input['letter_id']) && !empty($input['reports_reply'])) {
                    if ($today >= $expiration_date) {
                        $input['reports_authorize_status'] = DetectionReportRep::WAIT_FOR_POSTPONE;
                    } else if ($today <= $expiration_date && $today >= $expiration_date->subMonths(2)) {
                        $input['reports_authorize_status'] = DetectionReportRep::OUT_OF_TIME;
                    } else if ($detectionReport->reports_authorize_count_current >= 300) {
                        $input['reports_authorize_status'] = DetectionReportRep::WAIT_FOR_MOVE_OUT;
                    } else if ($detectionReport->reports_authorize_count_current >= 280) {
                        $input['reports_authorize_status'] = DetectionReportRep::REACH_LIMIT_280;
                    } else {
                        $input['reports_authorize_status'] = DetectionReportRep::AUTHORIZATION;
                    }
                } else {
                    Flash::error('缺少發函文號或車安回函，請重新確認');

                    return redirect(route('admin.detectionReports.edit', ['id' => $id]));
                }
                break;
        }


        $detectionReport->update($input);

        Flash::success('Detection Report updated successfully.');

        return redirect(route('admin.detectionReports.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DetectionReport  $detectionReport
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $detectionReport = DetectionReport::find($id);

        if (empty($detectionReport)) {
            Flash::error('Detection Report not found');

            return redirect(route('admin.detectionReports.index'));
        }

        $detectionReport->delete($id);

        Flash::success('Detection Report deleted successfully.');

        return redirect(route('admin.detectionReports.index'));
    }

    public function getStatusByLetter(Request $request)
    {
        $enable = $request->input('enable');
        if ($enable == '' && $enable == null) {
            $auth_status = AuthStatus::whereIn('id', [1, 2, 3])->get(['id', 'status_name']);
        } else {
            $auth_status = AuthStatus::whereNotIn('id', [1, 2, 3])->get(['id', 'status_name']);
        }


        return response()->json($auth_status);
    }

    public function exportDocument(Request $request)
    {
        $wordService = new WordServices();

        $input = $request->all();

        $type = $input['typer'];
        $data_ids = $input['data_ids'];

        if ($type == 's1') { // 申請送件階段 - 只有一個發函文號
            // 檢測報告移入協會合約書 - 因多個報告原有人有多份合約書
            $reporters = DetectionReport::whereIn('id', $data_ids)->pluck('reports_reporter')->unique();
            $contract_file_res = array();
            foreach ($reporters as $reporter) {
                $reports = DetectionReport::whereIn('id', $data_ids)->where('reports_reporter', $reporter)->pluck('id');
                $res = $wordService->updateWordDocument(WordServices::MOVE_IN_CONTRACT, $reports);
                array_push($contract_file_res, $res);
            }

            // 申請函 - 只有一份 by 發函文號
            $apply_letter_file_res = $wordService->updateWordDocument(WordServices::APPLICATION_LETTER, $data_ids);

            // 登入清冊 - 只有一份 by 發函文號
            $data_entry_res = $wordService->updateWordDocument(WordServices::DATA_ENTRY_EXCEL, $data_ids);
        }



        // $file_res = $wordService->updateWordDocument($type, $data_ids);

        // Flash::success('Detection Report download successfully.');

        return \Response::json(['status' => 'success', 'contract_data' => $contract_file_res, 'apply_letter_data' => $apply_letter_file_res, 'data_entry_data' => $data_entry_res]);
    }

    // public function convertToPdf(Request $request)
    // {
    // $input = $request->input('convert');
    // $ilovepdf = new Ilovepdf('project_public_0972a67458e4dd3ac4561edec19a48ed_pWfxHf7de3bcb072e2b66fc59b5cf8ded47d7','secret_key_f428272dfee9a265364aeadf9d895a8a_UMGYM186d525137876fd82fbc8a61f341c725');
    // $myTask = $ilovepdf->newTask('officepdf');
    // $file1 = $myTask->addFile(public_path($input));
    // $myTask->execute();
    // $myTask->download($folderPath);
    // }
}
