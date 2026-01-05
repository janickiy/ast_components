<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests\Admin\News\DeleteRequest;
use App\Repositories\RedirectRepository;
use App\Http\Requests\Admin\Redirect\EditRequest;
use App\Http\Requests\Admin\Redirect\StoreRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class RedirectController extends Controller
{

    /**
     * @var RedirectRepository
     */
    private RedirectRepository $redirectRepository;

    /**
     * @param RedirectRepository $redirectRepository
     */
    public function __construct(RedirectRepository $redirectRepository)
    {
        $this->redirectRepository = $redirectRepository;
        parent::__construct();
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('cp.redirect.index')->with('title', 'Редиректы');
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('cp.redirect.create_edit')->with('title', 'Добавление редиректа');
    }

    /**
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $this->redirectRepository->create($request->all());

        return redirect()->route('admin.redirect.index')->with('success', 'Информация успешно добавлена');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $row = $this->redirectRepository->find($id);

        if (!$row) abort(404);

        return view('cp.redirect.edit', compact('row'))->with('title', 'Редактирование редиректы');
    }

    /**
     * @param EditRequest $request
     * @return RedirectResponse
     */
    public function update(EditRequest $request): RedirectResponse
    {
        $this->redirectRepository->update($request->id, $request->all());

        return redirect()->route('admin.redirect.index')->with('success', 'Данные успешно обновлены');
    }

    /**
     * @param DeleteRequest $request
     * @return void
     */
    public function destroy(DeleteRequest $request): void
    {
        $this->redirectRepository->delete($request->id);
    }
}