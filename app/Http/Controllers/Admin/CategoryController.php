<?php

namespace App\Http\Controllers\Admin;


use App\Repositories\CategoryRepository;
use App\Http\Requests\Admin\Category\EditRequest;
use App\Http\Requests\Admin\Category\StoreRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
        parent::__construct();
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('cp.category.index')->with('title', 'Категория подписчиков');
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('cp.category.create_edit')->with('title', 'Добавление категории');
    }

    /**
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $this->categoryRepository->create($request->all());

        return redirect()->route('category.index')->with('success', 'Информация успешно добавлена');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $row = $this->categoryRepository->find($id);

        return view('cp.category.create_edit', compact('row'))->with('title', 'Редактирование категории');
    }

    /**
     * @param EditRequest $request
     * @return RedirectResponse
     */
    public function update(EditRequest $request): RedirectResponse
    {
        $this->categoryRepository->update($request->id, $request->all());

        return redirect()->route('category.index')->with('success', 'Данные обновлены');
    }

    /**
     * @param Request $request
     * @return void
     */
    public function destroy(Request $request): void
    {
        $this->categoryRepository->delete($request->id);
    }
}
