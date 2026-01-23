<?php

namespace App\Http\Controllers\Frontend;


use App\Http\Controllers\Controller;
use App\Models\Products;
use App\Services\CartService;
use App\Http\Requests\Frontend\Cart\AddRequest;
use App\Http\Requests\Frontend\Cart\RemoveRequest;
use App\Http\Requests\Frontend\Cart\ToggleRequest;
use App\Http\Requests\Frontend\Cart\CheckoutRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;

class CartController extends Controller
{
    public function __construct(private readonly CartService $cart)
    {
    }

    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
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
            $product = $products->get((int)$productId);
            if (!$product) {
                continue;
            }

            $qty = (int)($item['qty'] ?? 0);
            $pendingUntil = $item['pending_remove_until'] ?? null;

            $isSelected = !empty($selected[$productId]);

            $price = (float)($product->price ?? 0);
            $rowTotal = $price * $qty;

            if (empty($pendingUntil)) {
                $total += $rowTotal;

                // считаем товары в заказе (выбранные позиции)
                if ($isSelected) {
                    $selectedCount += $qty; // если нужно "кол-во", а не "кол-во позиций"
                    // если нужно "кол-во позиций", то: $selectedCount += 1;
                }
            }

            $cartRows[] = [
                'product' => $product,
                'qty' => $qty,
                'selected' => !empty($selected[$productId]),
                'pending_remove_until' => $pendingUntil,
                'row_total' => $rowTotal,
            ];
        }

        $isAuth = auth()->guard('customer')->check();

        if (count($cartRows) === 0) {
            return view(auth()->guard('customer')->check()
                ? 'frontend.cart.cart-empty-auth'
                : 'frontend.cart.cart-empty-no-auth',
            );
        }

        return view($isAuth ? 'frontend.cart.cart-auth' : 'frontend.cart.cart-no-auth', [
            'cartRows' => $cartRows,
            'total' => $total,
            'selectedCount' => $selectedCount,
            'selectAllChecked' => $this->isSelectAllChecked($cartRows),
        ]);
    }

    /**
     * @param AddRequest $request
     * @return JsonResponse
     */
    public function add(AddRequest $request): JsonResponse
    {
        $this->cart->add((int)$request->product_id, (int)($request->qty ?? 1));

        return response()->json([
            'ok' => true,
            'cart_count' => $this->cart->totalQty(),
        ]);
    }

    /**
     * @param AddRequest $request
     * @return JsonResponse
     */
    public function setQty(AddRequest $request): JsonResponse
    {
        $cart = $this->cart->setQty((int)$request->product_id, (int)$request->qty);
        $pending = $cart['items'][(int)$request->product_id]['pending_remove_until'] ?? null;

        return response()->json([
            'ok' => true,
            'cart_count' => $this->cart->totalQty(),
            'pending_remove_until' => $pending,
        ]);
    }

    /**
     * @param RemoveRequest $request
     * @return JsonResponse
     */
    public function remove(RemoveRequest $request): JsonResponse
    {
        $cart = $this->cart->startRemove((int)$request->product_id);
        $pending = $cart['items'][(int)$request->product_id]['pending_remove_until'] ?? null;

        return response()->json([
            'ok' => true,
            'pending_remove_until' => $pending,
        ]);
    }

    /**
     * @param RemoveRequest $request
     * @return JsonResponse
     */
    public function undoRemove(RemoveRequest $request): JsonResponse
    {
        $this->cart->undoRemove((int)$request->product_id);

        return response()->json([
            'ok' => true,
            'cart_count' => $this->cart->totalQty(),
        ]);
    }

    /**
     * @param ToggleRequest $request
     * @return JsonResponse
     */
    public function toggle(ToggleRequest $request): JsonResponse
    {
        $selected = filter_var($request->selected, FILTER_VALIDATE_BOOL);
        $this->cart->toggleSelected((int)$request->product_id, $selected);

        return response()->json(['ok' => true]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function selectAll(Request $request): JsonResponse
    {
        $data = $request->validate([
            'selected' => ['required'],
        ]);

        $selected = filter_var($data['selected'], FILTER_VALIDATE_BOOL);
        $this->cart->selectAll($selected);

        return response()->json(['ok' => true]);
    }

    /**
     * @param CheckoutRequest $request
     * @return JsonResponse
     */
    public function checkout(CheckoutRequest $request): JsonResponse
    {
        if (!auth()->guard('customer')->check()) {
            return response()->json([
                'ok' => false,
                'redirect' => route('frontend.profile.index'),
            ], 401);
        }

        $customerId = auth()->guard('customer')->id();
        $order = $this->cart->checkout($customerId, $request->delivery_date ?? null);

        return response()->json([
            'ok' => (bool)$order,
            'order_id' => $order?->id,
            'cart_count' => $this->cart->totalQty(),
        ]);
    }

    /**
     * @param array $cartRows
     * @return bool
     */
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
