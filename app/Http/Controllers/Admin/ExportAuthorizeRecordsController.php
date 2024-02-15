<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CreateExportAuthorizeRecordsRequest;
use App\Http\Requests\Admin\UpdateExportAuthorizeRecordsRequest;
use App\Repositories\Admin\ExportAuthorizeRecordsRepository;
use App\Http\Controllers\AppBaseController;
use App\Models\Admin\AgreeAuthorizeRecords;
use App\Models\Admin\CarBrand;
use App\Models\Admin\CarModel;
use App\Models\Admin\CumulativeAuthorizedUsageRecords;
use App\Models\Admin\DetectionReport;
use App\Models\Admin\ExportAuthorizeRecords;
use App\Models\Admin\Regulations;
use Illuminate\Http\Request;
use Flash;
use Response;
use Yajra\DataTables\Facades\DataTables;

class ExportAuthorizeRecordsController extends AppBaseController
{
    /** @var ExportAuthorizeRecordsRepository $exportAuthorizeRecordsRepository*/
    private $exportAuthorizeRecordsRepository;

    public function __construct(ExportAuthorizeRecordsRepository $exportAuthorizeRecordsRepo)
    {
        $this->exportAuthorizeRecordsRepository = $exportAuthorizeRecordsRepo;
    }

    /**
     * Display a listing of the ExportAuthorizeRecords.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $records = $this->exportAuthorizeRecordsRepository->all();

        if ($request->ajax()) {
            $exportAuthorizeRecords = ExportAuthorizeRecords::select([
                'id',
                'reports_ids',
                'export_authorize_num',
                'export_authorize_com',
                'export_authorize_brand',
                'export_authorize_model',
                'export_authorize_type_year',
                'export_authorize_vin',
                'export_authorize_date',
                'export_authorize_auth_num_id',
                'export_authorize_reports_nums',
                'export_authorize_path',
                'export_authorize_note',
                'created_at',
                'updated_at',
                'deleted_at'
            ]);

            $dataTables = DataTables::eloquent($exportAuthorizeRecords);

            $dataTables
                ->filterColumn('export_authorize_brand', function ($query, $keyword) {
                    $newKeyword = CarBrand::where('brand_name', 'like', "%{$keyword}%")->get('id');
                    $query->whereIn("export_authorize_brand", $newKeyword);
                })
                ->filterColumn('export_authorize_model', function ($query, $keyword) {
                    $newKeyword = CarModel::where('model_name', 'like', "%{$keyword}%")->get('id');
                    $query->whereIn("export_authorize_model", $newKeyword);
                });

            return $dataTables
                ->addIndexColumn()
                ->addColumn('checkbox', function (ExportAuthorizeRecords $record) {
                    return '<div class="form-group form-check"><input type="checkbox" name="records[]" class="form-check-input" style="width: 20px;height: 20px;" value="' . $record->id . '" id="' . $record->id . '" ></div>';
                })
                ->addColumn('action', function (ExportAuthorizeRecords $record) {
                    $newR = json_encode($record, JSON_UNESCAPED_UNICODE);
                    $sr = str_replace(" ", "&nbsp;", $newR);
                    $sr = str_replace("\t", "&#9;", $sr);
                    $sr = str_replace("\n",  "<br>", $sr);
                    $sr = str_replace("\r", "<br>", $sr);
                    $btn_copy = '<a href="javascript:void(0)" onclick=copy(\''. $sr .'\') class="btn btn-default btn-lg2">' .
                        '<i class="far fa-copy"></i>' .
                        '</a>';
                    $btn_edit = '<a href="javascript:void(0)" onclick=edit(\''. $sr .'\') class="btn btn-default btn-lg2">' .
                        '<i class="far fa-edit"></i>' .
                        '</a>';
                    $btn_del = '<button type="button" class="btn btn-danger" onclick="return check(this)"><i class="far fa-trash-alt"></i></button>';

                    return '<form action="' . route('admin.exportAuthorizeRecords.destroy', [$record->id]) . '" method="POST"><input name="_method" type="hidden" value="DELETE"><input name="_token" type="hidden" value="' . csrf_token() . '"><div class="btn-group">' . $btn_copy . $btn_edit . $btn_del . '</div></form>';
                })
                ->editColumn('export_authorize_num', function (ExportAuthorizeRecords $record) {
                    return "TWCAR-$record->export_authorize_num";
                }, ['searchable' => true])
                ->editColumn('export_authorize_brand', function(ExportAuthorizeRecords $record) {
                    return CarBrand::where('id', $record->export_authorize_brand)->value('brand_name');
                }, ['searchable' => true])
                ->editColumn('export_authorize_model', function(ExportAuthorizeRecords $record) {
                    return CarModel::where('id', $record->export_authorize_model)->value('model_name');
                }, ['searchable' => true])
                ->editColumn('export_authorize_auth_num_id', function(ExportAuthorizeRecords $record) {
                    $auth_num_id = '';
                    foreach ($record->export_authorize_auth_num_id as $i => $v) {
                        if ($i == 0) {
                            $auth_num_id .= $v;
                        } else {
                            $auth_num_id .= ', '. $v;
                        }
                    }
                    return '<div class="w-40-rem" style="max-width: 40rem !important;white-space: normal !important;">'.$auth_num_id.'</div>';
                }, ['searchable' => true])
                ->editColumn('export_authorize_reports_nums', function(ExportAuthorizeRecords $record) {
                    $reports = DetectionReport::whereIn('id', $record->reports_ids)->get();
                    $num = '';
                    foreach ($reports as $i => $report) {
                        if ($i == 0) {
                            $num .= '<a href="javascript:void(0)" class="text-secondary" onclick="openReport('.$report->id.');">'.$report->reports_num.'</a>';
                        } else {
                            $num .= ', ' . '<a href="javascript:void(0)" class="text-secondary" onclick="openReport(' . $report->id . ');">' . $report->reports_num . '</a>';
                        }
                    }
                    return '<div class="text-bold w-40-rem" style="max-width: 40rem !important;white-space: normal !important;">'.$num.'</div>';
                }, ['searchable' => true])
                ->editColumn('export_authorize_path', function(ExportAuthorizeRecords $record) {
                    $files = '';
                    $eapath = $record->export_authorize_path;
                    $files .= "<a href='" . url($eapath['word']) . "' download><img src='" . asset('assets/img/word-icon.png') . "'' class='img-fluid mx-2 my-1' width='30' title='" . $eapath['authorize_file_name'] . "' alt=''></a>";
                    $files .= "<a href='" . url($eapath['pdf']) . "' download><img src='" . asset('assets/img/pdf-icon.png') . "'' class='img-fluid mx-2 my-1' width='30' title='" . $eapath['authorize_file_name'] . "' alt=''></a>";
                    return $files;
                }, ['searchable' => true])
                ->rawColumns(['checkbox', 'action', 'export_authorize_num', 'export_authorize_brand', 'export_authorize_model', 'export_authorize_auth_num_id', 'export_authorize_reports_nums', 'export_authorize_path'])
                ->toJson();
        }

        $carBrand = CarBrand::all();
        $carModel = CarModel::all();

        $regulations = Regulations::all();

        return view('admin.export_authorize_records.index')
            ->with('exportAuthorizeRecords', $records)
            ->with('brand', $carBrand)
            ->with('model', $carModel)
            ->with('regulations', $regulations);
    }

    /**
     * Show the form for creating a new ExportAuthorizeRecords.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.export_authorize_records.create');
    }

    /**
     * Store a newly created ExportAuthorizeRecords in storage.
     *
     * @param CreateExportAuthorizeRecordsRequest $request
     *
     * @return Response
     */
    public function store(CreateExportAuthorizeRecordsRequest $request)
    {
        $input = $request->all();

        $exportAuthorizeRecords = $this->exportAuthorizeRecordsRepository->create($input);

        Flash::success('Export Authorize Records saved successfully.');

        return redirect(route('admin.exportAuthorizeRecords.index'));
    }

