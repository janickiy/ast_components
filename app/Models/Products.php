<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Products extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'title',
        'description',
        'n_number',
        'article',
        'catalog_id',
        'price',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'slug',
        'seo_h1',
        'seo_url_canonical',
        'seo_sitemap',
        'thumbnail',
        'origin',
        'published',
        'image_title',
        'image_alt',
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
     * @return BelongsTo
     */
    public function catalog(): BelongsTo
    {
        return $this->belongsTo(Catalog::class, 'catalog_id', 'id');
    }

    /**
     * @return string
     */
    public function getThumbnailUrl(): string
    {
        return Storage::disk('public')->url('products/' . $this->thumbnail);
    }

    /**
     * @return string
     */
    public function getOriginUrl(): string
    {
        return Storage::disk('public')->url('products/' . $this->origin);
    }

    /**
     * @param int $category_id
     * @return HasMany
     */
    public function parameterByCategoryId(int $category_id): HasMany
    {
        return ProductParameters::where('product_id', $this->id)->where('category_id', $category_id)->orderBy('name')->get();
    }

    /**
     * @param array $productIds
     * @return mixed
     */
    public static function productsListByIds(array $productIds)
    {
        return self::whereIn('id', $productIds)->orderBy('title')->get();
    }

    /**
     * @return HasMany
     */
    public function parameters(): HasMany
    {
        return $this->hasMany(ProductParameters::class, 'product_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function documents(): HasMany
    {
        return $this->hasMany(ProductDocuments::class, 'product_id', 'id');
    }

    /**
     * @return void
     */
    public function scopeRemove(): void
    {
        if (Storage::disk('public')->exists('products/' . $this->thumbnail) === true) Storage::disk('public')->delete('products/' . $this->thumbnail);
        if (Storage::disk('public')->exists('products/' . $this->origin) === true) Storage::disk('public')->delete('products/' . $this->origin);

        $this->photos()->delete();

        foreach ($this->documents as $document) {
            if (Storage::disk('public')->exists('documents/' . $document->path) === true) Storage::disk('public')->delete('documents/' . $document->path);
        }

        $this->documents()->delete();
        $this->parameters()->delete();
        $this->delete();
    }

    /**
     * @return array
     */
    public static function getOption(): array
    {
        return self::orderBy('title')->get()->pluck('title', 'id')->toArray();
    }
}