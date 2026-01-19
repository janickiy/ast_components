<?php

namespace App\Http\Controllers\Frontend;


use App\Http\Controllers\Controller;
use App\Models\Products;
use App\Services\CartService;
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
     * @param Request $request
     * @return JsonResponse
     */
    public function add(Request $request): JsonResponse
    {
        $data = $request->validate([
            'product_id' => ['required', 'integer'],
            'qty' => ['nullable', 'integer'],
        ]);

        $this->cart->add((int)$data['product_id'], (int)($data['qty'] ?? 1));

        return response()->json([
            'ok' => true,
            'cart_count' => $this->cart->totalQty(),
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function setQty(Request $request): JsonResponse
    {
        $data = $request->validate([
            'product_id' => ['required', 'integer'],
            'qty' => ['required', 'integer'],
        ]);

        $cart = $this->cart->setQty((int)$data['product_id'], (int)$data['qty']);
        $pending = $cart['items'][(int)$data['product_id']]['pending_remove_until'] ?? null;

        return response()->json([
            'ok' => true,
            'cart_count' => $this->cart->totalQty(),
            'pending_remove_until' => $pending,
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function remove(Request $request): JsonResponse
    {
        $data = $request->validate([
            'product_id' => ['required', 'integer'],
        ]);

        $cart = $this->cart->startRemove((int)$data['product_id']);
        $pending = $cart['items'][(int)$data['product_id']]['pending_remove_until'] ?? null;

        return response()->json([
            'ok' => true,
            'pending_remove_until' => $pending,
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function undoRemove(Request $request): JsonResponse
    {
        $data = $request->validate([
            'product_id' => ['required', 'integer'],
        ]);

        $this->cart->undoRemove((int)$data['product_id']);

        return response()->json([
            'ok' => true,
            'cart_count' => $this->cart->totalQty(),
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function toggle(Request $request): JsonResponse
    {
        $data = $request->validate([
            'product_id' => ['required', 'integer'],
            'selected' => ['required'],
        ]);

        $selected = filter_var($data['selected'], FILTER_VALIDATE_BOOL);
        $this->cart->toggleSelected((int)$data['product_id'], $selected);

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
     * @param Request $request
     * @return JsonResponse
     */
    public function checkout(Request $request): JsonResponse
    {
        if (!auth()->guard('customer')->check()) {
            return response()->json([
                'ok' => false,
                'redirect' => route('frontend.profile.index'),
            ], 401);
        }

        $customerId = auth()->guard('customer')->id();

        $data = $request->validate([
            'delivery_date' => ['nullable', 'date'],
        ]);

        $order = $this->cart->checkout($customerId, $data['delivery_date'] ?? null);

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
