<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CreateCarPatternRequest;
use App\Http\Requests\Admin\UpdateCarPatternRequest;
use App\Repositories\Admin\CarPatternRepository;
use App\Http\Controllers\AppBaseController;
use App\Models\Admin\CarPattern;
use App\Models\Admin\DetectionReport;
use Illuminate\Http\Request;
use Flash;
use Response;

class CarPatternController extends AppBaseController
{
    /** @var CarPatternRepository $carPatternRepository*/
    private $carPatternRepository;

    public function __construct(CarPatternRepository $carPatternRepo)
    {
        $this->carPatternRepository = $carPatternRepo;
    }

    /**
     * Display a listing of the CarPattern.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $carPatterns = CarPattern::orderBy('created_at', 'DESC')->cursor();

        return view('admin.car_patterns.index')
            ->with('carPatterns', $carPatterns);
    }

    /**
     * Show the form for creating a new CarPattern.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.car_patterns.create');
    }

    /**
     * Store a newly created CarPattern in storage.
     *
     * @param CreateCarPatternRequest $request
     *
     * @return Response
     */
    public function store(CreateCarPatternRequest $request)
    {
        $input = $request->all();

        $carPattern = $this->carPatternRepository->create($input);

        Flash::success('Car Pattern saved successfully.');

        return redirect(route('admin.carPatterns.index'));
    }

    /**
     * Display the specified CarPattern.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $carPattern = $this->carPatternRepository->find($id);

        if (empty($carPattern)) {
            Flash::error('Car Pattern not found');

            return redirect(route('admin.carPatterns.index'));
        }

        return view('admin.car_patterns.show')->with('carPattern', $carPattern);
    }

    /**
     * Show the form for editing the specified CarPattern.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $carPattern = $this->carPatternRepository->find($id);

        if (empty($carPattern)) {
            Flash::error('Car Pattern not found');

            return redirect(route('admin.carPatterns.index'));
        }

        return view('admin.car_patterns.edit')->with('carPattern', $carPattern);
    }

    /**
     * Update the specified CarPattern in storage.
     *
     * @param int $id
     * @param UpdateCarPatternRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCarPatternRequest $request)
    {
        $carPattern = $this->carPatternRepository->find($id);

        if (empty($carPattern)) {
            Flash::error('Car Pattern not found');

            return redirect(route('admin.carPatterns.index'));
        }

        $carPattern = $this->carPatternRepository->update($request->all(), $id);

        Flash::success('Car Pattern updated successfully.');

        return redirect(route('admin.carPatterns.index'));
    }

    /**
     * Remove the specified CarPattern from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $carPattern = $this->carPatternRepository->find($id);

        if (empty($carPattern)) {
            Flash::error('Car Pattern not found');

            return redirect(route('admin.carPatterns.index'));
        }

        $detectionReport = DetectionReport::where('reports_vehicle_pattern', $id)->get();

        if (count($detectionReport) > 0) {
            Flash::error('檢測報告資料關聯使用中，受保護無法移除。');
            return redirect(route('admin.carPatterns.index'));
        }

        $this->carPatternRepository->delete($id);

        Flash::success('Car Pattern deleted successfully.');

        return redirect(route('admin.carPatterns.index'));
    }
}
