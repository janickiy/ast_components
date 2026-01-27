<?php

namespace App\Http\Controllers\Frontend;

use App\DTO\RequestsCreateData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\NomenclatureRequest\AddRequest;
use App\Models\Customers;
use App\Models\Seo;
use App\Repositories\RequestsRepository;
use App\Services\RequestsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Exception;

class RequestsController extends Controller
{
    public function __construct(
        private RequestsRepository $requestsRepository,
        private RequestsService $requestsService)
    {
    }

    /**
     * Запрос номенклатуры
     *
     * @return View
     */
    public function index(): View
    {
        $seo = Seo::getSeo('frontend.nomenclature_request', 'Запрос номенклатуры');
        $title = $seo['title'];
        $meta_description = $seo['meta_description'];
        $meta_keywords = $seo['meta_keywords'];
        $meta_title = $seo['meta_title'];
        $seo_url_canonical = $seo['seo_url_canonical'];
        $h1 = $seo['h1'];

        return view('frontend.nomenclature_request.index', compact(
                'meta_description',
                'meta_keywords',
                'meta_title',
                'h1',
                'seo_url_canonical',
            )
        )->with('title', $title);
    }

    /**
     * Добавляем запрос на номенклатуру
     *
     * @param AddRequest $request
     * @return RedirectResponse
     */
    public function add(AddRequest $request): RedirectResponse
    {
        /** @var Customers $customer */
        $customer = Auth::guard('customer')->user();

        try {
            if ($request->hasFile('attach')) {
                $attach = $this->requestsService->storeFile($request);
            }

            $this->requestsService->notify($request);

            $this->requestsRepository->add(new RequestsCreateData(
                name: $request->input('name'),
                company: $request->input('company'),
                email: $request->input('email'),
                phone: $request->input('phone'),
                message: $request->input('message'),
                nomenclature: $request->input('nomenclature'),
                count: (int)$request->input('count'),
                unit: (int)$request->input('unit', 0),
                attach: $attach ?? null,
                ip: $request->ip(),
                customerId: $customer?->id ?? null,
            ));
        } catch (Exception $e) {
            report($e);

            return redirect()
                ->back()
                ->with('error', 'Не удалось создать запрос номенклатуры. Попробуйте позже.')
                ->withInput();
        }

        return redirect()
            ->back()
            ->with('success', 'Запрос номенклатуры успешно создана.');
    }
}