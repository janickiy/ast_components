<?php

namespace App\Services;

use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsService
{
    /**
     * @param Request $request
     * @return false|string
     */
    public function storeFile(Request $request): false|string
    {
        $extension = $request->file('value')->getClientOriginalExtension();
        $filename = time() . '.' . $extension;

        if ($request->file('value')->move('uploads/settings', $filename) === false) {
            return false;
        }

        return $filename;
    }

    /**
     * @param Settings $settings
     * @param Request $request
     * @return false|string
     */
    public function updateFile(Settings $settings, Request $request): false|string
    {
        if (Storage::disk('public')->exists('settings/' . $settings->filePath()) === true) {
            Storage::disk('public')->delete('settings/' . $settings->filePath());
        }

        $extension = $request->file('value')->getClientOriginalExtension();
        $filename = time() . '.' . $extension;

        if ($request->file('value')->move('uploads/settings', $filename) === false) {
            return false;
        }

        return $filename;
    }
}