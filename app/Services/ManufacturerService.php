<?php

namespace App\Services;

use App\Models\Manufacturers;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Exception;

class ManufacturerService
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

        if ($request->file('image')->move('uploads/' . Manufacturers::getTableName(), $originName) === false) {
            throw new Exception('Не удалось сохранить файл!');
        }

        $manager = new ImageManager(new Driver());
        $image = $manager->read(Storage::disk('public')->path(Manufacturers::getTableName() . '/' . $originName));
        $image->scale(width: 300);
        $image->save(Storage::disk('public')->path(Manufacturers::getTableName() . '/' . $originName));

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
        if (Storage::disk('public')->exists(Manufacturers::getTableName() . '/' . $manufacturer->image) === true) Storage::disk('public')->delete(Manufacturers::getTableName() . '/' . $manufacturer->image);

        $extension = $request->file('image')->getClientOriginalExtension();
        $filename = time();
        $originName = $filename . '.' . $extension;

        if ($request->file('image')->move('uploads/' . Manufacturers::getTableName(), $originName) === false) {
            throw new Exception('Не удалось сохранить файл!');
        }

        $manager = new ImageManager(new Driver());
        $image = $manager->read(Storage::disk('public')->path(Manufacturers::getTableName() . '/' . $originName));
        $image->scale(width: 300);
        $image->save(Storage::disk('public')->path(Manufacturers::getTableName() . '/' . $originName));

        return $originName;
    }

    /**
     * @param Manufacturers $manufacturer
     * @return void
     */
    public function deleteImage(Manufacturers $manufacturer): void
    {
        if (Storage::disk('public')->exists(Manufacturers::getTableName() . '/' . $manufacturer->image) === true) Storage::disk('public')->delete(Manufacturers::getTableName() . '/' . $manufacturer->image);
    }
}