<?php

namespace App\Http\Traits;

use Storage;

trait File
{
    /**
     * @param string $file
     * @param string $path
     * @return bool
     */
    public static function deleteFile(string $file, string $path): bool
    {
        if (Storage::disk('public')->exists('%s/%s', $path, $file) === true) {
            return Storage::disk('public')->delete(sprintf('%s/%s', $path, $file));
        }

        return false;
    }

    /**
     * @param string|null $file
     * @param string $path
     * @return string|null
     */
    public static function getFile(?string $file = null, string $path): ?string
    {
        return $file ? Storage::disk('public')->url('%s/%s', $path, $file) : null;
    }
}