    /**
     * Display the specified ExportAuthorizeRecords.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $exportAuthorizeRecords = $this->exportAuthorizeRecordsRepository->find($id);

        if (empty($exportAuthorizeRecords)) {
            Flash::error('Export Authorize Records not found');

            return redirect(route('admin.exportAuthorizeRecords.index'));
        }

        return view('admin.export_authorize_records.show')->with('exportAuthorizeRecords', $exportAuthorizeRecords);
    }

    /**
     * Show the form for editing the specified ExportAuthorizeRecords.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $exportAuthorizeRecords = $this->exportAuthorizeRecordsRepository->find($id);

        if (empty($exportAuthorizeRecords)) {
            Flash::error('Export Authorize Records not found');

            return redirect(route('admin.exportAuthorizeRecords.index'));
        }

        return view('admin.export_authorize_records.edit')->with('exportAuthorizeRecords', $exportAuthorizeRecords);
    }

    /**
     * Update the specified ExportAuthorizeRecords in storage.
     *
     * @param int $id
     * @param UpdateExportAuthorizeRecordsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateExportAuthorizeRecordsRequest $request)
    {
        $exportAuthorizeRecords = $this->exportAuthorizeRecordsRepository->find($id);

        if (empty($exportAuthorizeRecords)) {
            Flash::error('Export Authorize Records not found');

            return redirect(route('admin.exportAuthorizeRecords.index'));
        }

        $exportAuthorizeRecords = $this->exportAuthorizeRecordsRepository->update($request->all(), $id);

        Flash::success('Export Authorize Records updated successfully.');

        return redirect(route('admin.exportAuthorizeRecords.index'));
    }

    /**
     * Remove the specified ExportAuthorizeRecords from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        // $exportAuthorizeRecords = $this->exportAuthorizeRecordsRepository->find($id);
        $exportAuthorizeRecords = ExportAuthorizeRecords::find($id);

        if (empty($exportAuthorizeRecords)) {
            Flash::error('Export Authorize Records not found');

            return redirect(route('admin.exportAuthorizeRecords.index'));
        }

        AgreeAuthorizeRecords::where('export_id', $id)->delete();
        // CumulativeAuthorizedUsageRecords::where('export_id', $id)->delete();
        CumulativeAuthorizedUsageRecords::where('export_id', $id)->update(['authorization_serial_number' => 0, 'quantity' => 0]);

        $reports_data = DetectionReport::whereIn('id', $exportAuthorizeRecords->reports_ids)->get();
        foreach ($reports_data as $info) {
            $dr = DetectionReport::find($info->id);
            $dr->reports_authorize_count_current -= 1;
            $dr->save();
        }

        $exportAuthorizeRecords->delete($id);

        Flash::success('Export Authorize Records deleted successfully.');

        return redirect(route('admin.exportAuthorizeRecords.index'));
    }
}
