<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CreateAuthorizeStatusRequest;
use App\Http\Requests\Admin\UpdateAuthorizeStatusRequest;
use App\Repositories\Admin\AuthorizeStatusRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class AuthorizeStatusController extends AppBaseController
{
    /** @var AuthorizeStatusRepository $authorizeStatusRepository*/
    private $authorizeStatusRepository;

    public function __construct(AuthorizeStatusRepository $authorizeStatusRepo)
    {
        $this->authorizeStatusRepository = $authorizeStatusRepo;
    }

    /**
     * Display a listing of the AuthorizeStatus.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $authorizeStatuses = $this->authorizeStatusRepository->paginate(10);

        return view('admin.authorize_statuses.index')
            ->with('authorizeStatuses', $authorizeStatuses);
    }

    /**
     * Show the form for creating a new AuthorizeStatus.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.authorize_statuses.create');
    }

    /**
     * Store a newly created AuthorizeStatus in storage.
     *
     * @param CreateAuthorizeStatusRequest $request
     *
     * @return Response
     */
    public function store(CreateAuthorizeStatusRequest $request)
    {
        $input = $request->all();

        $authorizeStatus = $this->authorizeStatusRepository->create($input);

        Flash::success('Authorize Status saved successfully.');

        return redirect(route('admin.authorizeStatuses.index'));
    }

    /**
     * Display the specified AuthorizeStatus.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $authorizeStatus = $this->authorizeStatusRepository->find($id);

        if (empty($authorizeStatus)) {
            Flash::error('Authorize Status not found');

            return redirect(route('admin.authorizeStatuses.index'));
        }

        return view('admin.authorize_statuses.show')->with('authorizeStatus', $authorizeStatus);
    }

    /**
     * Show the form for editing the specified AuthorizeStatus.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $authorizeStatus = $this->authorizeStatusRepository->find($id);

        if (empty($authorizeStatus)) {
            Flash::error('Authorize Status not found');

            return redirect(route('admin.authorizeStatuses.index'));
        }

        return view('admin.authorize_statuses.edit')->with('authorizeStatus', $authorizeStatus);
    }

    /**
     * Update the specified AuthorizeStatus in storage.
     *
     * @param int $id
     * @param UpdateAuthorizeStatusRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAuthorizeStatusRequest $request)
    {
        $authorizeStatus = $this->authorizeStatusRepository->find($id);

        if (empty($authorizeStatus)) {
            Flash::error('Authorize Status not found');

            return redirect(route('admin.authorizeStatuses.index'));
        }

        $authorizeStatus = $this->authorizeStatusRepository->update($request->all(), $id);

        Flash::success('Authorize Status updated successfully.');

        return redirect(route('admin.authorizeStatuses.index'));
    }

    /**
     * Remove the specified AuthorizeStatus from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $authorizeStatus = $this->authorizeStatusRepository->find($id);

        if (empty($authorizeStatus)) {
            Flash::error('Authorize Status not found');

            return redirect(route('admin.authorizeStatuses.index'));
        }

        $this->authorizeStatusRepository->delete($id);

        Flash::success('Authorize Status deleted successfully.');

        return redirect(route('admin.authorizeStatuses.index'));
    }
}
