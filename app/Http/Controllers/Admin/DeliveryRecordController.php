<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CreateDeliveryRecordRequest;
use App\Http\Requests\Admin\UpdateDeliveryRecordRequest;
use App\Repositories\Admin\DeliveryRecordRepository;
use App\Http\Controllers\AppBaseController;
use App\Models\Admin\DeliveryRecord;
use App\Models\Admin\DetectionReport;
use App\Repositories\Admin\DetectionReportRepository as DetectionReportRep;
use Illuminate\Http\Request;
use Flash;
use Response;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\File;
use Ilovepdf\Ilovepdf;

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

        DetectionReport::whereIn('id', $deliveryRecord->report_id)->update(["reports_authorize_status" => DetectionReportRep::UNDELIVERY]);

        $this->deliveryRecordRepository->delete($id);

        Flash::success('Delivery Record deleted successfully.');

        return redirect(route('admin.deliveryRecords.index'));
    }

    public function convertToPdfWithContract_s1(Request $request)
    {
        $word = $request->input('word');
        $pdf = $request->input('pdf');

        // 提取 URL 的路徑部分
        $path = parse_url($pdf, PHP_URL_PATH);

        // 獲取路徑資訊
        $pathInfo = pathinfo($path);

        // 找到檔案所在的目錄
        $directoryPathPdf = $pathInfo['dirname'];
        // dd($directoryPathPdf);

        $key2 = ['publicKey' => 'project_public_0972a67458e4dd3ac4561edec19a48ed_pWfxHf7de3bcb072e2b66fc59b5cf8ded47d7', 'secretKey' => 'secret_key_f428272dfee9a265364aeadf9d895a8a_UMGYM186d525137876fd82fbc8a61f341c725'];
        $key0 = ['publicKey' => 'project_public_f836502ed5f152f32db3c629ea4e5e82_MGHoj609fd77dc53495844616498db7ad600c', 'secretKey' => 'secret_key_aa4949f7e3438233c7616c9d2dc9aed9_B1lHnd6b086e1d99ace45e9cec81f8b2c8d97'];
        $key1 = ['publicKey' => 'project_public_a2b3acf35565b86653184bfb72cbe84f_OA2Umd21be5a86ceee9d663ccd7719e1133cf', 'secretKey' => 'secret_key_cc3a4552e6a37a60ed0ad49fe054ff57_ccgD2bc2e2820e351f8f860332455148ce8e0'];

        $pdfKey = [$key0, $key1, $key2];

        $maxAttempts = 3; // 最大重試次數
        $attempts = 0; // 目前的嘗試次數

        while ($attempts < $maxAttempts) {

            $ilovepdf = new Ilovepdf($pdfKey[$attempts]['publicKey'], $pdfKey[$attempts]['secretKey']);
            try {
                // 嘗試要執行的操作
                // 例如：資料庫查詢、外部API調用等
                $myTask = $ilovepdf->newTask('officepdf');
                $file1 = $myTask->addFile($word);
                $myTask->execute();
                $myTask->download(public_path($directoryPathPdf));

                break; // 如果操作成功，跳出循環
            } catch (\Exception $e) {
                $attempts++; // 增加嘗試次數
                if ($attempts == $maxAttempts) {
                    // 如果達到最大嘗試次數，可以選擇拋出異常或者處理錯誤
                    throw $e;
                }

                // 可選：在重試之前暫停一段時間
                sleep(1); // 休息1秒
            }
        }

        return \Response::json(['status' => 'success']);
    }
}
