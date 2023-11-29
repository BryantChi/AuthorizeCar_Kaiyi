<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CreateAgreeAuthorizeRecordsRequest;
use App\Http\Requests\Admin\UpdateAgreeAuthorizeRecordsRequest;
use App\Repositories\Admin\AgreeAuthorizeRecordsRepository;
use App\Http\Controllers\AppBaseController;
use App\Models\Admin\AgreeAuthorizeRecords;
use Illuminate\Http\Request;
use Flash;
use Response;

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
        $agreeAuthorizeRecords = AgreeAuthorizeRecords::groupBy('export_id')->get();
        // $agreeAuthorizeRecords = AgreeAuthorizeRecords::distinct()->get(['export_id']);
        // dd($agreeAuthorizeRecords);

        return view('admin.agree_authorize_records.index')
            ->with('agreeAuthorizeRecords', $agreeAuthorizeRecords);
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
