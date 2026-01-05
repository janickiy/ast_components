<?php

namespace App\Services;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class NewsService
{
    /**
     * @param Request $request
     * @return string
     */
    public function storeImage(Request $request): string
    {
        $extension = $request->file('image')->getClientOriginalExtension();
        $filename = time();
        $originName = $filename . '.' . $extension;

        if ($request->file('image')->move('uploads/news', $originName)) {
            $manager = new ImageManager(new Driver());
            $image = $manager->read(Storage::disk('public')->path('news/' . $originName));
            $image->scale(width: 1200);
            $image->save(Storage::disk('public')->path('news/' . $originName));
        }

        return $originName;
    }

    /**
     * @param News $news
     * @param Request $request
     * @return string
     */
    public function updateImage(News $news, Request $request): string
    {
        $image = $request->pic;

        if ($image != null) {
            if (Storage::disk('public')->exists('news/' . $news->image) === true) Storage::disk('public')->delete('news/' . $news->image);
        }

        if (Storage::disk('public')->exists('news/' . $news->image) === true) Storage::disk('public')->delete('news/' . $news->image);

        $extension = $request->file('image')->getClientOriginalExtension();
        $filename = time() . '.' . $extension;

        if ($request->file('image')->storeAs('public/news', $filename)) {
            $img = Image::make(Storage::path('/public/news/') . $filename);
            $img->resize(null, 300, function ($constraint) {
                $constraint->aspectRatio();
            });

            if ($img->save(Storage::path('/public/news/') . $filename)) $news->image = $filename;
        }

        return $filename;
    }
}