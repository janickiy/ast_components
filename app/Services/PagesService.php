<?php

namespace App\Services;

use App\Models\Pages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PagesService
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

        if ($request->file('image')->move('uploads/pages', $originName)) {
            $img = Image::make(Storage::disk('public')->path('pages/' . $originName));
            $img->resize(null, 700, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save(Storage::disk('public')->path('pages/' . '2x_' . $filename . '.' . $extension));

            $small_img = Image::make(Storage::disk('public')->path('pages/' . $originName));

            $small_img->resize(null, 350, function ($constraint) {
                $constraint->aspectRatio();
            });
            $small_img->save(Storage::disk('public')->path('pages/' . $originName));
        }

        return $originName;
    }

    /**
     * @param Products $product
     * @param Request $request
     * @return string
     */
    public function updateImage(Pages $page, Request $request): string
    {
        $image = $request->pic;

        if ($image != null) {
            if (Storage::disk('public')->exists('pages/' . $page->image) === true) Storage::disk('public')->delete('pages/' . $page->image);
            if (Storage::disk('public')->exists('pages/' . '2x_' . $page->image) === true) Storage::disk('public')->delete('pages/' . '2x_' . $page->image);
        }

        if ($request->hasFile('image')) {
            if (Storage::disk('public')->exists('pages/' . $page->image) === true) Storage::disk('public')->delete('pages/' . $page->image);
            if (Storage::disk('public')->exists('pages/' . '2x_' . $page->image) === true) Storage::disk('public')->delete('pages/' . '2x_' . $page->image);

            $extension = $request->file('image')->getClientOriginalExtension();
            $filename = time();
            $originName = $filename . '.' . $extension;

            if ($request->file('image')->move('uploads/pages', $originName)) {
                $img = Image::make(Storage::disk('public')->path('pages/' . $originName));
                $img->resize(null, 700, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save(Storage::disk('public')->path('pages/' . '2x_' . $filename . '.' . $extension));

                $small_img = Image::make(Storage::disk('public')->path('pages/' . $originName));
                $small_img->resize(null, 350, function ($constraint) {
                    $constraint->aspectRatio();
                });

                if ($small_img->save(Storage::disk('public')->path('pages/' . $originName))) $row->image = $originName;
            }
        }
    }
}