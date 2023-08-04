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
use Illuminate\Http\Request;
use Flash;
use Response;


class DetectionReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $model = DetectionReport::orderBy('updated_at', 'DESC')->paginate(15);

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
        $auth_status = AuthStatus::all();

        $reporter = Reporter::all();

        $regulations = Regulations::all();

        $carBrand = CarBrand::all();

        return view('admin.detection_report.create', ['authStatus' => $auth_status, 'reporter' => $reporter, 'regulations' => $regulations, 'brand' => $carBrand]);
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

        // $validated = $request->validated();

        // dd($validated);

        // $detectionReport = DetectionReport::create($request->all());

        Flash::error('功能開發中!!!');

        return redirect(route('admin.detectionReports.create'));

        // Flash::success('DetectionReport saved successfully.');

        // return redirect(route('admin.detectionReports.index'));

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
    public function edit(DetectionReport $detectionReport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDetectionReportRequest  $request
     * @param  \App\Models\DetectionReport  $detectionReport
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDetectionReportRequest $request, DetectionReport $detectionReport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DetectionReport  $detectionReport
     * @return \Illuminate\Http\Response
     */
    public function destroy(DetectionReport $detectionReport)
    {
        //
    }
}
