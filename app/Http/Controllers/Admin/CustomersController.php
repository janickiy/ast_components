<?php

namespace App\Http\Controllers\Admin;


use App\Repositories\CustomerRepository;
use App\Http\Requests\Admin\Customers\EditRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomersController
{
    /**extends Controller
     * @var CustomerRepository
     */
    private CustomerRepository $customerRepository;

    /**
     * @param CustomerRepository $customerRepository
     */
    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
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
        $this->customerRepository->update($request->id, $request->all());

        return redirect()->route('cp.customers.index')->with('success', 'Данные успешно обновлены!');
    }
}
