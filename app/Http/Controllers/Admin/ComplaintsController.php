<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\DTO\ArrayData;
use App\Http\Requests\Admin\Complaints\DeleteRequest;
use App\Http\Requests\Admin\Complaints\EditRequest;
use App\Models\Complaints;
use App\Repositories\ComplaintsRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ComplaintsController extends Controller
{
    public function __construct(
        private readonly ComplaintsRepository $complaintsRepository,
    ) {
        parent::__construct();
    }

    public function index(): View
    {
        return view('cp.complaints.index', [
            'title' => 'Претензии',
        ]);
    }

    public function edit(int $id): View
    {
        $row = $this->complaintsRepository->find($id);

        abort_if($row === null, 404);

        $title = sprintf(
            'Редактирование претензии: #%d %s',
            $row->id,
            $row->customer?->name ?? '',
        );

        return view('cp.complaints.edit', [
            'row' => $row,
            'options' => Complaints::getOption(),
            'title' => trim($title),
        ]);
    }

    public function update(EditRequest $request): RedirectResponse
    {
        $this->complaintsRepository->updateWithMapping(
            $request->id,
            ArrayData::from($request->validated()),
        );

        return redirect()
            ->route('admin.complaints.index')
            ->with('success', 'Данные успешно обновлены');
    }

    public function destroy(DeleteRequest $request): void
    {
        $this->complaintsRepository->remove($request->id);
    }
}