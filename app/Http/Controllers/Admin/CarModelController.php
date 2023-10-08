<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CreateCarModelRequest;
use App\Http\Requests\Admin\UpdateCarModelRequest;
use App\Repositories\Admin\CarModelRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;
use App\Models\Admin\CarBrand;
use App\Models\Admin\CarModel;
use App\Models\Admin\DetectionReport;

class CarModelController extends AppBaseController
{
    /** @var CarModelRepository $carModelRepository*/
    private $carModelRepository;

    public function __construct(CarModelRepository $carModelRepo)
    {
        $this->carModelRepository = $carModelRepo;
    }

    /**
     * Display a listing of the CarModel.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        // $carModels = $this->carModelRepository->paginate(10);
        $carModels = CarModel::orderBy('created_at', 'DESC')->cursor();

        return view('admin.car_models.index')
            ->with('carModels', $carModels);
    }

    /**
     * Show the form for creating a new CarModel.
     *
     * @return Response
     */
    public function create()
    {
        $brand = CarBrand::all();
        return view('admin.car_models.create', ['brand' => $brand]);
    }

    /**
     * Store a newly created CarModel in storage.
     *
     * @param CreateCarModelRequest $request
     *
     * @return Response
     */
    public function store(CreateCarModelRequest $request)
    {
        $input = $request->all();

        $carModel = $this->carModelRepository->create($input);

        Flash::success('Car Model saved successfully.');

        return redirect(route('admin.carModels.index'));
    }

    /**
     * Display the specified CarModel.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $carModel = $this->carModelRepository->find($id);

        if (empty($carModel)) {
            Flash::error('Car Model not found');

            return redirect(route('admin.carModels.index'));
        }

        return view('admin.car_models.show')->with('carModel', $carModel);
    }

    /**
     * Show the form for editing the specified CarModel.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $carModel = $this->carModelRepository->find($id);
        $brand = CarBrand::all();

        if (empty($carModel)) {
            Flash::error('Car Model not found');

            return redirect(route('admin.carModels.index'));
        }

        return view('admin.car_models.edit', ['carModel' => $carModel, 'brand' => $brand]);
    }

    /**
     * Update the specified CarModel in storage.
     *
     * @param int $id
     * @param UpdateCarModelRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCarModelRequest $request)
    {
        $carModel = $this->carModelRepository->find($id);

        if (empty($carModel)) {
            Flash::error('Car Model not found');

            return redirect(route('admin.carModels.index'));
        }

        $carModel = $this->carModelRepository->update($request->all(), $id);

        Flash::success('Car Model updated successfully.');

        return redirect(route('admin.carModels.index'));
    }

    /**
     * Remove the specified CarModel from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $carModel = $this->carModelRepository->find($id);

        if (empty($carModel)) {
            Flash::error('Car Model not found');

            return redirect(route('admin.carModels.index'));
        }

        $detectionReport = DetectionReport::all();

        $detectionReporters = array_filter($detectionReport->toArray(), function ($dr) use($id) {
            return $id == $dr['reports_car_model'];
        });

        if (count($detectionReporters) > 0) {
            Flash::error('檢測報告資料關聯使用中，受保護無法移除。');

            return redirect(route('admin.carModels.index'));
        }

        $this->carModelRepository->delete($id);

        Flash::success('Car Model deleted successfully.');

        return redirect(route('admin.carModels.index'));
    }

    public function getModelsByBrand(Request $request)
    {
        $brand_id = $request->input('brand_id');
        $models = CarModel::where('car_brand_id', $brand_id)->get(['id', 'model_name']);

        return response()->json($models);
    }
}
