<?php

namespace App\Models;

use App\Traits\StaticTableName;
use App\Enums\ComplaintStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Complaints extends Model
{
    use StaticTableName;

    protected $table = 'complaints';

    public const TYPE_DEFECTIVE = 0;
    public const TYPE_NON_DELIVERY = 1;
    public const TYPE_RETURN = 2;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type',
        'status',
        'order_count',
        'return_count',
        'order_id',
        'product_id',
        'customer_id',
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

    /**
     * @return BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customers::class, 'customer_id', 'id');
    }

    public function getStatus()
    {
        return ComplaintStatus::tryFrom($this->status);
    }

    public static function getOption(): array
    {
        return [
            ComplaintStatus::Created->value    => ComplaintStatus::Created->label(),
            ComplaintStatus::InProgress->value => ComplaintStatus::InProgress->label(),
            ComplaintStatus::Agreement->value  => ComplaintStatus::Agreement->label(),
            ComplaintStatus::Expertise->value  => ComplaintStatus::Expertise->label(),
            ComplaintStatus::Denied->value     => ComplaintStatus::Denied->label(),
            ComplaintStatus::Approved->value   => ComplaintStatus::Approved->label(),
            ComplaintStatus::Return->value     => ComplaintStatus::Return->label(),
            ComplaintStatus::Closed->value     => ComplaintStatus::Closed->label(),
            ComplaintStatus::Checked->value    => ComplaintStatus::Checked->label(),
        ];
    }

    public function scopeRemove(): void
    {
        if (Storage::disk('public')->exists($this->table . '/' . $this->blank) === true) Storage::disk('public')->delete($this->table . '/' . $this->blank);

        $this->delete();
    }
}