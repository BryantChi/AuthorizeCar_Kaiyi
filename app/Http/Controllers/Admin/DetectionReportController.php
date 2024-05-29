<?php

namespace App\Http\Controllers\Admin;

use App\Exports\DetectionReportExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreDetectionReportRequest;
use App\Http\Requests\Admin\UpdateDetectionReportRequest;
use App\Imports\DetectionReportsImport;
use App\Models\Admin\DetectionReport;
use App\Models\Admin\AuthorizeStatus as AuthStatus;
use App\Models\Admin\CarBrand;
use App\Models\Admin\CarModel;
use App\Models\Admin\Regulations;
use App\Models\Admin\Reporter;
use App\Models\Admin\InspectionInstitution;
use App\Models\Admin\DeliveryRecord;
use App\Models\Admin\AgreeAuthorizeRecords;
use App\Models\Admin\CumulativeAuthorizedUsageRecords;
use App\Models\Admin\ExportAuthorizeRecords;
use App\Models\Admin\AffidavitRecord;
use App\Models\Admin\CarFuelCategory;
use App\Models\Admin\CarPattern;
use App\Models\Admin\PostponeRecord;
use App\Repositories\Admin\DetectionReportRepository as DetectionReportRep;
use Illuminate\Http\Request;
use Flash;
use Response;
use App\Services\WordServices;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Ilovepdf\Ilovepdf;
use ImageManager;
use Maatwebsite\Excel\Facades\Excel;
// use Yajra\DataTables\DataTables;
use Yajra\DataTables\Facades\DataTables;

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
    public function index(Request $request)
    {
        $this->detectionReportRep::autoCheckAuthorizedStatus();
        //
        // $model = DetectionReport::orderBy('updated_at', 'DESC')->paginate(15);
        // $model = DetectionReport::select([
        //     'id',
        //     'letter_id',
        //     'reports_num',
        //     'reports_expiration_date_end',
        //     'reports_reporter' => DB::table('reporter_infos')->select('reporter_name')->whereNull('deleted_at')->whereColumn('detection_reports.reports_reporter', 'id'),
        //     'reports_car_brand' => DB::table('car_brand')->select('brand_name')->whereNull('deleted_at')->whereColumn('detection_reports.reports_car_brand', 'id'),
        //     'reports_car_model' => DB::table('car_model')->select('model_name')->whereNull('deleted_at')->whereColumn('detection_reports.reports_car_model', 'id'),
        //     'reports_inspection_institution' => DB::table('inspection_institution_infos')->select('ii_name')->whereNull('deleted_at')->whereColumn('detection_reports.reports_inspection_institution', 'id'),
        //     'reports_regulations',
        //     'reports_car_model_code',
        //     'reports_test_date',
        //     'reports_date',
        //     'reports_vin',
        //     'reports_authorize_count_before',
        //     'reports_authorize_count_current',
        //     'reports_f_e',
        //     'reports_reply',
        //     'reports_note',
        //     'reports_pdf',
        //     'reports_authorize_status' => DB::table('authorize_status')->select('status_name')->whereNull('deleted_at')->whereColumn('detection_reports.reports_authorize_status', 'id')
        // ]);
        // $model = $this->detectionReportRepository->getAllDetectionReports();

        $auth_status = AuthStatus::all();

        $reporters = Reporter::all();

        $carBrand = CarBrand::all();
        $carModel = CarModel::all();

        $ii = InspectionInstitution::all();

        $regulations = Regulations::all();

        if ($request->ajax()) {
            $model = DetectionReport::select([
                'id',
                'letter_id',
                'reports_num',
                'reports_expiration_date_end',
                'reports_reporter' => DB::table('reporter_infos')->select('reporter_name')->whereNull('deleted_at')->whereColumn('detection_reports.reports_reporter', 'id'),
                'reports_car_brand' => DB::table('car_brand')->select('brand_name')->whereNull('deleted_at')->whereColumn('detection_reports.reports_car_brand', 'id'),
                'reports_car_model' => DB::table('car_model')->select('model_name')->whereNull('deleted_at')->whereColumn('detection_reports.reports_car_model', 'id'),
                'reports_inspection_institution' => DB::table('inspection_institution_infos')->select('ii_name')->whereNull('deleted_at')->whereColumn('detection_reports.reports_inspection_institution', 'id'),
                'reports_regulations',
                'reports_car_model_code',
                'reports_test_date',
                'reports_date',
                'reports_vin',
                'reports_authorize_count_before',
                'reports_authorize_count_current',
                'reports_f_e',
                'reports_vehicle_pattern' => DB::table('car_pattern_infos')->select('pattern_name')->whereNull('deleted_at')->whereColumn('detection_reports.reports_vehicle_pattern', 'id'),
                'reports_vehicle_doors',
                'reports_vehicle_cylinders',
                'reports_vehicle_seats',
                'reports_vehicle_fuel_category' => DB::table('car_fuel_category_infos')->select('category_name')->whereNull('deleted_at')->whereColumn('detection_reports.reports_vehicle_fuel_category', 'id'),
                'reports_reply',
                'reports_note',
                'reports_pdf',
                'reports_authorize_status'
            ]);
            $dataTables = DataTables::eloquent($model);

            // $keyword = request('search.value');
            // if ($keyword) {
            $dataTables
                ->filterColumn('letter_id', function ($query, $keyword) {
                    $query->whereRaw("letter_id like ?", ["%{$keyword}%"]);
                })
                ->filterColumn('reports_num', function ($query, $keyword) {
                    $newKeyword = DetectionReport::where('reports_num', 'like', "%{$keyword}%")->get('reports_num');
                    $query->whereIn("reports_num", $newKeyword);
                })
                ->filterColumn('reports_authorize_status', function ($query, $keyword) {
                    $newKeyword = AuthStatus::where('status_name', 'like', "%{$keyword}%")->get('id');
                    $query->whereIn("reports_authorize_status", $newKeyword);
                })
                ->filterColumn('reports_expiration_date_end', function ($query, $keyword) {
                    $query->whereRaw("reports_expiration_date_end like ?", ["%{$keyword}%"]);
                })
                ->filterColumn('reports_reporter', function ($query, $keyword) {
                    $newKeyword = Reporter::where('reporter_name', 'like', "%$keyword%")->get('id');
                    $query->whereIn("reports_reporter", $newKeyword);
                })
                ->filterColumn('reports_car_brand', function ($query, $keyword) {
                    $newKeyword = CarBrand::where('brand_name', 'like', "%{$keyword}%")->get('id');
                    $query->whereIn("reports_car_brand", $newKeyword);
                })
                ->filterColumn('reports_car_model', function ($query, $keyword) {
                    $newKeyword = CarModel::where('model_name', 'like', "%{$keyword}%")->get('id');
                    $query->whereIn("reports_car_model", $newKeyword);
                })
                ->filterColumn('reports_inspection_institution', function ($query, $keyword) {
                    $newKeyword = InspectionInstitution::where('ii_name', 'like', "%{$keyword}%")->get('id');
                    $query->whereIn("reports_inspection_institution", $newKeyword);
                })
                ->filterColumn('reports_regulations', function ($query, $keyword) {
                    $query->whereRaw("reports_regulations like ?", ["%{$keyword}%"]);
                })
                ->filterColumn('reports_test_date', function ($query, $keyword) {
                    $query->whereRaw("reports_test_date like ?", ["%{$keyword}%"]);
                })
                ->filterColumn('reports_date', function ($query, $keyword) {
                    $query->whereRaw("reports_date like ?", ["%{$keyword}%"]);
                })
                ->filterColumn('reports_f_e', function ($query, $keyword) {
                    $query->whereRaw("reports_f_e like ?", ["%{$keyword}%"]);
                })
                ->filterColumn('reports_vehicle_pattern', function ($query, $keyword) {
                    $newKeyword = CarPattern::where('pattern_name', 'like', "%{$keyword}%")->get('id');
                    $query->whereIn("reports_vehicle_pattern", $newKeyword);
                })
                ->filterColumn('reports_vehicle_doors', function ($query, $keyword) {
                    $query->whereRaw("reports_vehicle_doors like ?", ["%{$keyword}%"]);
                })
                ->filterColumn('reports_vehicle_cylinders', function ($query, $keyword) {
                    $query->whereRaw("reports_vehicle_cylinders like ?", ["%{$keyword}%"]);
                })
                ->filterColumn('reports_vehicle_seats', function ($query, $keyword) {
                    $query->whereRaw("reports_vehicle_seats like ?", ["%{$keyword}%"]);
                })
                ->filterColumn('reports_vehicle_fuel_category', function ($query, $keyword) {
                    $newKeyword = CarFuelCategory::where('category_name', 'like', "%{$keyword}%")->get('id');
                    $query->whereIn("reports_vehicle_fuel_category", $newKeyword);
                });
            // }


            return $dataTables
                ->addIndexColumn()
                ->addColumn('checkbox', function (DetectionReport $report) {
                    return '<input type="checkbox" name="reports[]" style="width: 20px;height: 20px;" value="' . $report->id . '" data-letter="' . $report->letter_id . '" data-status="' . $report->reports_authorize_status . '" >';
                })
                ->addColumn('action', function (DetectionReport $report) {

                    $btn_edit = '<a href="' . route('admin.detectionReports.edit', [$report->id]) . '" class="btn btn-default btn-sm"><i class="far fa-edit"></i></a>';
                    $btn_del = '<button type="button" class="btn btn-danger btn-sm" onclick="return check(this)"><i class="far fa-trash-alt"></i></button>';

                    return '<form action="' . route('admin.detectionReports.destroy', [$report->id]) . '" method="delete"><div class="btn-group">' . $btn_edit . $btn_del . '</div></form>';
                })
                ->editColumn('reports_num', function (DetectionReport $report) {
                    $num_content = '<div class="">
                        <a class="text-secondary" data-toggle="collapse" href="#collapse' . $report->id . '" role="button" aria-expanded="false" aria-controls="collapse' . $report->id . '">' . $report->reports_num . ' ▼</a>
                        <div class="collapse" id="collapse' . $report->id . '">
                            <div class="rounded px-3 py-2 text-center d-inline-block" style="background-color: #ffffff !important;">
                                <a class="fancybox iframe text-p px-1 text-danger" href="' . env("APP_URL") . '/uploads/' . $report->reports_pdf . '">PDF</a>
                                <a class="text-danger px-1" href="' . url('admin/cumulativeAuthorizedUsageRecords?q=' . $report->reports_num) . '">次數明細</a>
                            </div>
                        </div>
                    </div>';
                    return $num_content;
                }, ['searchable' => true])
                ->editColumn('reports_authorize_status', function (DetectionReport $report) {
                    return AuthStatus::where('id', $report->reports_authorize_status)->value('status_name');
                }, ['searchable' => true])
                ->editColumn('reports_expiration_date_end', function (DetectionReport $report) {
                    $reports_expiration_date_end = $report->reports_expiration_date_end == '' || $report->reports_expiration_date_end == null ? '' : Carbon::parse($report->reports_expiration_date_end)->format('Y/m/d');
                    return $reports_expiration_date_end;
                }, ['searchable' => true])
                // ->editColumn('reports_reporter', function(DetectionReport $report) {
                //     return Reporter::where('id', $report->reports_reporter)->value('reporter_name');
                // }, ['searchable' => true])
                // ->editColumn('reports_car_brand', function(DetectionReport $report) {
                //     return CarBrand::where('id', $report->reports_car_brand)->value('brand_name');
                // }, ['searchable' => true])
                // ->editColumn('reports_car_model', function(DetectionReport $report) {
                //     return CarModel::where('id', $report->reports_car_model)->value('model_name');
                // }, ['searchable' => true])
                // ->editColumn('reports_inspection_institution', function(DetectionReport $report) {
                //     return InspectionInstitution::where('id', $report->reports_inspection_institution)->value('ii_name');
                // }, ['searchable' => true])
                ->editColumn('reports_regulations', function (DetectionReport $report) {
                    $regs = Regulations::whereIn('regulations_num', $report->reports_regulations)->get();
                    $reg_span = '';
                    foreach ($regs as $reg) {
                        $reg_span .= '<span class="rounded mr-1 my-1 py-1 px-2 bg-info d-flex float-left" style="width: max-content;">' . $reg->regulations_num . ' ' . $reg->regulations_name . '</span>';
                    }
                    return '<div class="float-left" style="width: 300px;">' . $reg_span . '</div>';
                }, ['searchable' => true])
                ->editColumn('reports_test_date', function (DetectionReport $report) {
                    $test_date = $report->reports_test_date == '' || $report->reports_test_date == null ? '' : Carbon::parse($report->reports_test_date)->format('Y/m/d');
                    return $test_date;
                }, ['searchable' => true])
                ->editColumn('reports_date', function (DetectionReport $report) {
                    $report_date = $report->reports_date == '' || $report->reports_date == null ? '' : Carbon::parse($report->reports_date)->format('Y/m/d');
                    return $report_date;
                }, ['searchable' => true])
                // ->editColumn('reports_vehicle_pattern', function (DetectionReport $report) {
                //     return CarPattern::where('id', $report->reports_vehicle_pattern)->value('pattern_name');
                // }, ['searchable' => true])
                // ->editColumn('reports_vehicle_fuel_category', function (DetectionReport $report) {
                //     return CarFuelCategory::where('id', $report->reports_vehicle_fuel_category)->value('category_name');
                // }, ['searchable' => true])
                ->rawColumns(['checkbox', 'action', 'reports_num', 'reports_expiration_date_end', 'reports_regulations', 'reports_test_date', 'reports_date', 'reports_vehicle_pattern', 'reports_vehicle_fuel_category'])
                ->toJson();
        }

        return view('admin.detection_report.index', ['brand' => $carBrand, 'model' => $carModel, 'regulations' => $regulations, 'auth_status' => $auth_status, 'reporters' => $reporters, 'iis' => $ii]);
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

        $carBrand = CarBrand::orderBy('brand_name', 'asc')->get();

        $inspectionInstitution = InspectionInstitution::orderBy('ii_name', 'asc')->pluck('ii_name', 'id');

        $carPattern = CarPattern::all()->pluck('pattern_name', 'id');

        $carFuelCategory = CarFuelCategory::all()->pluck('category_name', 'id');


        return view('admin.detection_report.create', ['authStatus' => $auth_status, 'reporter' => $reporter, 'regulations' => $regulations, 'brand' => $carBrand, 'inspectionInstitution' => $inspectionInstitution, 'carPattern' => $carPattern, 'carFuelCategory' => $carFuelCategory, 'mode' => 'create']);
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
        $input = $request->all();

        $isDel = DetectionReport::withTrashed()->where('reports_num', $input['reports_num'])->forceDelete();

        $validated = $request->validated();

        // if (($input['letter_id'] == '' && $input['letter_id'] == null) || ($input['reports_reply'] == '' && $input['reports_reply'] == null)) {
        //     $input['reports_authorize_status'] = '2';
        // } else {
        //     $input['reports_authorize_status'] = '3';
        // }
        $input['reports_authorize_status'] = '2';

        if ($input['reports_authorize_count_current'] == null || $input['reports_authorize_count_current'] == '') {
            $input['reports_authorize_count_current'] = $input['reports_authorize_count_before'];
        }

        $image = $request->file('reports_pdf');

        if ($image) {
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/images/reports_pdf/' . $input['reports_num']), $filename);

            $input['reports_pdf'] = 'images/reports_pdf/' . $input['reports_num'] . '/' . $filename;
        } else {
            $input['reports_pdf'] = '';
        }

        $detectionReport = DetectionReport::create($input);

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

        $base_status = [
            DetectionReportRep::UNDELIVERY, DetectionReportRep::DELIVERY,
            DetectionReportRep::REPLIED
        ];

        switch ($detectionReport->reports_authorize_status) {
            case DetectionReportRep::UNDELIVERY:
            case DetectionReportRep::DEACTIVATED:
                $status = $base_status;
                array_push($status, DetectionReportRep::AUTHORIZATION);
                break;
            case DetectionReportRep::AUTHORIZATION:
                $status = $base_status;
                array_push($status, DetectionReportRep::ACTION_FOR_POSTPONE);
                array_push($status, DetectionReportRep::ACTION_FOR_MOVE_OUT);
                break;
            case DetectionReportRep::OUT_OF_TIME:
                $status = $base_status;
                array_push($status, DetectionReportRep::ACTION_FOR_POSTPONE);
                break;
            case DetectionReportRep::REACH_LIMIT_280:
                $status = $base_status;
                array_push($status, DetectionReportRep::ACTION_FOR_MOVE_OUT);
            case DetectionReportRep::WAIT_FOR_POSTPONE:
                $status = $base_status;
                array_push($status, DetectionReportRep::ACTION_FOR_POSTPONE);
                break;
            case DetectionReportRep::WAIT_FOR_MOVE_OUT:
                $status = $base_status;
                array_push($status, DetectionReportRep::ACTION_FOR_MOVE_OUT);
                break;
            case DetectionReportRep::ACTION_FOR_MOVE_OUT:
                $status = $base_status;
                array_push($status, DetectionReportRep::AUTHORIZATION);
                array_push($status, DetectionReportRep::MOVE_OUT);
                break;
            case DetectionReportRep::ACTION_FOR_POSTPONE:
                $status = $base_status;
                array_push($status, DetectionReportRep::AUTHORIZATION);
                break;
            default:
                $status = $base_status;
                break;
        }
        array_push($status, DetectionReportRep::DEACTIVATED);
        array_push($status, DetectionReportRep::INVAILD);

        $auth_status = AuthStatus::whereIn('id', $status)->get();
        // 暫時的需移除
        // $auth_status = AuthStatus::all();

        $reporter = Reporter::all();

        $regulations = Regulations::all();

        $carBrand = CarBrand::orderBy('brand_name', 'ASC')->get();

        $inspectionInstitution = InspectionInstitution::orderBy('ii_name', 'asc')->pluck('ii_name', 'id');

        $carPattern = CarPattern::all()->pluck('pattern_name', 'id');

        $carFuelCategory = CarFuelCategory::all()->pluck('category_name', 'id');

        return view('admin.detection_report.edit', ['detectionReport' => $detectionReport, 'authStatus' => $auth_status, 'reporter' => $reporter, 'regulations' => $regulations, 'brand' => $carBrand, 'inspectionInstitution' => $inspectionInstitution, 'carPattern' => $carPattern, 'carFuelCategory' => $carFuelCategory, 'mode' => 'edit']);
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
            case DetectionReportRep::REPLIED:
            case DetectionReportRep::AUTHORIZATION:
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


        $image = $request->file('reports_pdf');

        if ($image) {
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/images/reports_pdf/' . $detectionReport->reports_num), $filename);

            if ($detectionReport->reports_pdf != null) {
                // 若已存在，則覆蓋原有圖片
                if (File::exists(public_path('uploads/' . $detectionReport->reports_pdf))) {
                    File::delete(public_path('uploads/' . $detectionReport->reports_pdf));
                }
            }
            $input['reports_pdf'] = 'images/reports_pdf/' . $detectionReport->reports_num . '/' . $filename;
        } else {
            $input['reports_pdf'] = $detectionReport->reports_pdf;
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

    public function modifyLetterId(Request $request)
    {
        $input = $request->all();
        DetectionReport::whereIn('id', $input['data_ids'])->update(['letter_id' => $input['letter_id']]);
        return \Response::json(['status' => 'success']);
    }

    public function exportDocument(Request $request)
    {
        $wordService = new WordServices();

        $input = $request->all();

        $type = $input['typer'];
        $data_ids = $input['data_ids'];
        $mode = $input['mode'];
        $auth_export_id = $input['auth_export_id'];

        if ($type == 'delivery') { // 申請送件階段 - 只有一個發函文號
            // 檢測報告移入協會合約書 - 因多個報告原有人有多份合約書
            $reporters = DetectionReport::whereIn('id', $data_ids)->pluck('reports_reporter')->unique();
            $contract_file_res = array();
            foreach ($reporters as $reporter) {
                $reports = DetectionReport::whereIn('id', $data_ids)->where('reports_reporter', $reporter)->pluck('id');
                $res = $wordService->updateWordDocument(WordServices::MOVE_IN_CONTRACT, $reports);
                array_push($contract_file_res, $res->original);
            }

            // 申請函 - 只有一份 by 發函文號
            $apply_letter_file_res = $wordService->updateWordDocument(WordServices::APPLICATION_LETTER, $data_ids);

            // 登入清冊 - 只有一份 by 發函文號
            $data_entry_res = $wordService->updateWordDocument(WordServices::DATA_ENTRY_EXCEL, $data_ids);

            DeliveryRecord::create(['report_id' => $data_ids, 'delivery_path' => [$contract_file_res, $apply_letter_file_res->original, $data_entry_res->original]]);
            DetectionReport::whereIn('id', $data_ids)->update(["reports_authorize_status" => DetectionReportRep::DELIVERY]);

            return \Response::json(['status' => 'success', 'contract_data' => $contract_file_res, 'apply_letter_data' => $apply_letter_file_res->original, 'data_entry_data' => $data_entry_res->original]);
        }

        if ($type == 'authorize') { // 開立授權
            $auth_input = $input['auth_input'];

            $authorize_file_res = $wordService->updateWordDocument(WordServices::POWER_OF_ATTORNEY, $data_ids, ['auth_input' => $auth_input, 'mode' => $mode, 'auth_export_id' => $auth_export_id]);

            return \Response::json(['status' => 'success', 'authorize_data' => $authorize_file_res->original]);

            // if (!empty($authorize_file_res)) {
            //     $reports = DetectionReport::whereIn('id', $data_ids)->get();

            //     foreach ($reports as $report) {
            //         $report->reports_authorize_count_current = ($report->reports_authorize_count_before + 1);
            //         $report->save();
            //     }
            // }

        }

        if ($type == 'moveout') { // 移出

            // 檢測報告移出切結書 - 因多個報告原有人有多份切結書
            $reporters = DetectionReport::whereIn('id', $data_ids)->pluck('reports_reporter')->unique();
            $moveout_file_res = array();
            foreach ($reporters as $reporter) {
                $reports = DetectionReport::whereIn('id', $data_ids)->where('reports_reporter', $reporter)->pluck('id');
                $res = $wordService->updateWordDocument(WordServices::MOVE_OUT_AFFIDAVIT, $reports);
                array_push($moveout_file_res, $res->original);
            }

            // 檢測報告移出函文 - 只有一份 by 發函文號
            $affidavit_letter_file_res = $wordService->updateWordDocument(WordServices::AFFIDAVIT_LETTER, $data_ids);

            // 移出清冊 - 只有一份 by 發函文號
            $data_affidavit_res = $wordService->updateWordDocument(WordServices::DATA_AFFIDAVIT_EXCEL, $data_ids);

            AffidavitRecord::create(['report_id' => $data_ids, 'affidavit_path' => [$moveout_file_res, $affidavit_letter_file_res->original, $data_affidavit_res->original]]);
            DetectionReport::whereIn('id', $data_ids)->update(["reports_authorize_status" => DetectionReportRep::DEACTIVATED]);

            return \Response::json(['status' => 'success', 'contract_data' => $moveout_file_res, 'letter_data' => $affidavit_letter_file_res->original, 'data_affidavit_data' => $data_affidavit_res->original]);
        }

        if ($type == 'postpone') {
            // 檢測報告移出切結書 - 因多個報告原有人有多份切結書
            $reporters = DetectionReport::whereIn('id', $data_ids)->pluck('reports_reporter')->unique();
            $postpone_file_res = array();
            foreach ($reporters as $reporter) {
                $reports = DetectionReport::whereIn('id', $data_ids)->where('reports_reporter', $reporter)->pluck('id');
                $res = $wordService->updateWordDocument(WordServices::POSTPONE_CONTRACT, $reports);
                array_push($postpone_file_res, $res->original);
            }

            // 申請函 - 只有一份 by 發函文號
            $postpone_apply_letter_file_res = $wordService->updateWordDocument(WordServices::POSTPONE_APPLICATION_LETTER, $data_ids);

            // 登入清冊 - 只有一份 by 發函文號
            $data_postpone_res = $wordService->updateWordDocument(WordServices::DATA_POSTPONE_EXCEL, $data_ids);

            PostponeRecord::create(['report_id' => $data_ids, 'postpone_path' => [$postpone_file_res, $postpone_apply_letter_file_res->original, $data_postpone_res->original]]);
            DetectionReport::whereIn('id', $data_ids)->update(["reports_authorize_status" => DetectionReportRep::MOVE_OUT, 'reports_authorize_count_before' => 0, 'reports_authorize_count_current' => 0]);

            return \Response::json(['status' => 'success', 'contract_data' => $postpone_file_res, 'postpone_apply_letter_data' => $postpone_apply_letter_file_res->original, 'data_postpone_data' => $data_postpone_res->original]);
        }


        // $file_res = $wordService->updateWordDocument($type, $data_ids);

        // Flash::success('Detection Report download successfully.');

        // return \Response::json(['status' => 'success', 'contract_data' => $contract_file_res, 'apply_letter_data' => $apply_letter_file_res, 'data_entry_data' => $data_entry_res]);
    }

    public function modifyReply(Request $request)
    {
        $input = $request->all();

        $data_ids = $input['data_ids'];
        $reply_num = $input['reply_num'];

        $replyRequest = DetectionReport::whereIn('id', $data_ids);

        $replyRequest->update(['reports_reply' => $reply_num, 'reports_authorize_status' => DetectionReportRep::REPLIED]);

        return \Response::json(['status' => 'success']);
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

    public function showReportModal(Request $request)
    {
        $input = $request->all();
        $report = DetectionReport::find($input['reportId']);

        $rt = new \StdClass();

        $rt->letter_id = $report->letter_id;
        $rt->reports_num = $report->reports_num;
        $rt->reports_expiration_date_end = Carbon::parse($report->reports_expiration_date_end)->format('Y/m/d');
        $rt->reports_reporter = Reporter::where('id', $report->reports_reporter)->value('reporter_name');
        $rt->reports_car_brand = CarBrand::where('id', $report->reports_car_brand)->value('brand_name');
        $rt->reports_car_model = CarModel::where('id', $report->reports_car_model)->value('model_name');
        $rt->reports_inspection_institution = InspectionInstitution::where('id', $report->reports_inspection_institution)->value('ii_name');
        $regulations = Regulations::whereIn('regulations_num', $report->reports_regulations)->get();
        $reg = '';
        foreach ($regulations as $info) {
            $reg .= '<span class="rounded mr-1 my-1 py-1 px-2 bg-info d-flex float-left" style="width: max-content;">' . $info->regulations_num . ' ' . $info->regulations_name . '</span>';
        }
        $rt->reports_regulations = $reg;
        $rt->reports_car_model_code = $report->reports_car_model_code;
        $rt->reports_test_date = Carbon::parse($report->reports_test_date)->format('Y/m/d');
        $rt->reports_date = Carbon::parse($report->reports_date)->format('Y/m/d');
        $rt->reports_vin = $report->reports_vin;
        $rt->reports_authorize_count_before = $report->reports_authorize_count_before;
        $rt->reports_authorize_count_current = $report->reports_authorize_count_current;
        $rt->reports_f_e = $report->reports_f_e;
        $rt->reports_reply = $report->reports_reply;
        $rt->reports_note = $report->reports_note;
        $rt->reports_authorize_status = AuthStatus::where('id', $report->reports_authorize_status)->value('status_name');

        return \Response::json(['status' => 'success', 'data' => $rt]);
    }

    public function getReportsByRegs(Request $request)
    {
        $regs = $request->input('regs');
        $json_regs = json_encode($regs);
        // dd($json_regs);
        if ($regs == '' || $regs == 'null') {
            $reports = DetectionReport::whereIn('reports_authorize_status', [DetectionReportRep::AUTHORIZATION, DetectionReportRep::REACH_LIMIT_280, DetectionReportRep::OUT_OF_TIME])
                ->get(['id', 'reports_num', 'reports_regulations', 'reports_expiration_date_end', 'reports_f_e', 'reports_authorize_count_before', 'reports_authorize_count_current']);
        } else {
            $reports = DetectionReport::whereIn('reports_authorize_status', [DetectionReportRep::AUTHORIZATION, DetectionReportRep::REACH_LIMIT_280, DetectionReportRep::OUT_OF_TIME])
                ->where('reports_regulations', $json_regs)
                ->get(['id', 'reports_num', 'reports_regulations', 'reports_expiration_date_end', 'reports_f_e', 'reports_authorize_count_before', 'reports_authorize_count_current']);
        }


        return response()->json($reports);
    }

    public function getRegs(Request $request)
    {
        $regs = $request->input('regs');
        $json_regs = mb_split(',', $regs);
        $regulations = Regulations::whereIn('regulations_num', $json_regs)->get();
        return response()->json($regulations);
    }

    public function getReportsData(Request $request)
    {
        $input = $request->all();
        $data_ids = $input['data_ids'];

        $reports = DetectionReport::whereIn('id', $data_ids)->get();

        $regulations = [];
        foreach ($reports as $report) {
            $regs = Regulations::whereIn('regulations_num', $report->reports_regulations)->get(['regulations_num', 'regulations_name']);
            $regulations[$report->id] = $regs;
        }

        return \Response::json(['status' => 'success', 'reports' => $reports, 'regulations' => $regulations]);
    }

    public function getReportByNum(Request $request)
    {
        $input = $request->all();

        $num = $input['num'];

        $report = DetectionReport::where('reports_num', $num)->first();

        return \Response::json(['status' => 'success', 'report_data' => $report]);
    }

    public function importReport(Request $request)
    {
        Excel::import(new DetectionReportsImport, $request->file('dri_file'));

        return redirect(route('admin.detectionReports.index'));
    }

    private function containsOnly($arr, $validValues)
    {
        return collect($arr)->every(function ($value) use ($validValues) {
            return in_array($value, $validValues);
        });
    }

    public function saveDraft(Request $request)
    {
        Session::put('form_data', $request->all(), now()->addMinutes(5));

        return \Response::json(['status' => 'success']);
    }

    public function exportDetectionReports(Request $request)
    {
        $input = $request->all();
        $data_ids = $input['data_ids'];

        if ($data_ids == null) {
            return Excel::download(new DetectionReportExport(null, DetectionReportExport::REPORTS_FULL), '檢測報告總表.xlsx');
        } else {
            return Excel::download(new DetectionReportExport($data_ids, DetectionReportExport::REPORTS_FULL), '外匯車授權管理系統.xlsx');
        }

    }
}
