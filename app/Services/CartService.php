<?php

namespace App\Services;

use App\Models\Orders;
use App\Models\Products;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CartService
{
    private const SESSION_KEY = 'cart';

    /**
     * @return array
     */
    private function cart(): array
    {
        return Session::get(self::SESSION_KEY, [
            'items' => [],
            'selected' => [],
        ]);
    }

    /**
     * @param array $cart
     * @return void
     */
    private function save(array $cart): void
    {
        Session::put(self::SESSION_KEY, $cart);
    }

    public function cleanupExpiredPendingRemovals(): void
    {
        $cart = $this->cart();
        $now = time();

        foreach ($cart['items'] as $productId => $item) {
            $until = $item['pending_remove_until'] ?? null;
            if ($until !== null && $until <= $now) {
                unset($cart['items'][$productId], $cart['selected'][$productId]);
            }
        }

        $this->save($cart);
    }

    public function items(): array
    {
        $this->cleanupExpiredPendingRemovals();
        return $this->cart()['items'];
    }

    public function selectedMap(): array
    {
        $this->cleanupExpiredPendingRemovals();
        return $this->cart()['selected'];
    }

    public function totalQty(): int
    {
        $this->cleanupExpiredPendingRemovals();
        $cart = $this->cart();

        $sum = 0;
        foreach ($cart['items'] as $item) {
            if (!empty($item['pending_remove_until'])) {
                continue;
            }
            $sum += (int)$item['qty'];
        }
        return $sum;
    }

    /**
     * @param int $productId
     * @param int $qty
     * @return array
     */
    public function add(int $productId, int $qty): array
    {
        $qty = max(0, $qty);
        $cart = $this->cart();

        if ($qty === 0) {
            // если добавили 0 — просто не добавляем
            $this->save($cart);
            return $cart;
        }

        $current = $cart['items'][$productId]['qty'] ?? 0;
        $cart['items'][$productId] = [
            'qty' => $current + $qty,
            'pending_remove_until' => null,
        ];

        // по умолчанию отмечаем товар выбранным для заказа
        $cart['selected'][$productId] = true;

        $this->save($cart);
        return $cart;
    }

    /**
     * @param int $productId
     * @param int $qty
     * @return array
     */
    public function setQty(int $productId, int $qty): array
    {
        $qty = (int)$qty;
        $cart = $this->cart();

        if ($qty <= 0) {
            // ВАЖНО: если qty=0 (например, из каталога) — удаляем сразу
            unset($cart['items'][$productId], $cart['selected'][$productId]);
            $this->save($cart);
            return $cart;
        }

        $cart['items'][$productId] = [
            'qty' => $qty,
            'pending_remove_until' => null,
        ];

        if (!array_key_exists($productId, $cart['selected'])) {
            $cart['selected'][$productId] = true;
        }

        $this->save($cart);
        return $cart;
    }

    /**
     * @param int $productId
     * @return array
     */
    public function startRemove(int $productId): array
    {
        $cart = $this->cart();
        if (isset($cart['items'][$productId])) {
            $cart['items'][$productId]['pending_remove_until'] = time() + 5;
        }
        $this->save($cart);
        return $cart;
    }

    /**
     * @param int $productId
     * @return array
     */
    public function undoRemove(int $productId): array
    {
        $cart = $this->cart();
        if (isset($cart['items'][$productId])) {
            $cart['items'][$productId]['pending_remove_until'] = null;
            if (!array_key_exists($productId, $cart['selected'])) {
                $cart['selected'][$productId] = true;
            }
        }
        $this->save($cart);
        return $cart;
    }

    /**
     * @param int $productId
     * @param bool $selected
     * @return array
     */
    public function toggleSelected(int $productId, bool $selected): array
    {
        $cart = $this->cart();
        if (isset($cart['items'][$productId])) {
            $cart['selected'][$productId] = $selected;
        }
        $this->save($cart);
        return $cart;
    }

    /**
     * @param bool $selected
     * @return array
     */
    public function selectAll(bool $selected): array
    {
        $cart = $this->cart();
        foreach ($cart['items'] as $productId => $item) {
            if (!empty($item['pending_remove_until'])) {
                continue;
            }
            $cart['selected'][$productId] = $selected;
        }
        $this->save($cart);
        return $cart;
    }

    /**
     * Создаёт заказ из выбранных позиций.
     * Возвращает Order|null (если ничего не выбрано).
     */
    public function checkout(int $customerId, ?string $deliveryDate = null): ?Orders
    {
        $this->cleanupExpiredPendingRemovals();

        $cart = $this->cart();
        $selectedIds = [];
        foreach ($cart['items'] as $productId => $item) {
            if (!empty($item['pending_remove_until'])) {
                continue;
            }
            if (!empty($cart['selected'][$productId])) {
                $selectedIds[] = (int)$productId;
            }
        }

        if (count($selectedIds) === 0) {
            return null;
        }

        $products = Products::query()
            ->whereIn('id', $selectedIds)
            ->get()
            ->keyBy('id');

        return DB::transaction(function () use ($customerId, $deliveryDate, $cart, $selectedIds, $products) {
            $order = new Orders();
            $order->status = 0; // “новый” (если у тебя другая система статусов — поменяешь)
            $order->customer_id = $customerId;
            $order->delivery_date = $deliveryDate ? Carbon::parse($deliveryDate)->toDateString() : null;
            $order->invoice = null;
            $order->save();

            foreach ($selectedIds as $productId) {
                $item = $cart['items'][$productId] ?? null;
                if (!$item) continue;

                $product = $products->get($productId);
                if (!$product) continue;

                $qty = (int)$item['qty'];

                // product_info — можно строкой или JSON (я рекомендую JSON)
                $info = $product->title;

                DB::table('order_product')->insert([
                    'product_info' => $info,
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'count' => $qty,
                    'price' => $product->price, // снимок цены на момент заказа
                ]);

                // удалить выбранные из корзины (остальные остаются)
                unset($cart['items'][$productId], $cart['selected'][$productId]);
            }

            $this->save($cart);

            return $order;
        });
    }
}
