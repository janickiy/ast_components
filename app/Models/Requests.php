<?php

namespace App\Models;

use App\Enums\RequestStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Requests extends Model
{
    protected $table = 'requests';

    protected $fillable = [
        'name',
        'company',
        'phone',
        'email',
        'message',
        'nomenclature',
        'count',
        'unit',
        'ip',
        'status',
        'customer_id',
        'attach',
    ];

    /**
     * @return BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customers::class, 'customer_id', 'id');
    }

    /**
     * @return string
     */
    public function getAttach(): string
    {
        return Storage::disk('public')->url('requests/' . $this->attach);
    }

    public function getStatus()
    {
        return RequestStatus::tryFrom($this->status);
    }

    public static function getOption(): array
    {
        return [
            RequestStatus::Created->value    => RequestStatus::Created->label(),
            RequestStatus::InProgress->value => RequestStatus::InProgress->label(),
            RequestStatus::Done->value       => RequestStatus::Done->label(),
        ];
    }

}