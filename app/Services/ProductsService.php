<?php

namespace App\Services;

use App\Http\Traits\File;
use App\Models\Products;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Exception;

class ProductsService
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
        $filename = time() . '.' . $extension;
        $fileNameToStore = 'origin_' . $filename;
        $thumbnailFileNameToStore = 'thumbnail_' . $filename;
        $originName = $request->file('image')->getClientOriginalName();

        if ($request->file('image')->move('uploads/' . Products::getTableName(), $fileNameToStore) === false) {
            throw new Exception(sprintf('Не удалось сохранить %s!', $originName));
        }

        $manager = new ImageManager(new Driver());
        $image = $manager->read(Storage::disk('public')->path(sprintf('%s/%s', Products::getTableName(), $fileNameToStore)));
        $image->scale(width: 300);
        $image->save(Storage::disk('public')->path(sprintf('%s/%s', Products::getTableName(), $thumbnailFileNameToStore)));

        return $filename;
    }

    /**
     * @param Request $request
     * @param Products $product
     * @return string
     * @throws Exception
     */
    public function updateImage(Request $request, Products $product): string
    {
        self::deleteFile($product->thumbnail, Products::getTableName());
        self::deleteFile($product->origin, Products::getTableName());

        $extension = $request->file('image')->getClientOriginalExtension();
        $filename = time() . '.' . $extension;
        $fileNameToStore = 'origin_' . $filename;
        $thumbnailFileNameToStore = 'thumbnail_' . $filename;
        $originName = $request->file('image')->getClientOriginalName();

        if ($request->file('image')->move('uploads/' . Products::getTableName(), $fileNameToStore) === false) {
            throw new Exception(sprintf('Не удалось сохранить %s!', $originName));
        }

        $manager = new ImageManager(new Driver());
        $image = $manager->read(Storage::disk('public')->path(sprintf('%s/%s', Products::getTableName(), $fileNameToStore)));
        $image->scale(width: 300);
        $image->save(Storage::disk('public')->path(sprintf('%s/%s', Products::getTableName(), $thumbnailFileNameToStore)));

        return $filename;
    }
}