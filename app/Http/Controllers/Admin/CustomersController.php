<?php

namespace App\Http\Controllers\Admin;


use App\Repositories\CustomerRepository;
use App\Http\Requests\Admin\Customers\EditRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomersController extends Controller
{

    /**
     * @param CustomerRepository $customerRepository
     */
    public function __construct(private CustomerRepository $customerRepository)
    {
        parent::__construct();
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('cp.customers.index')->with('title', 'Пользователи');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $row = $this->customerRepository->find($id);

        if (!$row) abort(404);

        return view('cp.customers.edit', compact('row'))->with('title', 'Редактировать пользователя');
    }

    /**
     * @param EditRequest $request
     * @return RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        $this->customerRepository->updateWithMapping($request->id, $request->all());

        return redirect()->route('cp.customers.index')->with('success', 'Данные успешно обновлены!');
    }
}
