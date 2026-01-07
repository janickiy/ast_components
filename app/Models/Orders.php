<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Orders extends Model
{
    protected $table = 'orders';

    public const STATUS_CREATED = 0;

    public const STATUS_IN_PROGRESS = 1;

    public const STATUS_COMPLETED = 2;

    public const STATUS_PAID = 3;

    public const STATUS_READY = 4;

    public const STATUS_GRANTED = 5;

    protected $fillable = [
        'status',
        'client_id'
    ];

    public static array $status_name = [
        self::STATUS_CREATED => 'Создан',
        self::STATUS_IN_PROGRESS => 'В работе',
        self::STATUS_COMPLETED => 'Оформлен',
        self::STATUS_PAID => 'Оплачен',
        self::STATUS_READY => 'Готов к выдаче',
        self::STATUS_GRANTED => 'Выдан'
    ];

    /**
     * @return BelongsTo
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Clients::class, 'client_id', 'id');
    }
}