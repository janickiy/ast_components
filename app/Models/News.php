<?php

namespace App\Models;

use App\Traits\StaticTableName;
use App\Helpers\StringHelper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class News extends Model
{
    use StaticTableName;

    protected $table = 'news';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'text',
        'preview',
        'published',
        'promotion',
        'image',
        'image_title',
        'image_alt',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'slug',
        'seo_h1',
        'seo_url_canonical'
    ];

    /**
     * @return string
     */
    public function excerpt(): string
    {
        $content = $this->text;
        $content = preg_replace("/<img(.*?)>/si", "", $content);
        $content = preg_replace('/(<.*?>)|(&.*?;)/', '', $content)  ;

        return StringHelper::shortText($content, 500);
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
     * @param $query
     * @return mixed
     */
    public function scopePublished($query)
    {
        return $query->where('published', 1);
    }

    /**
     * @return void
     */
    public function scopeRemove(): void
    {
        if (Storage::disk('public')->exists($this->table . '/' . $this->image) === true) Storage::disk('public')->delete($this->table . '/' . $this->image);

        $this->delete();
    }

    /**
     * @return string
     */
    public function dateFormat(): string
    {
        return Carbon::parse($this->created_at)->format('d.m.Y');
    }
}