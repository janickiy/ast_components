<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Products extends Model
{
    protected $table = 'products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'n_number',
        'article',
        'catalog_id',
        'manufacturer_id',
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
        'image_title',
        'image_alt',
        'under_order',
        'in_stock'
    ];

    /**
     * @param $query
     * @return mixed
     */
    public function scopeInStock($query)
    {
        return $query->where('in_stock', 1);
    }

    /**
     * @return string
     */
    public function getInStockAttribute(): string
    {
        return $this->attributes['in_stock'] ? 'В наличии' : 'Нет в наличии';
    }

    /**
     * @return mixed
     */
    public function getStatusAttribute()
    {
        return $this->attributes['in_stock'];
    }

    /**
     * @return BelongsTo
     */
    public function catalog(): BelongsTo
    {
        return $this->belongsTo(Catalog::class, 'catalog_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function manufacturer(): BelongsTo
    {
        return $this->belongsTo(Manufacturers::class , 'manufacturer_id', 'id');
    }

    /**
     * @return string
     */
    public function getThumbnailUrl(): string
    {
        if (Storage::disk('public')->exists('products/' . $this->thumbnail) === true) {
            return Storage::disk('public')->url('products/' . $this->thumbnail);
        } else {
            return asset('/images/no_image.jpg');
        }
    }

    /**
     * @return string
     */
    public function getOriginUrl(): string
    {
        if (Storage::disk('public')->exists('products/' . $this->origin) === true) {
            return Storage::disk('public')->url('products/' . $this->origin);
        } else {
            return asset('/images/no_image.jpg');
        }
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