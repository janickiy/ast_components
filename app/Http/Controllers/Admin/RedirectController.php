<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\DTO\ArrayData;
use App\Http\Requests\Admin\Redirect\DeleteRequest;
use App\Http\Requests\Admin\Redirect\EditRequest;
use App\Http\Requests\Admin\Redirect\StoreRequest;
use App\Repositories\RedirectRepository;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RedirectController extends Controller
{
    public function __construct(
        private readonly RedirectRepository $redirectRepository,
    ) {
        parent::__construct();
    }

    public function index(): View
    {
        return view('cp.redirect.index', [
            'title' => 'Редиректы',
        ]);
    }

    public function create(): View
    {
        return view('cp.redirect.create_edit', [
            'title' => 'Добавление редиректа',
        ]);
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        try {
            $this->redirectRepository->create(
                ArrayData::from($request->validated()),
            );
        } catch (Exception $exception) {
            report($exception);

            return back()
                ->withInput()
                ->with('error', $exception->getMessage());
        }

        return redirect()
            ->route('admin.redirect.index')
            ->with('success', 'Информация успешно добавлена');
    }

    public function edit(int $id): View
    {
        $row = $this->redirectRepository->find($id);

        abort_if($row === null, 404);

        return view('cp.redirect.create_edit', [
            'row' => $row,
            'title' => 'Редактирование редиректа',
        ]);
    }

    public function update(EditRequest $request): RedirectResponse
    {
        try {
            $this->redirectRepository->updateWithMapping(
                $request->id,
                ArrayData::from($request->validated()),
            );
        } catch (Exception $exception) {
            report($exception);

            return back()
                ->withInput()
                ->with('error', $exception->getMessage());
        }

        return redirect()
            ->route('admin.redirect.index')
            ->with('success', 'Данные успешно обновлены');
    }

    public function destroy(DeleteRequest $request): void
    {
        $this->redirectRepository->delete($request->id);
    }
}