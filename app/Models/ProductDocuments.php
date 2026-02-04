<?php

namespace App\Models;


use App\Http\Traits\File;
use App\Helpers\StringHelper;
use App\Http\Traits\StaticTableName;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class ProductDocuments extends Model
{
    use StaticTableName, File;

    protected $table = 'product_documents';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
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
        self::deleteFile($this->file, $this->table);

        $this->delete();
    }

    /**
     * @return string
     */
    public function getDocumentInfo(): string
    {
        $key = md5($this->table . '/' . $this->file);

        if (Cache::has($key)) {
            return Cache::get($key);
        } else {
            if (Storage::disk('public')->exists($this->table . '/' . $this->file) === true) {
                $file = Storage::disk('public')->path($this->table . '/' . $this->file);

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