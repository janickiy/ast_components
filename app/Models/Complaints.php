<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Complaints extends Model
{
    protected $table = 'complaints';

    public const TYPE_DEFECTIVE = 0;

    public const TYPE_NON_DELIVERY = 1;

    public const TYPE_RETURN = 2;

    protected $fillable = [
        'type',
        'status',
        'order_count',
        'return_count',
        'order_id',
        'product_id'
    ];

    public static array $type_name = [
        self::TYPE_DEFECTIVE => 'Брак',
        self::TYPE_NON_DELIVERY => 'Недопоставка',
        self::TYPE_RETURN => 'Возврат',
    ];

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Products::class, 'product_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Orders::class, 'order_id', 'id');
    }
}