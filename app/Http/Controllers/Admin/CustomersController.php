<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\DTO\ArrayData;
use App\Http\Requests\Admin\Customers\EditRequest;
use App\Repositories\CustomerRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CustomersController extends Controller
{
    public function __construct(
        private readonly CustomerRepository $customerRepository,
    ) {
        parent::__construct();
    }

    public function index(): View
    {
        return view('cp.customers.index', [
            'title' => 'Пользователи',
        ]);
    }

    public function edit(int $id): View
    {
        $row = $this->customerRepository->find($id);

        abort_if($row === null, 404);

        return view('cp.customers.edit', [
            'row' => $row,
            'title' => 'Редактировать пользователя',
        ]);
    }

    public function update(EditRequest $request): RedirectResponse
    {
        $this->customerRepository->updateWithMapping(
            (int) $request->id,
            ArrayData::from($request->validated()),
        );

        return redirect()
            ->route('cp.customers.index')
            ->with('success', 'Данные успешно обновлены!');
    }
}