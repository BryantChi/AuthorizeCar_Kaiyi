<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CreateAgreeAuthorizeRecordsRequest;
use App\Http\Requests\Admin\UpdateAgreeAuthorizeRecordsRequest;
use App\Repositories\Admin\AgreeAuthorizeRecordsRepository;
use App\Http\Controllers\AppBaseController;
use App\Models\Admin\AgreeAuthorizeRecords;
use App\Models\Admin\CarBrand;
use App\Models\Admin\CarModel;
use App\Models\Admin\Regulations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Flash;
use Response;
use Yajra\DataTables\Facades\DataTables;

class AgreeAuthorizeRecordsController extends AppBaseController
{
    /** @var AgreeAuthorizeRecordsRepository $agreeAuthorizeRecordsRepository*/
    private $agreeAuthorizeRecordsRepository;

    public function __construct(AgreeAuthorizeRecordsRepository $agreeAuthorizeRecordsRepo)
    {
        $this->agreeAuthorizeRecordsRepository = $agreeAuthorizeRecordsRepo;
    }

    /**
     * Display a listing of the AgreeAuthorizeRecords.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        // $agreeAuthorizeRecords = $this->agreeAuthorizeRecordsRepository->all();
        // $agreeAuthorizeRecords = AgreeAuthorizeRecords::select('export_id', 'authorize_num', 'reports_id', 'reports_num', 'authorize_date', 'authorize_year', 'car_brand_id', 'car_model_id', 'reports_vin', 'reports_regulations', 'licensee', 'Invoice_title')->groupBy('export_id')->get();
        $records = AgreeAuthorizeRecords::groupBy('export_id')->get();
        // $agreeAuthorizeRecords = AgreeAuthorizeRecords::distinct()->get(['export_id']);

        if ($request->ajax()) {
            $agreeAuthorizeRecords = AgreeAuthorizeRecords::select([
                'id','export_id','authorize_num', 'reports_id', 'reports_num', 'authorize_date', 'authorize_year',
                'auth_type_year','car_brand_id','car_model_id','reports_vin', 'reports_regulations', 'licensee',
                'Invoice_title', 'auth_note'
            ])->groupBy('export_id');

            $dataTables = DataTables::eloquent($agreeAuthorizeRecords);

            $dataTables
                ->filterColumn('authorize_num', function ($query, $keyword) {
                    $query->whereRaw("authorize_num like ?", ["%{$keyword}%"]);
                })
                ->filterColumn('car_brand_id', function ($query, $keyword) {
                    $newKeyword = CarBrand::where('brand_name', 'like', "%{$keyword}%")->get('id');
                    $query->whereIn("car_brand_id", $newKeyword);
                })
                ->filterColumn('car_model_id', function ($query, $keyword) {
                    $newKeyword = CarModel::where('model_name', 'like', "%{$keyword}%")->get('id');
                    $query->whereIn("car_model_id", $newKeyword);
                });

            return $dataTables
                ->addIndexColumn()
                ->addColumn('checkbox', function (AgreeAuthorizeRecords $record) {
                    return '<div class="form-group form-check"><input type="checkbox" name="records[]" class="form-check-input" style="width: 20px;height: 20px;" value="' . $record->id . '" id="' . $record->id . '" ></div>';
                })
                // ->addColumn('action', function (AgreeAuthorizeRecords $record) {

                //     $btn_edit = '<a href="' . route('admin.agreeAuthorizeRecords.edit', [$record->id]) . '" class="btn btn-default btn-sm"><i class="far fa-edit"></i></a>';
                //     $btn_del = '<button type="button" class="btn btn-danger btn-sm" onclick="return check(this)"><i class="far fa-trash-alt"></i></button>';

                //     return '<form action="' . route('admin.agreeAuthorizeRecords.destroy', [$record->id]) . '" method="delete"><div class="btn-group">' . $btn_edit . $btn_del . '</div></form>';
                // })
                ->editColumn('authorize_num', function (AgreeAuthorizeRecords $record) {
                    $nums_content = '<a href="'. url('admin/exportAuthorizeRecords?q='."TWCAR-$record->authorize_num") .'" class="text-secondary">TWCAR-'. $record->authorize_num .'</a>';
                    return $nums_content;
                }, ['searchable' => true])
                ->editColumn('car_brand_id', function(AgreeAuthorizeRecords $record) {
                    return CarBrand::where('id', $record->car_brand_id)->value('brand_name');
                }, ['searchable' => true])
                ->editColumn('car_model_id', function(AgreeAuthorizeRecords $record) {
                    return CarModel::where('id', $record->car_model_id)->value('model_name');
                }, ['searchable' => true])
                ->editColumn('reports_regulations', function (AgreeAuthorizeRecords $record) {
                    $regs = Regulations::whereIn('regulations_num', $record->reports_regulations)->get();
                    $reg_span = '';
                    foreach ($regs as $reg) {
                        $reg_span .= '<span class="rounded mr-1 my-1 py-1 px-2 bg-info d-flex float-left" style="width: max-content;">' . $reg->regulations_num . ' ' . $reg->regulations_name . '</span>';
                    }
                    // return '<div class="float-left" style="width: 300px;">' . $reg_span . '</div>';
                    return '全套';
                }, ['searchable' => true])
                ->rawColumns(['checkbox', 'authorize_num', 'reports_regulations'])
                ->toJson();
        }

        $carBrand = CarBrand::all();
        $carModel = CarModel::all();

        return view('admin.agree_authorize_records.index')
            ->with('agreeAuthorizeRecords', $records)
            ->with('brand', $carBrand)
            ->with('model', $carModel);
    }

    /**
     * Show the form for creating a new AgreeAuthorizeRecords.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.agree_authorize_records.create');
    }

    /**
     * Store a newly created AgreeAuthorizeRecords in storage.
     *
     * @param CreateAgreeAuthorizeRecordsRequest $request
     *
     * @return Response
     */
    public function store(CreateAgreeAuthorizeRecordsRequest $request)
    {
        $input = $request->all();

        $agreeAuthorizeRecords = $this->agreeAuthorizeRecordsRepository->create($input);

        Flash::success('Agree Authorize Records saved successfully.');

        return redirect(route('admin.agreeAuthorizeRecords.index'));
    }

