<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\Requests\DeleteRequest;
use App\Http\Requests\Admin\Requests\EditRequest;
use App\Models\Requests;
use App\Repositories\RequestsRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Exception;

class RequestsController extends Controller
{
    /**
     * @param RequestsRepository $repositoryRepository
     */
    public function __construct(private RequestsRepository $repositoryRepository)
    {
        parent::__construct();
    }

    public function index(): View
    {
        return view('cp.requests.index')->with('title', 'Запросы номенклатуры');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $row = $this->repositoryRepository->find($id);

        if (!$row) abort(404);

        $options = Requests::getOption();

        return view('cp.requests.edit', compact('row', 'options'))->with('title', 'Редактирование запроса номенклатуры: #' . $row->id);
    }

    /**
     * @param EditRequest $request
     * @return RedirectResponse
     */
    public function update(EditRequest $request): RedirectResponse
    {
        try {
            $this->repositoryRepository->update($request->id, $request->all());
        } catch (Exception $e) {
            report($e);

            return redirect()
                ->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }

        return redirect()->route('admin.requests.index')->with('success', 'Данные успешно обновлены');
    }

    /**
     * @param DeleteRequest $request
     * @return void
     */
    public function destroy(DeleteRequest $request): void
    {
        $this->repositoryRepository->remove($request->id);
    }
}