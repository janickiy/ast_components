<?php

namespace App\Models;


use App\Helpers\StringHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

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

    /**
     * @return string
     */
    public function getDocumentInfo(): string
    {
        $key = md5('documents/' . $this->file);

        if (Cache::has($key)) {
            return Cache::get($key);
        } else {
            if (Storage::disk('public')->exists('documents/' . $this->file) === true) {
                $file = Storage::disk('public')->path('documents/' . $this->file);

                $size = StringHelper::humanFilesize(filesize($file));
                $ext = pathinfo($this->file, PATHINFO_EXTENSION);
                $info = $ext . ', ' . $size;
            } else {
                $info = '';
            }

            Cache::put($key, $info);

            return $info;
        }
    }
}