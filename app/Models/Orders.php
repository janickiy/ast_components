<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Orders extends Model
{
    protected $table = 'orders';

    public const STATUS_CREATED = 0;

    public const STATUS_IN_PROGRESS = 1;

    public const STATUS_COMPLETED = 2;

    public const STATUS_PAID = 3;

    public const STATUS_READY = 4;

    public const STATUS_GRANTED = 5;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'status',
        'customer_id',
        'delivery_date',
        'invoice',
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
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customers::class, 'customer_id', 'id');
    }

    /**
     * @return float
     */
    public function sum(): float
    {
        return OrderProduct::selectRaw('SUM(price * count) as sum')->where('order_id', $this->id)->first()->sum;
    }

    /**
     * @return string
     */
    public function dateFormat(): string
    {
        return Carbon::parse($this->created_at)->format('d.m.Y');
    }

    /**
     * @return string
     */
    public function deliveryDateFormat(): string
    {
        return Carbon::parse($this->delivery_date)->format('d.m.Y');
    }

    /**
     * @return string
     */
    public function getInvoice(): string
    {
        return Storage::disk('public')->url('invoices/' . $this->invoice);
    }

    /**
     * @return array
     */
    public static function getOption(): array
    {
        return [
            self::STATUS_CREATED => 'Создан',
            self::STATUS_IN_PROGRESS => 'В работе',
            self::STATUS_COMPLETED => 'Оформлен',
            self::STATUS_PAID => 'Оплачен',
            self::STATUS_READY => 'Готов к выдаче',
            self::STATUS_GRANTED => 'Выдан'
        ];
    }

}