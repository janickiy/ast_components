<?php

namespace App\Services;

use App\Models\Manufacturers;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

        if ($request->file('image')->move('uploads/manufacturers', $originName)) {
            $manager = new ImageManager(new Driver());
            $image = $manager->read(Storage::disk('public')->path('manufacturers/' . $originName));
            $image->scale(width: 300);
            $image->save(Storage::disk('public')->path('manufacturers/' . $originName));
        }

        return $originName;
    }

    /**
     * @param Manufacturers $manufacturer
     * @param Request $request
     * @return string
     */
    public function updateImage(Manufacturers $manufacturer, Request $request): string
    {
        if (Storage::disk('public')->exists('manufacturers/' . $manufacturer->image) === true) Storage::disk('public')->delete('manufacturers/' . $manufacturer->image);

        $extension = $request->file('image')->getClientOriginalExtension();
        $filename = time();
        $originName = $filename . '.' . $extension;

        if ($request->file('image')->move('uploads/manufacturers', $originName)) {
            $manager = new ImageManager(new Driver());
            $image = $manager->read(Storage::disk('public')->path('manufacturers/' . $originName));
            $image->scale(width: 300);
            $image->save(Storage::disk('public')->path('manufacturers/' . $originName));
        }

        return $originName;
    }

    /**
     * @param Manufacturers $manufacturer
     * @return void
     */
    public function deleteImage(Manufacturers $manufacturer): void
    {
        if (Storage::disk('public')->exists('manufacturers/' . $manufacturer->image) === true) Storage::disk('public')->delete('manufacturers/' . $manufacturer->image);
    }
}