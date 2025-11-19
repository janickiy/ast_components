<?php

namespace App\Http\Controllers\Admin;


use App\Repositories\SeoRepository;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class SeoController extends Controller
{
    /**
     * @var SeoRepository
     */
    private SeoRepository $seoRepository;

    /**
     * @param SeoRepository $seoRepository
     */
    public function __construct(SeoRepository $seoRepository)
    {
        $this->seoRepository = $seoRepository;
        parent::__construct();
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('cp.seo.index')->with('title', 'Seo');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $row = $this->seoRepository->find($id);

        if (!$row) abort(404);

        return view('cp.seo.edit', compact('row'))->with('title', 'Редактирование seo');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        $this->seoRepository->update($request->all());

        return redirect()->route('admin.seo.index')->with('success', 'Данные успешно обновлены');
    }
}