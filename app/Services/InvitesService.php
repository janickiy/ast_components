<?php

namespace App\Services;

use App\Models\Invites;
use Illuminate\Http\Request;
use Exception;

class InvitesService
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

        if ($request->file('attach')->move('uploads/' . Invites::getTableName(), $filename) === false) {
            throw new Exception('Не удалось сохранить файл!');
        }

        return $filename;
    }
}