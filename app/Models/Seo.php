<?php

namespace App\Models;

use App\Traits\StaticTableName;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Seo extends Model
{
    use StaticTableName;

    protected $table = 'seo';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type',
        'h1',
        'title',
        'keyword',
        'description',
        'url_canonical',
    ];

    /**
     * @param string $type
     * @param string $title
     * @return array'
     */
    public static function getSeo(string $type, string $title): array
    {
        $key = md5($type);

        if (Cache::has($key)) {
            return Cache::get($key);
        }  else {
            $seo = Seo::where('type', $type)->first();
            $title = $seo->h1 ?? $title;

            $value = [
                'meta_description' => $seo->description ?? '',
                'meta_keywords' => $seo->keyword ?? '',
                'meta_title' =>  $seo->title ?? '',
                'seo_url_canonical' => $seo->url_canonical ?? '',
                'h1' => $seo->h1 ?? $title,
                'title' => $title,
            ];

            Cache::put($key, $value);

            return $value;
        }
    }
}