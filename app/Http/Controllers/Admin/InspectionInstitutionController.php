<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CreateInspectionInstitutionRequest;
use App\Http\Requests\Admin\UpdateInspectionInstitutionRequest;
use App\Repositories\Admin\InspectionInstitutionRepository;
use App\Http\Controllers\AppBaseController;
use App\Models\Admin\DetectionReport;
use App\Models\Admin\InspectionInstitution;
use Illuminate\Http\Request;
use Flash;
use Response;

class InspectionInstitutionController extends AppBaseController
{
    /** @var InspectionInstitutionRepository $inspectionInstitutionRepository*/
    private $inspectionInstitutionRepository;

    public function __construct(InspectionInstitutionRepository $inspectionInstitutionRepo)
    {
        $this->inspectionInstitutionRepository = $inspectionInstitutionRepo;
    }

    /**
     * Display a listing of the InspectionInstitution.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        // $inspectionInstitutions = $this->inspectionInstitutionRepository->paginate(10);
        $inspectionInstitutions = InspectionInstitution::orderBy('created_at', 'DESC')->cursor();

        return view('admin.inspection_institutions.index')
            ->with('inspectionInstitutions', $inspectionInstitutions);
    }

    /**
     * Show the form for creating a new InspectionInstitution.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.inspection_institutions.create');
    }

    /**
     * Store a newly created InspectionInstitution in storage.
     *
     * @param CreateInspectionInstitutionRequest $request
     *
     * @return Response
     */
    public function store(CreateInspectionInstitutionRequest $request)
    {
        $input = $request->all();

        $inspectionInstitution = $this->inspectionInstitutionRepository->create($input);

        Flash::success('Inspection Institution saved successfully.');

        return redirect(route('admin.inspectionInstitutions.index'));
    }

    /**
     * Display the specified InspectionInstitution.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $inspectionInstitution = $this->inspectionInstitutionRepository->find($id);

        if (empty($inspectionInstitution)) {
            Flash::error('Inspection Institution not found');

            return redirect(route('admin.inspectionInstitutions.index'));
        }

        return view('admin.inspection_institutions.show')->with('inspectionInstitution', $inspectionInstitution);
    }

    /**
     * Show the form for editing the specified InspectionInstitution.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $inspectionInstitution = $this->inspectionInstitutionRepository->find($id);

        if (empty($inspectionInstitution)) {
            Flash::error('Inspection Institution not found');

            return redirect(route('admin.inspectionInstitutions.index'));
        }

        return view('admin.inspection_institutions.edit')->with('inspectionInstitution', $inspectionInstitution);
    }

    /**
     * Update the specified InspectionInstitution in storage.
     *
     * @param int $id
     * @param UpdateInspectionInstitutionRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateInspectionInstitutionRequest $request)
    {
        $inspectionInstitution = $this->inspectionInstitutionRepository->find($id);

        if (empty($inspectionInstitution)) {
            Flash::error('Inspection Institution not found');

            return redirect(route('admin.inspectionInstitutions.index'));
        }

        $inspectionInstitution = $this->inspectionInstitutionRepository->update($request->all(), $id);

        Flash::success('Inspection Institution updated successfully.');

        return redirect(route('admin.inspectionInstitutions.index'));
    }

    /**
     * Remove the specified InspectionInstitution from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $inspectionInstitution = $this->inspectionInstitutionRepository->find($id);

        if (empty($inspectionInstitution)) {
            Flash::error('Inspection Institution not found');

            return redirect(route('admin.inspectionInstitutions.index'));
        }

        $detectionReport = DetectionReport::all();

        $detectionReporters = array_filter($detectionReport->toArray(), function ($dr) use($id) {
            return $id == $dr['reports_inspection_institution'];
        });

        if (count($detectionReporters) > 0) {
            Flash::error('檢測報告資料關聯使用中，受保護無法移除。');

            return redirect(route('admin.inspectionInstitutions.index'));
        }

        $this->inspectionInstitutionRepository->delete($id);

        Flash::success('Inspection Institution deleted successfully.');

        return redirect(route('admin.inspectionInstitutions.index'));
    }
}
