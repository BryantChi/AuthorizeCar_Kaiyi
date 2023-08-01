<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CreateCarBrandRequest;
use App\Http\Requests\Admin\UpdateCarBrandRequest;
use App\Repositories\Admin\CarBrandRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class CarBrandController extends AppBaseController
{
    /** @var CarBrandRepository $carBrandRepository*/
    private $carBrandRepository;

    public function __construct(CarBrandRepository $carBrandRepo)
    {
        $this->carBrandRepository = $carBrandRepo;
    }

    /**
     * Display a listing of the CarBrand.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $carBrands = $this->carBrandRepository->paginate(10);

        return view('admin.car_brands.index')
            ->with('carBrands', $carBrands);
    }

    /**
     * Show the form for creating a new CarBrand.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.car_brands.create');
    }

    /**
     * Store a newly created CarBrand in storage.
     *
     * @param CreateCarBrandRequest $request
     *
     * @return Response
     */
    public function store(CreateCarBrandRequest $request)
    {
        $input = $request->all();

        $carBrand = $this->carBrandRepository->create($input);

        Flash::success('Car Brand saved successfully.');

        return redirect(route('admin.carBrands.index'));
    }

    /**
     * Display the specified CarBrand.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $carBrand = $this->carBrandRepository->find($id);

        if (empty($carBrand)) {
            Flash::error('Car Brand not found');

            return redirect(route('admin.carBrands.index'));
        }

        return view('admin.car_brands.show')->with('carBrand', $carBrand);
    }

    /**
     * Show the form for editing the specified CarBrand.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $carBrand = $this->carBrandRepository->find($id);

        if (empty($carBrand)) {
            Flash::error('Car Brand not found');

            return redirect(route('admin.carBrands.index'));
        }

        return view('admin.car_brands.edit')->with('carBrand', $carBrand);
    }

    /**
     * Update the specified CarBrand in storage.
     *
     * @param int $id
     * @param UpdateCarBrandRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCarBrandRequest $request)
    {
        $carBrand = $this->carBrandRepository->find($id);

        if (empty($carBrand)) {
            Flash::error('Car Brand not found');

            return redirect(route('admin.carBrands.index'));
        }

        $carBrand = $this->carBrandRepository->update($request->all(), $id);

        Flash::success('Car Brand updated successfully.');

        return redirect(route('admin.carBrands.index'));
    }

    /**
     * Remove the specified CarBrand from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $carBrand = $this->carBrandRepository->find($id);

        if (empty($carBrand)) {
            Flash::error('Car Brand not found');

            return redirect(route('admin.carBrands.index'));
        }

        $this->carBrandRepository->delete($id);

        Flash::success('Car Brand deleted successfully.');

        return redirect(route('admin.carBrands.index'));
    }
}
