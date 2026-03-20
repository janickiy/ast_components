<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\DTO\ComplaintCreateData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Complaints\StoreRequest;
use App\Models\Customers;
use App\Repositories\ComplaintsRepository;
use App\Services\ComplaintService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Throwable;

class ComplaintController extends Controller
{
    public function __construct(
        private readonly ComplaintsRepository $complaintsRepository,
        private readonly ComplaintService $complaintService,
    ) {
        $this->middleware('auth:customer');
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        /** @var Customers $customer */
        $customer = Auth::guard('customer')->user();

        try {
            $blank = null;

            if ($request->hasFile('blank')) {
                $blank = $this->complaintService->storeBlank($request);
            }

            $this->complaintsRepository->add(new ComplaintCreateData(
                type: (int) $request->input('type'),
                orderId: (int) $request->input('order_id'),
                productId: (int) $request->input('product_id'),
                returnCount: (int) $request->input('return_count'),
                customerId: (int) $customer->id,
                blank: $blank,
            ));
        } catch (Throwable $exception) {
            report($exception);

            return back()
                ->withInput()
                ->with('complaint', 'Не удалось создать претензию. Попробуйте позже.');
        }

        return redirect()
            ->route('frontend.profile.index', ['tab' => 'account-claims'])
            ->with('success', 'Претензия успешно создана.');
    }
}