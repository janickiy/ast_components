<?php

namespace App\Services;

use App\Http\Traits\File;
use App\Models\ProductDocuments;
use Illuminate\Http\Request;
use Exception;

class ProductDocumentsService
{

    use File;

    /**
     * @param Request $request
     * @return string
     * @throws Exception
     */
    public function storeFile(Request $request): string
    {
        $extension = $request->file('file')->getClientOriginalExtension();
        $filename = time() . '.' . $extension;

        if ($request->file('file')->move('uploads/' . ProductDocuments::getTableName(), $filename) === false) {
            throw new Exception(sprintf('Не удалось сохранить %s!', $request->file('file')->getClientOriginalName()));
        }

        return $filename;
    }

    /**
     * @param ProductDocuments $productDocument
     * @param Request $request
     * @return string
     * @throws Exception
     */
    public function updateFile(ProductDocuments $productDocument, Request $request): string
    {
        self::deleteFile($productDocument->path, ProductDocuments::getTableName());

        $extension = $request->file('file')->getClientOriginalExtension();
        $filename = time() . '.' . $extension;

        if ($request->file('file')->move('uploads/' . ProductDocuments::getTableName(), $filename) === false) {
            throw new Exception(sprintf('Не удалось сохранить %s!', $request->file('file')->getClientOriginalName()));
        }

        return $filename;
    }
}