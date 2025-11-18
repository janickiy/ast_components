<?php

namespace App\Services;

use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductsService
{
    /**
     * @param Request $request
     * @return string
     */
    public function storeFile(Request $request): string
    {
        $extension = $request->file('image')->getClientOriginalExtension();
        $filename = time() . '.' . $extension;
        $fileNameToStore = 'origin_' . $filename;
        $thumbnailFileNameToStore = 'thumbnail_' . $filename;

        if ($request->file('image')->move('uploads/products', $fileNameToStore)) {
            $img = Image::make(Storage::disk('public')->path('products/' . $fileNameToStore));
            $img->resize(null, 300, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save(Storage::disk('public')->path('products/' . $thumbnailFileNameToStore));
        }

        return $filename;
    }

    /**
     * @param Products $product
     * @param Request $request
     * @return string
     */
    public function updateFile(Products $product, Request $request): string
    {
        $image = $request->pic;

        if ($image != null) {
            if (Storage::disk('public')->exists('products/' . $product->thumbnail) === true) Storage::disk('public')->delete('products/' . $product->thumbnail);
            if (Storage::disk('public')->exists('products/' . $product->origin) === true) Storage::disk('public')->delete('products/' . $product->origin);
        }

        if (Storage::disk('public')->exists('products/' . $product->thumbnail) === true) Storage::disk('public')->delete('products/' . $product->thumbnail);
        if (Storage::disk('public')->exists('products/' . $product->origin) === true) Storage::disk('public')->delete('products/' . $product->origin);;

        $extension = $request->file('image')->getClientOriginalExtension();
        $filename = time() . '.' . $extension;
        $fileNameToStore = 'origin_' . $filename;
        $thumbnailFileNameToStore = 'thumbnail_' . $filename;

        if ($request->file('image')->move('uploads/products', $fileNameToStore)) {
            $img = Image::make(Storage::disk('public')->path('products/' . $fileNameToStore));
            $img->resize(null, 300, function ($constraint) {
                $constraint->aspectRatio();
            });

            if ($img->save(Storage::disk('public')->path('products/' . $thumbnailFileNameToStore))) {
                $product->thumbnail = $thumbnailFileNameToStore;
                $product->origin = $fileNameToStore;
            }
        }

        return $filename;
    }
}