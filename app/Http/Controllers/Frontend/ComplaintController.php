<?php

namespace App\Http\Controllers\Frontend;

use App\Contracts\Complaints\ComplaintServiceInterface;
use App\DTO\Complaints\ComplaintCreateData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Complaints\StoreComplaintRequest;
use App\Models\Customers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Throwable;

class ComplaintController extends Controller
{
    /**
     * @param ComplaintServiceInterface $complaintService
     */
    public function __construct(private readonly ComplaintServiceInterface $complaintService)
    {
        $this->middleware('auth:customer');
    }

    /**
     * @param StoreComplaintRequest $request
     * @return RedirectResponse
     */
    public function store(StoreComplaintRequest $request): RedirectResponse
    {
        /** @var Customers $customer */
        $customer = Auth::guard('customer')->user();

        try {
            $this->complaintService->create(new ComplaintCreateData(
                type: (int) $request->input('type'),
                orderId: (int) $request->input('order_id'),
                productId: (int) $request->input('product_id'),
                returnCount: (int) $request->input('return_count'),
                customerId: (int) $customer->id,
            ));
        } catch (Throwable $exception) {
            report($exception);

            return redirect()
                ->back()
                ->withErrors(['complaint' => 'Не удалось создать претензию. Попробуйте позже.'])
                ->withInput();
        }

        return redirect()
            ->route('frontend.profile.index', ['tab' => 'account-claims'])
            ->with('success', 'Претензия успешно создана.');
    }
}
