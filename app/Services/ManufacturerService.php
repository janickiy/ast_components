<?php

namespace App\Services;

use App\Http\Traits\File;
use App\Models\Manufacturers;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Exception;

class ManufacturerService
{
    use File;

    /**
     * @param Request $request
     * @return string
     */
    public function storeImage(Request $request): string
    {
        $extension = $request->file('image')->getClientOriginalExtension();
        $filename = time();
        $originName = $filename . '.' . $extension;

        if ($request->file('image')->move('uploads/' . Manufacturers::getTableName(), $originName) === false) {
            throw new Exception(sprintf('Не удалось сохранить %s!', $request->file('image')->getClientOriginalName()));
        }

        $manager = new ImageManager(new Driver());
        $image = $manager->read(Storage::disk('public')->path(sprintf('%s/%s', Manufacturers::getTableName(), $originName)));
        $image->scale(width: 300);
        $image->save(Storage::disk('public')->path(sprintf('%s/%s', Manufacturers::getTableName(), $originName)));

        return $originName;
    }

    /**
     * @param Manufacturers $manufacturer
     * @param Request $request
     * @return string
     * @throws Exception
     */
    public function updateImage(Manufacturers $manufacturer, Request $request): string
    {
        self::deleteFile( $manufacturer->image, Manufacturers::getTableName());

        $extension = $request->file('image')->getClientOriginalExtension();
        $filename = time();
        $originName = $filename . '.' . $extension;

        if ($request->file('image')->move('uploads/' . Manufacturers::getTableName(), $originName) === false) {
            throw new Exception(sprintf('Не удалось сохранить %s!', $request->file('image')->getClientOriginalName()));
        }

        $manager = new ImageManager(new Driver());
        $image = $manager->read(Storage::disk('public')->path(sprintf('%s/%s', Manufacturers::getTableName(), $originName)));
        $image->scale(width: 300);
        $image->save(Storage::disk('public')->path(sprintf('%s/%s', Manufacturers::getTableName(), $originName)));

        return $originName;
    }

    /**
     * @param Manufacturers $manufacturer
     * @return void
     */
    public function deleteImage(Manufacturers $manufacturer): void
    {
        self::deleteFile( $manufacturer->image, Manufacturers::getTableName());
    }
}