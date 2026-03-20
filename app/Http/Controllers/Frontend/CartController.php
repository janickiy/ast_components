<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Cart\AddRequest;
use App\Http\Requests\Frontend\Cart\CheckoutRequest;
use App\Http\Requests\Frontend\Cart\RemoveRequest;
use App\Http\Requests\Frontend\Cart\ToggleRequest;
use App\Models\Products;
use App\Services\CartService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class CartController extends Controller
{
    public function __construct(
        private readonly CartService $cart,
    ) {
    }

    public function index(): View
    {
        $items = $this->cart->items();
        $selected = $this->cart->selectedMap();
        $productIds = array_keys($items);

        $products = Products::query()
            ->whereIn('id', $productIds)
            ->get()
            ->keyBy('id');

        $cartRows = [];
        $total = 0;
        $selectedCount = 0;

        foreach ($items as $productId => $item) {
            $product = $products->get((int) $productId);

            if ($product === null) {
                continue;
            }

            $qty = (int) ($item['qty'] ?? 0);
            $pendingUntil = $item['pending_remove_until'] ?? null;
            $isSelected = !empty($selected[$productId]);
            $price = (float) ($product->price ?? 0);
            $rowTotal = $price * $qty;

            if (empty($pendingUntil)) {
                $total += $rowTotal;

                if ($isSelected) {
                    $selectedCount += $qty;
                }
            }

            $cartRows[] = [
                'product' => $product,
                'qty' => $qty,
                'selected' => $isSelected,
                'pending_remove_until' => $pendingUntil,
                'row_total' => $rowTotal,
            ];
        }

        $customerGuard = auth()->guard('customer');
        $isAuth = $customerGuard->check();

        if ($cartRows === []) {
            return view($isAuth
                ? 'frontend.cart.cart-empty-auth'
                : 'frontend.cart.cart-empty-no-auth');
        }

        return view($isAuth ? 'frontend.cart.cart-auth' : 'frontend.cart.cart-no-auth', [
            'cartRows' => $cartRows,
            'total' => $total,
            'selectedCount' => $selectedCount,
            'selectAllChecked' => $this->isSelectAllChecked($cartRows),
        ]);
    }

    public function add(AddRequest $request): JsonResponse
    {
        $this->cart->add((int) $request->product_id, (int) ($request->qty ?? 1));

        return response()->json([
            'ok' => true,
            'cart_count' => $this->cart->totalQty(),
        ]);
    }

    public function setQty(AddRequest $request): JsonResponse
    {
        $cart = $this->cart->setQty((int) $request->product_id, (int) $request->qty);
        $pending = $cart['items'][(int) $request->product_id]['pending_remove_until'] ?? null;

        return response()->json([
            'ok' => true,
            'cart_count' => $this->cart->totalQty(),
            'pending_remove_until' => $pending,
        ]);
    }

    public function remove(RemoveRequest $request): JsonResponse
    {
        $cart = $this->cart->startRemove((int) $request->product_id);
        $pending = $cart['items'][(int) $request->product_id]['pending_remove_until'] ?? null;

        return response()->json([
            'ok' => true,
            'pending_remove_until' => $pending,
        ]);
    }

    public function undoRemove(RemoveRequest $request): JsonResponse
    {
        $this->cart->undoRemove((int) $request->product_id);

        return response()->json([
            'ok' => true,
            'cart_count' => $this->cart->totalQty(),
        ]);
    }

    public function toggle(ToggleRequest $request): JsonResponse
    {
        $this->cart->toggleSelected(
            (int) $request->product_id,
            $request->boolean('selected'),
        );

        return response()->json([
            'ok' => true,
        ]);
    }

    public function selectAll(ToggleRequest $request): JsonResponse
    {
        $this->cart->selectAll($request->boolean('selected'));

        return response()->json([
            'ok' => true,
        ]);
    }

    public function checkout(CheckoutRequest $request): JsonResponse
    {
        $customerGuard = auth()->guard('customer');

        if (!$customerGuard->check()) {
            return response()->json([
                'ok' => false,
                'redirect' => route('frontend.profile.index'),
            ], 401);
        }

        $order = $this->cart->checkout(
            $customerGuard->id(),
            $request->delivery_date ?? null,
        );

        return response()->json([
            'ok' => (bool) $order,
            'order_id' => $order?->id,
            'cart_count' => $this->cart->totalQty(),
        ]);
    }

    private function isSelectAllChecked(array $cartRows): bool
    {
        foreach ($cartRows as $row) {
            if (!empty($row['pending_remove_until'])) {
                continue;
            }

            if (empty($row['selected'])) {
                return false;
            }
        }

        return true;
    }
}