<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Manufacturers extends Model
{
    protected $table = 'manufacturers';

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
     * @param string|null $x
     * @return string
     */
    public function getImage(?string $x = null): string
    {
        $image = $x ? $x . $this->image : $this->image;

        return Storage::disk('public')->url('manufacturers/' . $image);
    }

    /**
     * @return void
     */
    public function scopeRemove(): void
    {
        if (Storage::disk('public')->exists('manufacturers/' . $this->image) === true) Storage::disk('public')->delete('manufacturers/' . $this->image);
        if (Storage::disk('public')->exists('manufacturers/' . '2x_' . $this->image) === true) Storage::disk('public')->delete('manufacturers/' . '2x_' . $this->image);

        $this->delete();
    }
}