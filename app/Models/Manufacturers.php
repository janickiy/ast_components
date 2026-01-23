<?php

namespace App\Models;

use App\Traits\StaticTableName;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Manufacturers extends Model
{
    use StaticTableName;

    protected $table = 'manufacturers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'country',
        'image',
        'slug',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'seo_h1',
        'seo_url_canonical',
        'seo_sitemap',
        'published',
    ];

    /**
     * @param $query
     * @return mixed
     */
    public function scopePublished($query)
    {
        return $query->where('published', 1);
    }

    /**
     * @return string
     */
    public function getPublishedAttribute(): string
    {
        return $this->attributes['published'] ? 'публикован' : 'не опубликован';
    }

    /**
     * @return mixed
     */
    public function getStatusAttribute()
    {
        return $this->attributes['published'];
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        if (Storage::disk('public')->exists($this->table . '/' . $this->image) === true) {
            return Storage::disk('public')->url($this->table . '/' . $this->image);
        } else {
            return asset('/images/no_image.jpg');
        }
    }

    /**
     * @return BelongsTo
     */
    public function products(): BelongsTo
    {
        return $this->belongsTo(Products::class);
    }

    /**
     * @return void
     */
    public function scopeRemove(): void
    {
        if (Storage::disk('public')->exists($this->table . '/' . $this->image) === true) Storage::disk('public')->delete($this->table . '/' . $this->image);

        $this->delete();
    }
}