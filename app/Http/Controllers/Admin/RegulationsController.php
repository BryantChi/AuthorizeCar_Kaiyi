<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CreateRegulationsRequest;
use App\Http\Requests\Admin\UpdateRegulationsRequest;
use App\Repositories\Admin\RegulationsRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;
use Illuminate\Support\Facades\Validator;

class RegulationsController extends AppBaseController
{
    /** @var RegulationsRepository $regulationsRepository*/
    private $regulationsRepository;

    public function __construct(RegulationsRepository $regulationsRepo)
    {
        $this->regulationsRepository = $regulationsRepo;
    }

    /**
     * Display a listing of the Regulations.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $regulations = $this->regulationsRepository->paginate(10);

        return view('admin.regulations.index')
            ->with('regulations', $regulations);
    }

    /**
     * Show the form for creating a new Regulations.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.regulations.create');
    }

    /**
     * Store a newly created Regulations in storage.
     *
     * @param CreateRegulationsRequest $request
     *
     * @return Response
     */
    public function store(CreateRegulationsRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'regulations_num' => 'required|unique:regulations_infos,regulations_num',
        ], [
            'regulations_num.required' => '請填寫編號',
            'regulations_num.unique' => '法規編號不可重複',
        ]);


        if ($validator->fails()) {
            return redirect(route('admin.regulations.create'))
                ->withErrors($validator)
                ->withInput();
        }

        $input = $request->all();

        $regulations = $this->regulationsRepository->create($input);

        Flash::success('Regulations saved successfully.');

        return redirect(route('admin.regulations.index'));
    }

    /**
     * Display the specified Regulations.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $regulations = $this->regulationsRepository->find($id);

        if (empty($regulations)) {
            Flash::error('Regulations not found');

            return redirect(route('admin.regulations.index'));
        }

        return view('admin.regulations.show')->with('regulations', $regulations);
    }

    /**
     * Show the form for editing the specified Regulations.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $regulations = $this->regulationsRepository->find($id);

        if (empty($regulations)) {
            Flash::error('Regulations not found');

            return redirect(route('admin.regulations.index'));
        }

        return view('admin.regulations.edit')->with('regulations', $regulations);
    }

    /**
     * Update the specified Regulations in storage.
     *
     * @param int $id
     * @param UpdateRegulationsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRegulationsRequest $request)
    {
        $regulations = $this->regulationsRepository->find($id);

        if (empty($regulations)) {
            Flash::error('Regulations not found');

            return redirect(route('admin.regulations.index'));
        }

        $regulations = $this->regulationsRepository->update($request->all(), $id);

        Flash::success('Regulations updated successfully.');

        return redirect(route('admin.regulations.index'));
    }

    /**
     * Remove the specified Regulations from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $regulations = $this->regulationsRepository->find($id);

        if (empty($regulations)) {
            Flash::error('Regulations not found');

            return redirect(route('admin.regulations.index'));
        }

        $this->regulationsRepository->delete($id);

        Flash::success('Regulations deleted successfully.');

        return redirect(route('admin.regulations.index'));
    }
}
