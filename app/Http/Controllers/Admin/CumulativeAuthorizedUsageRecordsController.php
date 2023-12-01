<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CreateCumulativeAuthorizedUsageRecordsRequest;
use App\Http\Requests\Admin\UpdateCumulativeAuthorizedUsageRecordsRequest;
use App\Repositories\Admin\CumulativeAuthorizedUsageRecordsRepository;
use App\Http\Controllers\AppBaseController;
use App\Models\Admin\CumulativeAuthorizedUsageRecords;
use App\Models\Admin\Reporter;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Flash;
use Response;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class CumulativeAuthorizedUsageRecordsController extends AppBaseController
{
    /** @var CumulativeAuthorizedUsageRecordsRepository $cumulativeAuthorizedUsageRecordsRepository*/
    private $cumulativeAuthorizedUsageRecordsRepository;

    public function __construct(CumulativeAuthorizedUsageRecordsRepository $cumulativeAuthorizedUsageRecordsRepo)
    {
        $this->cumulativeAuthorizedUsageRecordsRepository = $cumulativeAuthorizedUsageRecordsRepo;
    }

    /**
     * Display a listing of the CumulativeAuthorizedUsageRecords.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $records = $this->cumulativeAuthorizedUsageRecordsRepository->all();

        if ($request->ajax()) {
            $cumulativeAuthorizedUsageRecords = CumulativeAuthorizedUsageRecords::select([
                'id',
                'export_id',
                'authorization_serial_number',
                'authorize_num',
                'reports_num',
                'applicant',
                'reports_vin',
                'quantity',
                'authorization_date'
            ]);

            $dataTables = DataTables::eloquent($cumulativeAuthorizedUsageRecords);

            $dataTables
                ->filterColumn('authorize_num', function ($query, $keyword) {
                    $query->whereRaw("authorize_num like ?", ["%{$keyword}%"]);
                })
                ->filterColumn('applicant', function ($query, $keyword) {
                    $newKeyword = Reporter::where('reporter_name', 'like', "%$keyword%")->get('id');
                    $query->whereIn("applicant", $newKeyword);
                })
                ->filterColumn('authorization_date', function ($query, $keyword) {
                    $query->whereRaw("authorization_date like ?", ["%{$keyword}%"]);
                });

            return $dataTables
                ->addIndexColumn()
                ->addColumn('checkbox', function (CumulativeAuthorizedUsageRecords $record) {
                    return '<div class="form-group form-check"><input type="checkbox" name="records[]" class="form-check-input" style="width: 20px;height: 20px;" value="' . $record->id . '" id="' . $record->id . '" ></div>';
                })
                ->addColumn('action', function (CumulativeAuthorizedUsageRecords $record) {

                    $btn_edit = '<a href="' . route('admin.cumulativeAuthorizedUsageRecords.edit', [$record->id]) . '" class="btn btn-default btn-sm"><i class="far fa-edit"></i></a>';
                    $btn_del = '<button type="button" class="btn btn-danger btn-sm" onclick="return check(this)"><i class="far fa-trash-alt"></i></button>';

                    return '<form action="' . route('admin.cumulativeAuthorizedUsageRecords.destroy', [$record->id]) . '" method="delete"><div class="btn-group">' . $btn_edit . $btn_del . '</div></form>';
                })
                ->editColumn('authorize_num', function (CumulativeAuthorizedUsageRecords $record) {
                    $contains = Str::contains($record->authorize_num, '=>');
                    if ($contains) {
                        $nums = Str::of($record->authorize_num)->explode(" => ");
                    }

                    if ($contains) {
                        $nums_content = '<a href="'. url('admin/exportAuthorizeRecords?q='."TWCAR-$nums[1]") .'" class="text-secondary">TWCAR-'. $nums[0].' => TWCAR-'. $nums[1].'</a>';
                    } else {
                        $nums_content = '<a href="'. url('admin/exportAuthorizeRecords?q='."TWCAR-$record->authorize_num") .'" class="text-secondary">TWCAR-'. $record->authorize_num .'</a>';
                    }
                    return $nums_content;
                }, ['searchable' => true])
                ->editColumn('applicant', function(CumulativeAuthorizedUsageRecords $record) {
                    return Reporter::where('id', $record->applicant)->value('reporter_name');
                }, ['searchable' => true])
                // ->editColumn('authorization_date', function (CumulativeAuthorizedUsageRecords $record) {
                //     $authorization_date = $record->authorization_date == '' || $record->authorization_date == null ? '' : Carbon::parse($record->authorization_date)->format('Y/m/d');
                //     return $authorization_date;
                // }, ['searchable' => true])
                ->rawColumns(['checkbox', 'action', 'authorize_num', 'applicant', 'authorization_date'])
                ->toJson();

        }

        $reporters = Reporter::all();

        return view('admin.cumulative_authorized_usage_records.index')
            ->with('caRecords', $records)
            ->with('reporters', $reporters);

    }

    /**
     * Show the form for creating a new CumulativeAuthorizedUsageRecords.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.cumulative_authorized_usage_records.create');
    }

    /**
     * Store a newly created CumulativeAuthorizedUsageRecords in storage.
     *
     * @param CreateCumulativeAuthorizedUsageRecordsRequest $request
     *
     * @return Response
     */
    public function store(CreateCumulativeAuthorizedUsageRecordsRequest $request)
    {
        $input = $request->all();

        $cumulativeAuthorizedUsageRecords = $this->cumulativeAuthorizedUsageRecordsRepository->create($input);

        Flash::success('Cumulative Authorized Usage Records saved successfully.');

        return redirect(route('admin.cumulativeAuthorizedUsageRecords.index'));
    }

    /**
     * Display the specified CumulativeAuthorizedUsageRecords.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $cumulativeAuthorizedUsageRecords = $this->cumulativeAuthorizedUsageRecordsRepository->find($id);

        if (empty($cumulativeAuthorizedUsageRecords)) {
            Flash::error('Cumulative Authorized Usage Records not found');

            return redirect(route('admin.cumulativeAuthorizedUsageRecords.index'));
        }

        return view('admin.cumulative_authorized_usage_records.show')->with('cumulativeAuthorizedUsageRecords', $cumulativeAuthorizedUsageRecords);
    }

    /**
     * Show the form for editing the specified CumulativeAuthorizedUsageRecords.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $cumulativeAuthorizedUsageRecords = $this->cumulativeAuthorizedUsageRecordsRepository->find($id);

        if (empty($cumulativeAuthorizedUsageRecords)) {
            Flash::error('Cumulative Authorized Usage Records not found');

            return redirect(route('admin.cumulativeAuthorizedUsageRecords.index'));
        }

        return view('admin.cumulative_authorized_usage_records.edit')->with('cumulativeAuthorizedUsageRecords', $cumulativeAuthorizedUsageRecords);
    }

    /**
     * Update the specified CumulativeAuthorizedUsageRecords in storage.
     *
     * @param int $id
     * @param UpdateCumulativeAuthorizedUsageRecordsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCumulativeAuthorizedUsageRecordsRequest $request)
    {
        $cumulativeAuthorizedUsageRecords = $this->cumulativeAuthorizedUsageRecordsRepository->find($id);

        if (empty($cumulativeAuthorizedUsageRecords)) {
            Flash::error('Cumulative Authorized Usage Records not found');

            return redirect(route('admin.cumulativeAuthorizedUsageRecords.index'));
        }

        $cumulativeAuthorizedUsageRecords = $this->cumulativeAuthorizedUsageRecordsRepository->update($request->all(), $id);

        Flash::success('Cumulative Authorized Usage Records updated successfully.');

        return redirect(route('admin.cumulativeAuthorizedUsageRecords.index'));
    }

    /**
     * Remove the specified CumulativeAuthorizedUsageRecords from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $cumulativeAuthorizedUsageRecords = $this->cumulativeAuthorizedUsageRecordsRepository->find($id);

        if (empty($cumulativeAuthorizedUsageRecords)) {
            Flash::error('Cumulative Authorized Usage Records not found');

            return redirect(route('admin.cumulativeAuthorizedUsageRecords.index'));
        }

        $this->cumulativeAuthorizedUsageRecordsRepository->delete($id);

        Flash::success('Cumulative Authorized Usage Records deleted successfully.');

        return redirect(route('admin.cumulativeAuthorizedUsageRecords.index'));
    }
}
