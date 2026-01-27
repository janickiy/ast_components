<?php

namespace App\Http\Filters;


use Kblais\QueryFilter\QueryFilter;

/**
 * Фильтр по каталогу
 */
class ProductFilter extends QueryFilter
{
    /**
     * Фильтр по наличию
     */
    public function inStock()
    {
        return $this->where(function ($q) {
             $q->where('in_stock', 1);
        });
    }

    /**
     * Фильтр под заказ
     */
    public function underOrder()
    {
        return $this->orwhere(function ($q) {
             $q->where('under_order', 1);
        });
    }

    /**
     * Поиск (если есть)
     *
     * @param string $value
     * @return ProductFilter
     */
    public function q(string $value)
    {
        return $this->where(function ($q) use ($value) {
            $q->where('title', 'LIKE', "%{$value}%");
            $q->orWhere('article', 'LIKE', "%{$value}%");
            $q->orWhere('n_number', 'LIKE', "%{$value}%");
        });
    }

}