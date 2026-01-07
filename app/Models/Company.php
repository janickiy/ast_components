<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Company extends Model
{
    protected $table = 'company';

    protected $fillable = [
        'name',
        'inn',
        'contact_person',
        'phone',
        'email',
        'client_id'
    ];

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Clients::class, 'client_id', 'id');
    }
}