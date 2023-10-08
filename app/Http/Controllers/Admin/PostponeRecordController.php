<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CreatePostponeRecordRequest;
use App\Http\Requests\Admin\UpdatePostponeRecordRequest;
use App\Repositories\Admin\PostponeRecordRepository;
use App\Http\Controllers\AppBaseController;
use App\Models\Admin\PostponeRecord;
use Illuminate\Http\Request;
use Flash;
use Response;

class PostponeRecordController extends AppBaseController
{
    /** @var PostponeRecordRepository $postponeRecordRepository*/
    private $postponeRecordRepository;

    public function __construct(PostponeRecordRepository $postponeRecordRepo)
    {
        $this->postponeRecordRepository = $postponeRecordRepo;
    }

    /**
     * Display a listing of the PostponeRecord.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        // $postponeRecords = $this->postponeRecordRepository->paginate(10);
        $postponeRecords = PostponeRecord::orderBy('created_at', 'desc')->cursor();

        return view('admin.postpone_records.index')
            ->with('postponeRecords', $postponeRecords);
    }

    /**
     * Show the form for creating a new PostponeRecord.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.postpone_records.create');
    }

    /**
     * Store a newly created PostponeRecord in storage.
     *
     * @param CreatePostponeRecordRequest $request
     *
     * @return Response
     */
    public function store(CreatePostponeRecordRequest $request)
    {
        $input = $request->all();

        $postponeRecord = $this->postponeRecordRepository->create($input);

        Flash::success('Postpone Record saved successfully.');

        return redirect(route('admin.postponeRecords.index'));
    }

    /**
     * Display the specified PostponeRecord.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $postponeRecord = $this->postponeRecordRepository->find($id);

        if (empty($postponeRecord)) {
            Flash::error('Postpone Record not found');

            return redirect(route('admin.postponeRecords.index'));
        }

        return view('admin.postpone_records.show')->with('postponeRecord', $postponeRecord);
    }

    /**
     * Show the form for editing the specified PostponeRecord.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $postponeRecord = $this->postponeRecordRepository->find($id);

        if (empty($postponeRecord)) {
            Flash::error('Postpone Record not found');

            return redirect(route('admin.postponeRecords.index'));
        }

        return view('admin.postpone_records.edit')->with('postponeRecord', $postponeRecord);
    }

    /**
     * Update the specified PostponeRecord in storage.
     *
     * @param int $id
     * @param UpdatePostponeRecordRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePostponeRecordRequest $request)
    {
        $postponeRecord = $this->postponeRecordRepository->find($id);

        if (empty($postponeRecord)) {
            Flash::error('Postpone Record not found');

            return redirect(route('admin.postponeRecords.index'));
        }

        $postponeRecord = $this->postponeRecordRepository->update($request->all(), $id);

        Flash::success('Postpone Record updated successfully.');

        return redirect(route('admin.postponeRecords.index'));
    }

    /**
     * Remove the specified PostponeRecord from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $postponeRecord = $this->postponeRecordRepository->find($id);

        if (empty($postponeRecord)) {
            Flash::error('Postpone Record not found');

            return redirect(route('admin.postponeRecords.index'));
        }

        $this->postponeRecordRepository->delete($id);

        Flash::success('Postpone Record deleted successfully.');

        return redirect(route('admin.postponeRecords.index'));
    }
}
