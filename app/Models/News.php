<?php

namespace App\Models;

use App\Helpers\StringHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class News extends Model
{
    protected $table = 'news';

    protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'text',
        'preview',
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
        return Storage::disk('public')->url('news/' . $this->image);
    }

    public function scopeRemove(): void
    {
        if (Storage::disk('public')->exists('news/' . $this->image) === true) Storage::disk('public')->delete('news/' . $this->image);

        $this->delete();
    }
}