    /**
     * Display the specified AgreeAuthorizeRecords.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $agreeAuthorizeRecords = $this->agreeAuthorizeRecordsRepository->find($id);

        if (empty($agreeAuthorizeRecords)) {
            Flash::error('Agree Authorize Records not found');

            return redirect(route('admin.agreeAuthorizeRecords.index'));
        }

        return view('admin.agree_authorize_records.show')->with('agreeAuthorizeRecords', $agreeAuthorizeRecords);
    }

    /**
     * Show the form for editing the specified AgreeAuthorizeRecords.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $agreeAuthorizeRecords = $this->agreeAuthorizeRecordsRepository->find($id);

        if (empty($agreeAuthorizeRecords)) {
            Flash::error('Agree Authorize Records not found');

            return redirect(route('admin.agreeAuthorizeRecords.index'));
        }

        return view('admin.agree_authorize_records.edit')->with('agreeAuthorizeRecords', $agreeAuthorizeRecords);
    }

    /**
     * Update the specified AgreeAuthorizeRecords in storage.
     *
     * @param int $id
     * @param UpdateAgreeAuthorizeRecordsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAgreeAuthorizeRecordsRequest $request)
    {
        $agreeAuthorizeRecords = $this->agreeAuthorizeRecordsRepository->find($id);

        if (empty($agreeAuthorizeRecords)) {
            Flash::error('Agree Authorize Records not found');

            return redirect(route('admin.agreeAuthorizeRecords.index'));
        }

        $agreeAuthorizeRecords = $this->agreeAuthorizeRecordsRepository->update($request->all(), $id);

        Flash::success('Agree Authorize Records updated successfully.');

        return redirect(route('admin.agreeAuthorizeRecords.index'));
    }

    /**
     * Remove the specified AgreeAuthorizeRecords from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $agreeAuthorizeRecords = $this->agreeAuthorizeRecordsRepository->find($id);

        if (empty($agreeAuthorizeRecords)) {
            Flash::error('Agree Authorize Records not found');

            return redirect(route('admin.agreeAuthorizeRecords.index'));
        }

        $this->agreeAuthorizeRecordsRepository->delete($id);

        Flash::success('Agree Authorize Records deleted successfully.');

        return redirect(route('admin.agreeAuthorizeRecords.index'));
    }
}
