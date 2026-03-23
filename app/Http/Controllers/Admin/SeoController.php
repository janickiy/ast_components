<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\DTO\ArrayData;
use App\Http\Requests\Admin\Seo\EditRequest;
use App\Repositories\SeoRepository;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SeoController extends Controller
{
    public function __construct(
        private readonly SeoRepository $seoRepository,
    ) {
        parent::__construct();
    }

    public function index(): View
    {
        return view('cp.seo.index', [
            'title' => 'Seo',
        ]);
    }

    public function edit(int $id): View
    {
        $row = $this->seoRepository->find($id);

        abort_if($row === null, 404);

        return view('cp.seo.edit', [
            'row' => $row,
            'title' => 'Редактирование seo',
        ]);
    }

    public function update(EditRequest $request): RedirectResponse
    {
        try {
            $this->seoRepository->updateWithMapping(
                (int) $request->id,
                ArrayData::from($request->validated()),
            );
        } catch (Exception $exception) {
            report($exception);

            return back()
                ->withInput()
                ->with('error', $exception->getMessage());
        }

        return redirect()
            ->route('admin.seo.index')
            ->with('success', 'Данные успешно обновлены');
    }
}