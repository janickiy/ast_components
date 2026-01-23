<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\Complaints\DeleteRequest;
use App\Repositories\InvitesRepository;
use Illuminate\View\View;

class InvitesController extends Controller
{
    /**
     * @param InvitesRepository $invitesRepository
     */
    public function __construct(private InvitesRepository $invitesRepository)
    {
        parent::__construct();
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('cp.invites.index')->with('title', 'Приглашения в тендре');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $row = $this->invitesRepository->find($id);

        if (!$row) abort(404);

        return view('cp.invites.edit', compact('row'))->with('title', 'Приглашения в тендре');
    }

    /**
     * @param DeleteRequest $request
     * @return void
     */
    public function destroy(DeleteRequest $request): void
    {
        $this->invitesRepository->delete($request->id);
    }
}