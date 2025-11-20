<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class ProductDocuments extends Model
{
    protected $table = 'product_documents';

    protected $fillable = [
        'file',
        'name',
        'product_id'
    ];

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Products::class, 'product_id', 'id');
    }

    /**
     * @return string
     */
    public function getDocument(): string
    {
        return Storage::disk('public')->url('documents/' . $this->file);
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function scopeRemove(): void
    {
        if (Storage::disk('public')->exists('documents/' . $this->file) === true) Storage::disk('public')->delete('documents/' . $this->file);

        $this->delete();
    }
}