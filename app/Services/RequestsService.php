<?php

namespace App\Services;


use App\Models\Requests;
use Illuminate\Http\Request;
use Exception;

class RequestsService
{
    /**
     * @param Request $request
     * @return string
     * @throws Exception
     */
    public function storeFile(Request $request): string
    {
        $extension = $request->file('attach')->getClientOriginalExtension();
        $filename = time() . '.' . $extension;

        if ($request->file('attach')->move('uploads/' . Requests::getTableName(), $filename) === false) {
            throw new Exception('Не удалось сохранить файл!');
        }

        return $filename;
    }
}