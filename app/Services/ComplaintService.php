<?php

namespace App\Services;

use App\Models\Complaints;
use Illuminate\Http\Request;
use Exception;

class ComplaintService
{
    /**
     * @param Request $request
     * @return string
     * @throws Exception
     */
    public function storeBlank(Request $request): string
    {
        $extension = $request->file('file')->getClientOriginalExtension();
        $filename = time() . '.' . $extension;
        $originName = $request->file('file')->getClientOriginalName();

        if ($request->file('blank')->move('uploads/' . Complaints::getTableName(), $filename) === false) {
            throw new Exception(sprintf('Не удалось сохранить %s!', $originName));
        }

        return $filename;
    }
}