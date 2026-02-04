<?php

namespace App\Models;

use App\Http\Traits\File;
use App\Http\Traits\StaticTableName;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Kblais\QueryFilter\Filterable;

class Products extends Model
{
    use StaticTableName, Filterable, File;

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
        return $this->belongsTo(Manufacturers::class, 'manufacturer_id', 'id');
    }

    /**
     * @return string
     */
    public function getThumbnailUrl(): string
    {
        if (Storage::disk('public')->exists($this->table . '/' . $this->thumbnail) === true) {
            return Storage::disk('public')->url($this->table . '/' . $this->thumbnail);
        } else {
            return asset('/images/no_image.jpg');
        }
    }

    /**
     * @return string
     */
    public function getOriginUrl(): string
    {
        if (Storage::disk('public')->exists($this->table . '/' . $this->origin) === true) {
            return Storage::disk('public')->url($this->table . '/' . $this->origin);
        } else {
            return asset('/images/no_image.jpg');
        }
    }

    public static function getProductInStockCount(?array $catalogIds = null): int
    {
        $q = Products::query()->where('in_stock', 1);

        if ($catalogIds) {
            $q->whereIn('catalog_id', $catalogIds);
        }

        return $q->count();
    }

    public static function getProductUnderOrderCount(?array $catalogIds = null): int
    {
        $q = Products::query()->where('under_order', 1);

        if ($catalogIds) {
            $q->whereIn('catalog_id', $catalogIds);
        }

        return $q->count();
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
        self::deleteFile($this->thumbnail, $this->table);
        self::deleteFile($this->origi, $this->table);

        foreach ($this->documents as $document) {
            self::deleteFile($document->path, $this->table);
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

    /**
     * @param $query
     * @param $parents
     * @return mixed
     */
    public function scopeCatalogProducts($query, $parents)
    {
        return $query->whereIn('catalog_id', $parents);
    }

    /**
     * @param $query
     * @param int $from
     * @param int $to
     * @return mixed
     */
    public function scopePriceRange($query, int $from, int $to)
    {
        return $query->whereBetween('price', [$from, $to]);
    }

}