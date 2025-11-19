<?php

namespace App\Services;

use App\Models\Manufacturers;
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
            $img = Image::make(Storage::disk('public')->path('manufacturers/' . $originName));
            $img->resize(null, 700, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save(Storage::disk('public')->path('manufacturers/' . '2x_' . $filename . '.' . $extension));

            $small_img = Image::make(Storage::disk('public')->path('manufacturers/' . $originName));

            $small_img->resize(null, 350, function ($constraint) {
                $constraint->aspectRatio();
            });
            $small_img->save(Storage::disk('public')->path('manufacturers/' . $originName));
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
        $image = $request->pic;

        if ($image != null) {
            if (Storage::disk('public')->exists('manufacturers/' . $manufacturer->image) === true) Storage::disk('public')->delete('manufacturers/' . $manufacturer->image);
            if (Storage::disk('public')->exists('manufacturers/' . '2x_' . $manufacturer->image) === true) Storage::disk('public')->delete('manufacturers/' . '2x_' . $manufacturer->image);
        }

        if ($request->hasFile('image')) {
            if (Storage::disk('public')->exists('manufacturers/' . $manufacturer->image) === true) Storage::disk('public')->delete('manufacturers/' . $manufacturer->image);
            if (Storage::disk('public')->exists('manufacturers/' . '2x_' . $manufacturer->image) === true) Storage::disk('public')->delete('manufacturers/' . '2x_' . $manufacturer->image);

            $extension = $request->file('image')->getClientOriginalExtension();
            $filename = time();
            $originName = $filename . '.' . $extension;

            if ($request->file('image')->move('uploads/manufacturers', $originName)) {
                $img = Image::make(Storage::disk('public')->path('manufacturers/' . $originName));
                $img->resize(null, 700, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save(Storage::disk('public')->path('manufacturers/' . '2x_' . $filename . '.' . $extension));

                $small_img = Image::make(Storage::disk('public')->path('manufacturers/' . $originName));
                $small_img->resize(null, 350, function ($constraint) {
                    $constraint->aspectRatio();
                });

                if ($small_img->save(Storage::disk('public')->path('pages/' . $originName))) $manufacturer->image = $originName;
            }
        }

        return $originName;
    }
}