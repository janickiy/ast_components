<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\DTO\ArrayData;
use App\Helpers\StringHelper;
use App\Http\Requests\Admin\Manufacturers\DeleteRequest;
use App\Http\Requests\Admin\Manufacturers\EditRequest;
use App\Http\Requests\Admin\Manufacturers\StoreRequest;
use App\Repositories\ManufacturerRepository;
use App\Services\ManufacturerService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ManufacturersController extends Controller
{
    public function __construct(
        private readonly ManufacturerRepository $manufacturerRepository,
        private readonly ManufacturerService $manufacturerService,
    ) {
        parent::__construct();
    }

    public function index(): View
    {
        return view('cp.manufacturers.index', [
            'title' => 'Производители',
        ]);
    }

    public function create(): View
    {
        return view('cp.manufacturers.create_edit', [
            'maxUploadFileSize' => StringHelper::maxUploadFileSize(),
            'title' => 'Добавление производителя',
        ]);
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        try {
            $image = $request->hasFile('image')
                ? $this->manufacturerService->storeImage($request)
                : null;

            $this->manufacturerRepository->create(
                ArrayData::from([
                    ...$request->validated(),
                    'image' => $image,
                    'published' => $request->boolean('published'),
                    'seo_sitemap' => $request->boolean('seo_sitemap'),
                ]),
            );
        } catch (Exception $exception) {
            report($exception);

            return back()
                ->withInput()
                ->with('error', $exception->getMessage());
        }

        return redirect()
            ->route('admin.manufacturers.index')
            ->with('success', 'Данные успешно добавлены');
    }

    public function edit(int $id): View
    {
        $row = $this->manufacturerRepository->find($id);

        abort_if($row === null, 404);

        return view('cp.manufacturers.create_edit', [
            'row' => $row,
            'maxUploadFileSize' => StringHelper::maxUploadFileSize(),
            'title' => 'Редактирование производителя',
        ]);
    }

    public function update(EditRequest $request): RedirectResponse
    {
        try {
            $row = $this->manufacturerRepository->find((int) $request->id);

            abort_if($row === null, 404);

            $image = $row->image;

            if ($request->filled('pic')) {
                $this->manufacturerService->deleteImage($row);
                $image = null;
            }

            if ($request->hasFile('image')) {
                $image = $this->manufacturerService->updateImage($row, $request);
            }

            $this->manufacturerRepository->updateWithMapping(
                (int) $request->id,
                ArrayData::from([
                    ...$request->validated(),
                    'image' => $image,
                    'published' => $request->boolean('published'),
                    'seo_sitemap' => $request->boolean('seo_sitemap'),
                ]),
            );
        } catch (Exception $exception) {
            report($exception);

            return back()
                ->withInput()
                ->with('error', $exception->getMessage());
        }

        return redirect()
            ->route('admin.manufacturers.index')
            ->with('success', 'Данные успешно обновлены');
    }

    public function destroy(DeleteRequest $request): void
    {
        $this->manufacturerRepository->remove((int) $request->id);
    }
}