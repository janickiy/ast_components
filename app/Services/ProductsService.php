<?php

namespace App\Services;

use App\Models\Products;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductsService
{
    /**
     * @param Request $request
     * @return string
     */
    public function storeImage(Request $request): string
    {
        $extension = $request->file('image')->getClientOriginalExtension();
        $filename = time() . '.' . $extension;
        $fileNameToStore = 'origin_' . $filename;
        $thumbnailFileNameToStore = 'thumbnail_' . $filename;

        if ($request->file('image')->move('uploads/products', $fileNameToStore)) {
            $manager = new ImageManager(new Driver());
            $image = $manager->read(Storage::disk('public')->path('products/' . $fileNameToStore));
            $image->scale(width: 300);
            $image->save(Storage::disk('public')->path('products/' . $thumbnailFileNameToStore));
        }

        return $filename;
    }

    /**
     * @param Products $product
     * @param Request $request
     * @return string
     */
    public function updateImage(Request $request, Products $product): string
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
            $manager = new ImageManager(new Driver());
            $image = $manager->read(Storage::disk('public')->path('products/' . $fileNameToStore));
            $image->scale(width: 300);
            $image->save(Storage::disk('public')->path('products/' . $thumbnailFileNameToStore));
            $product->thumbnail = $thumbnailFileNameToStore;
            $product->origin = $fileNameToStore;
            $product->save();
        }

        return $filename;
    }
}