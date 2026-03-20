<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\Complaints\DeleteRequest;
use App\Repositories\InvitesRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class InvitesController extends Controller
{
    public function __construct(
        private readonly InvitesRepository $invitesRepository,
    )
    {
        parent::__construct();
    }

    public function index(): View
    {
        return view('cp.invites.index')
            ->with('title', 'Приглашения в тендре');
    }

    public function edit(int $id): View
    {
        $row = $this->invitesRepository->find($id);

        abort_if($row === null, 404);

        return view('cp.invites.edit', compact('row'))
            ->with('title', 'Приглашения в тендре');
    }

    public function destroy(DeleteRequest $request): void
    {
        $this->invitesRepository->delete($request->id);
    }
}