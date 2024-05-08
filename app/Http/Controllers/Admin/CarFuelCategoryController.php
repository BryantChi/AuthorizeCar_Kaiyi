<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CreateCarFuelCategoryRequest;
use App\Http\Requests\Admin\UpdateCarFuelCategoryRequest;
use App\Repositories\Admin\CarFuelCategoryRepository;
use App\Http\Controllers\AppBaseController;
use App\Models\Admin\CarFuelCategory;
use App\Models\Admin\DetectionReport;
use Illuminate\Http\Request;
use Flash;
use Response;

class CarFuelCategoryController extends AppBaseController
{
    /** @var CarFuelCategoryRepository $carFuelCategoryRepository*/
    private $carFuelCategoryRepository;

    public function __construct(CarFuelCategoryRepository $carFuelCategoryRepo)
    {
        $this->carFuelCategoryRepository = $carFuelCategoryRepo;
    }

    /**
     * Display a listing of the CarFuelCategory.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $carFuelCategories = CarFuelCategory::orderBy('created_at', 'DESC')->cursor();

        return view('admin.car_fuel_categories.index')
            ->with('carFuelCategories', $carFuelCategories);
    }

    /**
     * Show the form for creating a new CarFuelCategory.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.car_fuel_categories.create');
    }

    /**
     * Store a newly created CarFuelCategory in storage.
     *
     * @param CreateCarFuelCategoryRequest $request
     *
     * @return Response
     */
    public function store(CreateCarFuelCategoryRequest $request)
    {
        $input = $request->all();

        $carFuelCategory = $this->carFuelCategoryRepository->create($input);

        Flash::success('Car Fuel Category saved successfully.');

        return redirect(route('admin.carFuelCategories.index'));
    }

    /**
     * Display the specified CarFuelCategory.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $carFuelCategory = $this->carFuelCategoryRepository->find($id);

        if (empty($carFuelCategory)) {
            Flash::error('Car Fuel Category not found');

            return redirect(route('admin.carFuelCategories.index'));
        }

        return view('admin.car_fuel_categories.show')->with('carFuelCategory', $carFuelCategory);
    }

    /**
     * Show the form for editing the specified CarFuelCategory.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $carFuelCategory = $this->carFuelCategoryRepository->find($id);

        if (empty($carFuelCategory)) {
            Flash::error('Car Fuel Category not found');

            return redirect(route('admin.carFuelCategories.index'));
        }

        return view('admin.car_fuel_categories.edit')->with('carFuelCategory', $carFuelCategory);
    }

    /**
     * Update the specified CarFuelCategory in storage.
     *
     * @param int $id
     * @param UpdateCarFuelCategoryRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCarFuelCategoryRequest $request)
    {
        $carFuelCategory = $this->carFuelCategoryRepository->find($id);

        if (empty($carFuelCategory)) {
            Flash::error('Car Fuel Category not found');

            return redirect(route('admin.carFuelCategories.index'));
        }

        $carFuelCategory = $this->carFuelCategoryRepository->update($request->all(), $id);

        Flash::success('Car Fuel Category updated successfully.');

        return redirect(route('admin.carFuelCategories.index'));
    }

    /**
     * Remove the specified CarFuelCategory from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $carFuelCategory = $this->carFuelCategoryRepository->find($id);

        if (empty($carFuelCategory)) {
            Flash::error('Car Fuel Category not found');

            return redirect(route('admin.carFuelCategories.index'));
        }

        $detectionReport = DetectionReport::where('reports_vehicle_fuel_category', $id)->get();

        if (count($detectionReport) > 0) {
            Flash::error('檢測報告資料關聯使用中，受保護無法移除。');
            return redirect(route('admin.carFuelCategories.index'));
        }

        $this->carFuelCategoryRepository->delete($id);

        Flash::success('Car Fuel Category deleted successfully.');

        return redirect(route('admin.carFuelCategories.index'));
    }
}
