<?php

namespace App\Http\Controllers\Admin;

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
use App\Repositories\Admin\DetectionReportRepository;
use Illuminate\Http\Request;
use Flash;
use Response;
use App\Services\WordServices;
use Ilovepdf\Ilovepdf;


class DetectionReportController extends Controller
{
    private $detectionReportRepository;

    public function __construct(DetectionReportRepository $detectionReportRepository)
    {
        $this->detectionReportRepository = $detectionReportRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $model = DetectionReport::orderBy('updated_at', 'DESC')->paginate(15);
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
        $auth_status = AuthStatus::whereIn('id', [1, 2, 3, 4])->get();

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

        // if (($input['letter_id'] == '' && $input['letter_id'] == null) && ($input['reports_reply'] == '' && $input['reports_reply'] == null)) {
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

        // $auth_status = AuthStatus::whereIn('id', [2,3,4])->get();
        // 暫時的需移除
        $auth_status = AuthStatus::all();

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

        $detectionReport->update($request->all());

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
        if($enable == '' && $enable == null) {
            $auth_status = AuthStatus::whereIn('id', [1, 2, 3])->get(['id', 'status_name']);
        } else {
            $auth_status = AuthStatus::whereNotIn('id', [1, 2, 3])->get(['id', 'status_name']);
        }


        return response()->json($auth_status);
    }

    public function exportDocumentTest(Request $request)
    {
        $wordService = new WordServices();

        $input = $request->all();

        $type = $input['typer'];
        $data_ids = $input['data_ids'];

        $file_res = $wordService->updateWordDocument($type, $data_ids);

        // Flash::success('Detection Report download successfully.');

        return $file_res;
    }

    public function convertToPdf(Request $request)
    {
        // $input = $request->input('convert');
        // $ilovepdf = new Ilovepdf('project_public_0972a67458e4dd3ac4561edec19a48ed_pWfxHf7de3bcb072e2b66fc59b5cf8ded47d7','secret_key_f428272dfee9a265364aeadf9d895a8a_UMGYM186d525137876fd82fbc8a61f341c725');
        // $myTask = $ilovepdf->newTask('officepdf');
        // $file1 = $myTask->addFile(public_path($input));
        // $myTask->execute();
        // $myTask->download($folderPath);
    }
}
