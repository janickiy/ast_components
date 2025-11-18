<?php

namespace App\Services;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsService
{
    /**
     * @param Request $request
     * @return string
     */
    public function storeImage(Request $request): string
    {
        $extension = $request->file('image')->getClientOriginalExtension();
        $filename = time() . '.' . $extension;

        if ($request->file('image')->storeAs('public/news', $filename)) {
            $img = Image::make(Storage::path('/public/news/') . $filename);
            $img->resize(null, 300, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save(Storage::path('/public/news/') . $filename);
        }

        return $filename;
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