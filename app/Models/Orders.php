<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Http\Traits\StaticTableName;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Orders extends Model
{
    use StaticTableName;

    protected $table = 'orders';

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
        'customer',
        'email',
        'phone',
        'delivery_info',
        'comment',
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
        return OrderProduct::selectRaw('SUM(price * count) as sum')->where('order_id', $this->id)->first()?->sum ?? 0.00;
    }

    /**
     * @return string
     */
    public function dateFormat(): string
    {
        return Carbon::parse($this->created_at)->format('d.m.Y');
    }

    /**
     * @return string|null
     */
    public function deliveryDateFormat(): ?string
    {
        return $this->delivery_date ? Carbon::parse($this->delivery_date)->format('d.m.Y') : null;
    }

    /**
     * @return string
     */
    public function deliveryEditDateFormat(): string
    {
        return Carbon::parse($this->delivery_date)->format('d/m/Y');
    }

    /**
     * @return string|null
     */
    public function getInvoice(): ?string
    {
        return Storage::disk('public')->exists($this->table . '/' . $this->invoice) === true ? Storage::disk('public')->url($this->table . '/' . $this->invoice) : null;
    }

    /**
     * @return array
     */
    public static function getOption(): array
    {
        return [
            OrderStatus::Created->value    => OrderStatus::Created->label(),
            OrderStatus::InProgress->value => OrderStatus::InProgress->label(),
            OrderStatus::Issued->value     => OrderStatus::Issued->label() ,
            OrderStatus::Paid->value       => OrderStatus::Paid->label(),
            OrderStatus::Ready->value      => OrderStatus::Ready->label(),
            OrderStatus::Done->value       => OrderStatus::Done->label(),
        ];
    }

    public function getStatus()
    {
        return OrderStatus::tryFrom($this->status);
    }

    /**
     * Товары в заказе
     *
     * @return HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderProduct::class, 'order_id', 'id');
    }
}