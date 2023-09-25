<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CreateExportAuthorizeRecordsRequest;
use App\Http\Requests\Admin\UpdateExportAuthorizeRecordsRequest;
use App\Repositories\Admin\ExportAuthorizeRecordsRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

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
        $exportAuthorizeRecords = $this->exportAuthorizeRecordsRepository->all();

        return view('admin.export_authorize_records.index')
            ->with('exportAuthorizeRecords', $exportAuthorizeRecords);
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
        $exportAuthorizeRecords = $this->exportAuthorizeRecordsRepository->find($id);

        if (empty($exportAuthorizeRecords)) {
            Flash::error('Export Authorize Records not found');

            return redirect(route('admin.exportAuthorizeRecords.index'));
        }

        $this->exportAuthorizeRecordsRepository->delete($id);

        Flash::success('Export Authorize Records deleted successfully.');

        return redirect(route('admin.exportAuthorizeRecords.index'));
    }
}
