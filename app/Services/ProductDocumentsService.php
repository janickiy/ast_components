<?php

namespace App\Services;

use App\Models\ProductDocuments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductDocumentsService
{
    /**
     * @param Request $request
     * @return false|string
     */
    public function storeFile(Request $request): false|string
    {
        $extension = $request->file('file')->getClientOriginalExtension();
        $filename = time() . '.' . $extension;
        $request->file('file')->move('uploads/documents', $filename);

        return $filename;
    }

    /**
     * @param ProductDocuments $productDocument
     * @param Request $request
     * @return false|string
     */
    public function updateFile(ProductDocuments $productDocument, Request $request): false|string
    {
        if (Storage::disk('public')->exists('documents/' . $productDocument->path) === true) {
            Storage::disk('public')->delete('documents/' . $productDocument->path);
        }

        $extension = $request->file('file')->getClientOriginalExtension();
        $filename = time() . '.' . $extension;
        $request->file('file')->move('uploads/documents', $filename);

        return $filename;
    }
}