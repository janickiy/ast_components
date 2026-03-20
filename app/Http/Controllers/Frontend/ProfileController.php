<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\DTO\ArrayData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Profile\UpdateCompanyRequest;
use App\Http\Requests\Frontend\Profile\UpdateProfileRequest;
use App\Models\Complaints;
use App\Models\Invites;
use App\Models\Seo;
use App\Repositories\CompanyRepository;
use App\Repositories\ComplaintsRepository;
use App\Repositories\CustomerRepository;
use App\Repositories\OrdersRepository;
use App\Repositories\RequestsRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function __construct(
        private readonly CustomerRepository $customerRepository,
        private readonly OrdersRepository $ordersRepository,
        private readonly RequestsRepository $requestsRepository,
        private readonly ComplaintsRepository $complaintsRepository,
    ) {
        $this->middleware('auth:customer');
    }

    public function index(): View
    {
        $seo = Seo::getSeo('frontend.profile', 'Личный кабинет');
        $customerId = (int) Auth::guard('customer')->id();

        return view('frontend.profile.index', [
            'meta_description' => $seo['meta_description'],
            'meta_keywords' => $seo['meta_keywords'],
            'meta_title' => $seo['meta_title'],
            'options' => Invites::getPlatformList(),
            'orders' => $this->ordersRepository->paginateByCustomer($customerId),
            'requests' => $this->requestsRepository->paginateByCustomer($customerId),
            'complaints' => $this->complaintsRepository->paginateByCustomer($customerId),
            'complaintProducts' => $this->customerRepository->getComplaintOrderProducts($customerId),
            'complaintTypes' => Complaints::$type_name,
            'h1' => $seo['h1'],
            'seo_url_canonical' => $seo['seo_url_canonical'],
            'title' => $seo['title'],
        ]);
    }

    public function updateGeneralInfo(UpdateProfileRequest $request): JsonResponse
    {
        $customer = Auth::guard('customer')->user();
        $customerId = (int) $customer->id;

        $this->customerRepository->update(
            $customerId,
            ArrayData::from($request->validated()),
        );

        $freshCustomer = $this->customerRepository->find($customerId);

        return response()->json([
            'message' => 'Изменения успешно сохранены',
            'success' => 'Изменения успешно сохранены',
            'data' => [
                'id' => $customerId,
                'phone' => $freshCustomer?->phone,
                'name' => $freshCustomer?->name,
            ],
        ]);
    }

    public function updateCompanyInfo(
        UpdateCompanyRequest $request,
        CompanyRepository $companyRepository,
    ): JsonResponse {
        $customerId = (int) Auth::guard('customer')->id();

        $company = $companyRepository->updateByCustomer(
            $customerId,
            ArrayData::from($request->validated()),
        );

        return response()->json([
            'success' => $company !== null,
            'data' => $company?->only(['name', 'inn', 'contact_person', 'phone', 'email']),
        ]);
    }

    public function orders(): JsonResponse
    {
        $customerId = (int) Auth::guard('customer')->id();
        $orders = $this->ordersRepository->paginateByCustomer($customerId);

        return response()->json([
            'html' => view('frontend.profile.partials.orders-rows', [
                'orders' => $orders->items(),
            ])->render(),
            'hasMore' => $orders->hasMorePages(),
            'nextPage' => $orders->currentPage() + 1,
        ]);
    }

    public function requests(): JsonResponse
    {
        $customerId = (int) Auth::guard('customer')->id();
        $requests = $this->requestsRepository->paginateByCustomer($customerId);

        return response()->json([
            'html' => view('frontend.profile.partials.requests-rows', [
                'requests' => $requests->items(),
            ])->render(),
            'hasMore' => $requests->hasMorePages(),
            'nextPage' => $requests->currentPage() + 1,
        ]);
    }

    public function complaints(): JsonResponse
    {
        $customerId = (int) Auth::guard('customer')->id();
        $complaints = $this->complaintsRepository->paginateByCustomer($customerId);

        return response()->json([
            'html' => view('frontend.profile.partials.complaints-rows', [
                'complaints' => $complaints->items(),
            ])->render(),
            'hasMore' => $complaints->hasMorePages(),
            'nextPage' => $complaints->currentPage() + 1,
        ]);
    }

    public function logout(): RedirectResponse
    {
        Auth::guard('customer')->logout();

        return redirect()->route('frontend.index');
    }
}