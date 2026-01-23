<?php

namespace App\Http\Controllers\Frontend;


use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Profile\UpdateCompanyRequest;
use App\Http\Requests\Frontend\Profile\UpdateProfileRequest;
use App\Models\Complaints;
use App\Models\Invites;
use App\Models\Seo;
use App\Repositories\CompanyRepository;
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
        private CustomerRepository $customerRepository,
        private OrdersRepository $ordersRepository,
        private RequestsRepository $requestsRepository)
    {
        $this->middleware('auth:customer');
    }

    /**
     * Страница профиля
     *
     * @return View
     */
    public function index(): View
    {
        $seo = Seo::getSeo('frontend.profile', 'Личный кабинет');
        $title = $seo['title'];
        $meta_description = $seo['meta_description'];
        $meta_keywords = $seo['meta_keywords'];
        $meta_title = $seo['meta_title'];
        $seo_url_canonical = $seo['seo_url_canonical'];
        $h1 = $seo['h1'];

        $options = Invites::getPlatformList();

        $customerId = (int) Auth::guard('customer')->id();
        $orders =  $this->ordersRepository->paginateByCustomer($customerId);
        $requests =  $this->requestsRepository->paginateByCustomer($customerId);

        $complaints = $this->customerRepository->getComplaintsForCustomer($customerId);
        $complaintProducts = $this->customerRepository->getComplaintOrderProducts($customerId);
        $complaintTypes = Complaints::$type_name;

        return view('frontend.profile.index', compact(
                'meta_description',
                'meta_keywords',
                'meta_title',
                'options',
                'orders',
                'requests',
                'complaints',
                'complaintProducts',
                'complaintTypes',
                'h1',
                'seo_url_canonical',
                'title'
            )
        )->with('title', $title);
    }

    /**
     * Обновление общей информации
     *
     * @param UpdateProfileRequest $request
     * @return JsonResponse
     */
    public function updateGeneralInfo(UpdateProfileRequest $request): JsonResponse
    {
        $customer = Auth::guard('customer')->user();
        $customerId = (int) $customer->id;

        $this->customerRepository->update($customerId, $request->validated());

        return response()->json([
            'message' => 'Изменения успешно сохранены',
            'success' => 'Изменения успешно сохранены',
            'data' => [
                'id' => $customerId,
                'phone' => $customer->phone,
                'name' => $customer->name,
            ],
        ]);
    }

    /**
     * Обновление информации о компании
     *
     * @param UpdateCompanyRequest $request
     * @param CompanyRepository $companyRepository
     * @return JsonResponse
     */
    public function updateCompanyInfo(UpdateCompanyRequest $request, CompanyRepository $companyRepository): JsonResponse
    {
        $customerId = (int) Auth::guard('customer')->id();

        $company = $companyRepository->updateByCustomer($customerId, $request->validated());

        return response()->json([
            'success' => true,
            'data' => $company?->only(['name', 'inn', 'contact_person', 'phone', 'email']),
        ]);
    }

    /**
     * Получаем список заказов
     *
     * @return JsonResponse
     */
    public function orders(): JsonResponse
    {
        $customerId = (int) Auth::guard('customer')->id();
        $orders =  $this->ordersRepository->paginateByCustomer($customerId);

        return response()->json([
            'html' => view('frontend.profile.partials.orders-rows', [
                'orders' => $orders->items(),
            ])->render(),
            'hasMore' => $orders->hasMorePages(),
            'nextPage' => $orders->currentPage() + 1,
        ]);
    }

    /**
     * Получаем список запросов
     *
     * @return JsonResponse
     */
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

    /**
     * Разлогиниваемся
     *
     * @return RedirectResponse
     */
    public function logout(): RedirectResponse
    {
        Auth::guard('customer')->logout();;

        return redirect()->route('frontend.index');
    }
}
