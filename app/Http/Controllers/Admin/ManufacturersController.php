<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\StringHelper;
use App\Http\Requests\Admin\Manufacturers\EditRequest;
use App\Http\Requests\Admin\Manufacturers\StoreRequest;
use App\Http\Requests\Admin\Manufacturers\DeleteRequest;
use App\Repositories\ManufacturerRepository;
use App\Services\ManufacturerService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Exception;

class ManufacturersController extends Controller
{
    /**
     * @param ManufacturerRepository $manufacturerRepository
     * @param ManufacturerService $manufacturerService
     */
    public function __construct(
        private ManufacturerRepository $manufacturerRepository,
        private ManufacturerService    $manufacturerService)
    {
        parent::__construct();
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('cp.manufacturers.index')->with('title', 'Производители');
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $maxUploadFileSize = StringHelper::maxUploadFileSize();

        return view('cp.manufacturers.create_edit', compact('maxUploadFileSize'))->with('title', 'Добавление производителя');
    }

    /**
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        try {
            if ($request->hasFile('image')) {
                $originName = $this->manufacturerService->storeImage($request);
            }

            $published = 0;

            if ($request->input('published')) {
                $published = 1;
            }

            $seo_sitemap = 0;

            if ($request->input('seo_sitemap')) {
                $seo_sitemap = 1;
            }

            $this->manufacturerRepository->create(array_merge($request->all(), [
                'image' => $originName ?? null,
                'published' => $published,
                'seo_sitemap' => $seo_sitemap,
            ]));
        } catch (Exception $e) {
            report($e);

            return redirect()
                ->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }

        return redirect()->route('admin.manufacturers.index')->with('success', 'Данные успешно добавлены');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $row = $this->manufacturerRepository->find($id);

        if (!$row) abort(404);

        $maxUploadFileSize = StringHelper::maxUploadFileSize();

        return view('cp.manufacturers.create_edit', compact('row', 'maxUploadFileSize'))->with('title', 'Редактирование производителя');
    }

    /**
     * @param EditRequest $request
     * @return RedirectResponse
     */
    public function update(EditRequest $request): RedirectResponse
    {
        try {
            $row = $this->manufacturerRepository->find($request->input('id'));

            $image = $request->pic;

            if ($image != null) {
                $this->manufacturerService->deleteImage($row);
            }

            if ($request->hasFile('image')) {
                $originName = $this->manufacturerService->updateImage($row, $request);
            }

            $published = 0;

            if ($request->input('published')) {
                $published = 1;
            }

            $seo_sitemap = 0;

            if ($request->input('seo_sitemap')) {
                $seo_sitemap = 1;
            }

            $this->manufacturerRepository->updateWithMapping($request->id, array_merge($request->all(), [
                'seo_sitemap' => $seo_sitemap,
                'image' => $originName ?? null,
                'published' => $published,
            ]));
        } catch (Exception $e) {
            report($e);

            return redirect()
                ->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }

        return redirect()->route('admin.manufacturers.index')->with('success', 'Данные успешно обновлены');
    }

    /**
     * @param DeleteRequest $request
     * @return void
     */
    public function destroy(DeleteRequest $request): void
    {
        $this->manufacturerRepository->remove($request->id);
    }
}