<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CreateAffidavitRecordRequest;
use App\Http\Requests\Admin\UpdateAffidavitRecordRequest;
use App\Repositories\Admin\AffidavitRecordRepository;
use App\Http\Controllers\AppBaseController;
use App\Models\Admin\AffidavitRecord;
use Illuminate\Http\Request;
use Flash;
use Response;

class AffidavitRecordController extends AppBaseController
{
    /** @var AffidavitRecordRepository $affidavitRecordRepository*/
    private $affidavitRecordRepository;

    public function __construct(AffidavitRecordRepository $affidavitRecordRepo)
    {
        $this->affidavitRecordRepository = $affidavitRecordRepo;
    }

    /**
     * Display a listing of the AffidavitRecord.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        // $affidavitRecords = $this->affidavitRecordRepository->paginate(10);
        $affidavitRecords = AffidavitRecord::orderBy('created_at', 'desc')->cursor();

        return view('admin.affidavit_records.index')
            ->with('affidavitRecords', $affidavitRecords);
    }

    /**
     * Show the form for creating a new AffidavitRecord.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.affidavit_records.create');
    }

    /**
     * Store a newly created AffidavitRecord in storage.
     *
     * @param CreateAffidavitRecordRequest $request
     *
     * @return Response
     */
    public function store(CreateAffidavitRecordRequest $request)
    {
        $input = $request->all();

        $affidavitRecord = $this->affidavitRecordRepository->create($input);

        Flash::success('Affidavit Record saved successfully.');

        return redirect(route('admin.affidavitRecords.index'));
    }

    /**
     * Display the specified AffidavitRecord.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $affidavitRecord = $this->affidavitRecordRepository->find($id);

        if (empty($affidavitRecord)) {
            Flash::error('Affidavit Record not found');

            return redirect(route('admin.affidavitRecords.index'));
        }

        return view('admin.affidavit_records.show')->with('affidavitRecord', $affidavitRecord);
    }

    /**
     * Show the form for editing the specified AffidavitRecord.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $affidavitRecord = $this->affidavitRecordRepository->find($id);

        if (empty($affidavitRecord)) {
            Flash::error('Affidavit Record not found');

            return redirect(route('admin.affidavitRecords.index'));
        }

        return view('admin.affidavit_records.edit')->with('affidavitRecord', $affidavitRecord);
    }

    /**
     * Update the specified AffidavitRecord in storage.
     *
     * @param int $id
     * @param UpdateAffidavitRecordRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAffidavitRecordRequest $request)
    {
        $affidavitRecord = $this->affidavitRecordRepository->find($id);

        if (empty($affidavitRecord)) {
            Flash::error('Affidavit Record not found');

            return redirect(route('admin.affidavitRecords.index'));
        }

        $affidavitRecord = $this->affidavitRecordRepository->update($request->all(), $id);

        Flash::success('Affidavit Record updated successfully.');

        return redirect(route('admin.affidavitRecords.index'));
    }

    /**
     * Remove the specified AffidavitRecord from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $affidavitRecord = $this->affidavitRecordRepository->find($id);

        if (empty($affidavitRecord)) {
            Flash::error('Affidavit Record not found');

            return redirect(route('admin.affidavitRecords.index'));
        }

        $this->affidavitRecordRepository->delete($id);

        Flash::success('Affidavit Record deleted successfully.');

        return redirect(route('admin.affidavitRecords.index'));
    }
}
