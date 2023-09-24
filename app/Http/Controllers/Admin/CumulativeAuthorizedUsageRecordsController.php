<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CreateCumulativeAuthorizedUsageRecordsRequest;
use App\Http\Requests\Admin\UpdateCumulativeAuthorizedUsageRecordsRequest;
use App\Repositories\Admin\CumulativeAuthorizedUsageRecordsRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

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
        $cumulativeAuthorizedUsageRecords = $this->cumulativeAuthorizedUsageRecordsRepository->paginate(10);

        return view('admin.cumulative_authorized_usage_records.index')
            ->with('cumulativeAuthorizedUsageRecords', $cumulativeAuthorizedUsageRecords);
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
