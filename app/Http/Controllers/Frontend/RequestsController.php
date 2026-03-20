<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\DTO\RequestsCreateData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\NomenclatureRequest\AddRequest;
use App\Models\Customers;
use App\Models\Seo;
use App\Repositories\RequestsRepository;
use App\Services\RequestsService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RequestsController extends Controller
{
    public function __construct(
        private readonly RequestsRepository $requestsRepository,
        private readonly RequestsService $requestsService,
    ) {
    }

    public function index(): View
    {
        $seo = Seo::getSeo('frontend.nomenclature_request', 'Запрос номенклатуры');

        return view('frontend.nomenclature_request.index', [
            'meta_description' => $seo['meta_description'],
            'meta_keywords' => $seo['meta_keywords'],
            'meta_title' => $seo['meta_title'],
            'h1' => $seo['h1'],
            'seo_url_canonical' => $seo['seo_url_canonical'],
            'title' => $seo['title'],
        ]);
    }

    public function add(AddRequest $request): RedirectResponse
    {
        /** @var Customers|null $customer */
        $customer = Auth::guard('customer')->user();

        try {
            $attach = null;

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
                count: (int) $request->input('count'),
                unit: (int) $request->input('unit', 0),
                attach: $attach,
                ip: $request->ip(),
                customerId: $customer?->id,
            ));
        } catch (Exception $exception) {
            report($exception);

            return back()
                ->withInput()
                ->with('error', 'Не удалось создать запрос номенклатуры. Попробуйте позже.');
        }

        return back()
            ->with('success', 'Запрос номенклатуры успешно создан.');
    }
}