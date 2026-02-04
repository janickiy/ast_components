<?php

namespace App\Services;

use App\Http\Traits\File;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Exception;

class NewsService
{
    use File;

    /**
     * @param Request $request
     * @return string
     * @throws Exception
     */
    public function storeImage(Request $request): string
    {
        $extension = $request->file('image')->getClientOriginalExtension();
        $filename = time();
        $originName = $filename . '.' . $extension;

        if ($request->file('image')->move('uploads/' . News::getTableName(), $originName) === false) {
            throw new Exception('Не удалось сохранить файл!');
        }

        $manager = new ImageManager(new Driver());
        $image = $manager->read(Storage::disk('public')->path(News::getTableName() . '/' . $originName));
        $image->scale(width: 1200);
        $image->save(Storage::disk('public')->path(News::getTableName() . '/' . $originName));

        return $originName;
    }

    /**
     * @param News $news
     * @param Request $request
     * @return string
     * @throws Exception
     */
    public function updateImage(News $news, Request $request): string
    {
        self::deleteFile($news->image, News::getTableName());

        $extension = $request->file('image')->getClientOriginalExtension();
        $originName = time() . '.' . $extension;

        if ($request->file('image')->move('uploads/' . News::getTableName(), $originName) === false) {
            throw new Exception('Не удалось сохранить файл!');
        }

        $manager = new ImageManager(new Driver());
        $image = $manager->read(Storage::disk('public')->path(News::getTableName() . '/' . $originName));
        $image->scale(width: 1200);
        $image->save(Storage::disk('public')->path(News::getTableName() . '/' . $originName));

        return $originName;
    }
}