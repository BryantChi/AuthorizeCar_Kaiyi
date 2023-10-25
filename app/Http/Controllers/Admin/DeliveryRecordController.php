<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CreateDeliveryRecordRequest;
use App\Http\Requests\Admin\UpdateDeliveryRecordRequest;
use App\Repositories\Admin\DeliveryRecordRepository;
use App\Http\Controllers\AppBaseController;
use App\Models\Admin\DeliveryRecord;
use Illuminate\Http\Request;
use Flash;
use Response;
use Yajra\DataTables\DataTables;

class DeliveryRecordController extends AppBaseController
{
    /** @var DeliveryRecordRepository $deliveryRecordRepository*/
    private $deliveryRecordRepository;

    public function __construct(DeliveryRecordRepository $deliveryRecordRepo)
    {
        $this->deliveryRecordRepository = $deliveryRecordRepo;
    }

    /**
     * Display a listing of the DeliveryRecord.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        // $deliveryRecords = $this->deliveryRecordRepository->paginate(10);
        // $deliveryRecords = $this->deliveryRecordRepository->all();
        $deliveryRecords = DeliveryRecord::orderBy('created_at', 'DESC')->cursor();

        return view('admin.delivery_records.index')
            ->with('deliveryRecords', $deliveryRecords);
    }

    /**
     * Show the form for creating a new DeliveryRecord.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.delivery_records.create');
    }

    /**
     * Store a newly created DeliveryRecord in storage.
     *
     * @param CreateDeliveryRecordRequest $request
     *
     * @return Response
     */
    public function store(CreateDeliveryRecordRequest $request)
    {
        $input = $request->all();

        $deliveryRecord = $this->deliveryRecordRepository->create($input);

        Flash::success('Delivery Record saved successfully.');

        return redirect(route('admin.deliveryRecords.index'));
    }

    /**
     * Display the specified DeliveryRecord.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $deliveryRecord = $this->deliveryRecordRepository->find($id);

        if (empty($deliveryRecord)) {
            Flash::error('Delivery Record not found');

            return redirect(route('admin.deliveryRecords.index'));
        }

        return view('admin.delivery_records.show')->with('deliveryRecord', $deliveryRecord);
    }

    /**
     * Show the form for editing the specified DeliveryRecord.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $deliveryRecord = $this->deliveryRecordRepository->find($id);

        if (empty($deliveryRecord)) {
            Flash::error('Delivery Record not found');

            return redirect(route('admin.deliveryRecords.index'));
        }

        return view('admin.delivery_records.edit')->with('deliveryRecord', $deliveryRecord);
    }

    /**
     * Update the specified DeliveryRecord in storage.
     *
     * @param int $id
     * @param UpdateDeliveryRecordRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDeliveryRecordRequest $request)
    {
        $deliveryRecord = $this->deliveryRecordRepository->find($id);

        if (empty($deliveryRecord)) {
            Flash::error('Delivery Record not found');

            return redirect(route('admin.deliveryRecords.index'));
        }

        $deliveryRecord = $this->deliveryRecordRepository->update($request->all(), $id);

        Flash::success('Delivery Record updated successfully.');

        return redirect(route('admin.deliveryRecords.index'));
    }

    /**
     * Remove the specified DeliveryRecord from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $deliveryRecord = $this->deliveryRecordRepository->find($id);

        if (empty($deliveryRecord)) {
            Flash::error('Delivery Record not found');

            return redirect(route('admin.deliveryRecords.index'));
        }

        $this->deliveryRecordRepository->delete($id);

        Flash::success('Delivery Record deleted successfully.');

        return redirect(route('admin.deliveryRecords.index'));
    }
}
