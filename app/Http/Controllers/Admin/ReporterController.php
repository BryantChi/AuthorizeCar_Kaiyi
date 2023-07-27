<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CreateReporterRequest;
use App\Http\Requests\Admin\UpdateReporterRequest;
use App\Repositories\Admin\ReporterRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

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
        $reporters = $this->reporterRepository->paginate(10);

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

        $reporter = $this->reporterRepository->update($request->all(), $id);

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

        $this->reporterRepository->delete($id);

        Flash::success('Reporter deleted successfully.');

        return redirect(route('admin.reporters.index'));
    }
}
