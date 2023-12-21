<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CreateReporterRequest;
use App\Http\Requests\Admin\UpdateReporterRequest;
use App\Repositories\Admin\ReporterRepository;
use App\Models\Admin\DetectionReport;
use App\Http\Controllers\AppBaseController;
use App\Models\Admin\Reporter;
use Illuminate\Http\Request;
use Flash;
use Response;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;

class ReporterController extends AppBaseController
{
    /** @var ReporterRepository $reporterRepository*/
    private $reporterRepository;

    public function __construct(ReporterRepository $reporterRepo)
    {
        $this->reporterRepository = $reporterRepo;
    }

    /**
     * Display a listing of the Reporter.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        // $reporters = $this->reporterRepository->paginate(10);
        $reporters = Reporter::orderBy('created_at', 'DESC')->cursor();

        return view('admin.reporters.index')
            ->with('reporters', $reporters);
    }

    /**
     * Show the form for creating a new Reporter.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.reporters.create');
    }

    /**
     * Store a newly created Reporter in storage.
     *
     * @param CreateReporterRequest $request
     *
     * @return Response
     */
    public function store(CreateReporterRequest $request)
    {
        $input = $request->all();

        if ($input['reporter_fax'] == null || $input['reporter_fax'] == '') {
            $input['reporter_fax'] = '';
        }

        $image = $request->file('reporter_seal');

        if ($image) {
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/images/reporter_info/'.$input['reporter_name'].'/photo_seal'), $filename);

            $input['reporter_seal'] = 'images/reporter_info/'.$input['reporter_name'].'/photo_seal/' . $filename;
        } else {
            $input['reporter_seal'] = '';
        }

        $reporter = $this->reporterRepository->create($input);

        Flash::success('Reporter saved successfully.');

        return redirect(route('admin.reporters.index'));
    }

    /**
     * Display the specified Reporter.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $reporter = $this->reporterRepository->find($id);

        if (empty($reporter)) {
            Flash::error('Reporter not found');

            return redirect(route('admin.reporters.index'));
        }

        return view('admin.reporters.show')->with('reporter', $reporter);
    }

    /**
     * Show the form for editing the specified Reporter.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $reporter = $this->reporterRepository->find($id);

        if (empty($reporter)) {
            Flash::error('Reporter not found');

            return redirect(route('admin.reporters.index'));
        }

        return view('admin.reporters.edit')->with('reporter', $reporter);
    }

    /**
     * Update the specified Reporter in storage.
     *
     * @param int $id
     * @param UpdateReporterRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateReporterRequest $request)
    {
        $reporter = $this->reporterRepository->find($id);

        if (empty($reporter)) {
            Flash::error('Reporter not found');

            return redirect(route('admin.reporters.index'));
        }
        $input = $request->all();

        $image = $request->file('reporter_seal');

        if ($image) {
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/images/reporter_info/'.$reporter->reporter_name.'/photo_seal'), $filename);

            if ($reporter->reporter_seal != null) {
                // 若已存在，則覆蓋原有圖片
                if (File::exists(public_path('uploads/' . $reporter->reporter_seal))) {
                    File::delete(public_path('uploads/' . $reporter->reporter_seal));
                }
            }
            $input['reporter_seal'] = 'images/reporter_info/'.$reporter->reporter_name.'/photo_seal/' . $filename;
        } else {
            $input['reporter_seal'] = $reporter->reporter_seal;
        }

        $reporter = $this->reporterRepository->update($input, $id);

        Flash::success('Reporter updated successfully.');

        return redirect(route('admin.reporters.index'));
    }

    /**
     * Remove the specified Reporter from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $reporter = $this->reporterRepository->find($id);

        if (empty($reporter)) {
            Flash::error('Reporter not found');

            return redirect(route('admin.reporters.index'));
        }

        // $detectionReports = DetectionReport::all();

        // $detectionRepoters = array_filter($detectionReports->toArray(), function($dr) use($id) {
        //     return $id == $dr['reports_reporter'];
        // });

        $detectionReporters = $reporter->detectionReports;

        if (count($detectionReporters) > 0) {
            Flash::error('檢測報告資料關聯使用中，受保護無法移除。');

            return redirect(route('admin.reporters.index'));
        }


        $this->reporterRepository->delete($id);

        Flash::success('Reporter deleted successfully.');

        return redirect(route('admin.reporters.index'));
    }
}
