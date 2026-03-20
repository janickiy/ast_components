<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\DTO\ArrayData;
use App\Http\Requests\Admin\Requests\DeleteRequest;
use App\Http\Requests\Admin\Requests\EditRequest;
use App\Models\Requests;
use App\Repositories\RequestsRepository;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RequestsController extends Controller
{
    public function __construct(
        private readonly RequestsRepository $requestsRepository,
    ) {
        parent::__construct();
    }

    public function index(): View
    {
        return view('cp.requests.index', [
            'title' => 'Запросы номенклатуры',
        ]);
    }

    public function edit(int $id): View
    {
        $row = $this->requestsRepository->find($id);

        abort_if($row === null, 404);

        return view('cp.requests.edit', [
            'row' => $row,
            'options' => Requests::getOption(),
            'title' => 'Редактирование запроса номенклатуры: #' . $row->id,
        ]);
    }

    public function update(EditRequest $request): RedirectResponse
    {
        try {
            $this->requestsRepository->updateWithMapping(
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
            ->route('admin.requests.index')
            ->with('success', 'Данные успешно обновлены');
    }

    public function destroy(DeleteRequest $request): void
    {
        $this->requestsRepository->remove($request->id);
    }
}