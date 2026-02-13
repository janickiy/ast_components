<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests\Admin\Complaints\DeleteRequest;
use App\Http\Requests\Admin\Complaints\EditRequest;
use App\Models\Complaints;
use App\Repositories\ComplaintsRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ComplaintsController extends Controller
{
    /**
     * @param ComplaintsRepository $complaintsRepository
     */
    public function __construct(private ComplaintsRepository $complaintsRepository)
    {
        parent::__construct();
    }

    public function index(): View
    {
        return view('cp.complaints.index')->with('title', 'Претензии');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $row = $this->complaintsRepository->find($id);

        if (!$row) abort(404);

        $options = Complaints::getOption();

        return view('cp.complaints.edit', compact('row', 'options'))->with('title', 'Редактирование претензии: #' . $row->id . ' ' . $row?->customer?->name);
    }

    /**
     * @param EditRequest $request
     * @return RedirectResponse
     */
    public function update(EditRequest $request): RedirectResponse
    {
        $this->complaintsRepository->updateWithMapping($request->id, $request->all());

        return redirect()->route('admin.complaints.index')->with('success', 'Данные успешно обновлены');
    }

    /**
     * @param DeleteRequest $request
     * @return void
     */
    public function destroy(DeleteRequest $request): void
    {
        $this->complaintsRepository->remove($request->id);
    }

}