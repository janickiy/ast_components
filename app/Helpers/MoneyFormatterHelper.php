<?php

namespace App\Helpers;

class MoneyFormatterHelper
{
    /**
     * Формат суммы с валютой
     * Пример: 1 250 000 ₽
     */
    public static function format(
        int|float $amount,
        string    $currency = '₽'
    ): string
    {
        return self::formatPlain($amount) . ' ' . $currency;
    }

    /**
     * Формат суммы без валюты
     * Пример: 1 250 000
     */
    public static function formatPlain(int|float $amount): string
    {
        return number_format((float)$amount, 0, '.', ' ');
    }
}
