<?php

namespace App\Services;

use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Exception;


class SettingsService
{
    /**
     * @param Request $request
     * @return string
     * @throws Exception
     */
    public function storeFile(Request $request): string
    {
        $extension = $request->file('value')->getClientOriginalExtension();
        $filename = time() . '.' . $extension;

        if ($request->file('value')->move('uploads/' . Settings::getTableName(), $filename) === false) {
            throw new Exception('Не удалось сохранить файл!');
        }

        return $filename;
    }

    /**
     * @param Settings $settings
     * @param Request $request
     * @return string
     * @throws Exception
     */
    public function updateFile(Settings $settings, Request $request): string
    {
        if (Storage::disk('public')->exists(Settings::getTableName() . '/' . $settings->filePath()) === true) {
            Storage::disk('public')->delete(Settings::getTableName() . '/' . $settings->filePath());
        }

        $extension = $request->file('value')->getClientOriginalExtension();
        $filename = time() . '.' . $extension;

        if ($request->file('value')->move('uploads/' . Settings::getTableName(), $filename) === false) {
            throw new Exception('Не удалось сохранить файл!');
        }

        return $filename;
    }
}