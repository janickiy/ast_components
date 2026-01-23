<?php

namespace App\Services;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Exception;

class NewsService
{
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
        $image = $request->pic;

        if ($image != null) {
            if (Storage::disk('public')->exists(News::getTableName() . '/' . $news->image) === true) Storage::disk('public')->delete(News::getTableName() . '/' . $news->image);
        }

        if (Storage::disk('public')->exists(News::getTableName() . '/' . $news->image) === true) Storage::disk('public')->delete(News::getTableName() . '/' . $news->image);

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