<?php

namespace App\Services;

use Illuminate\Http\Request;

class RequestsService
{
    /**
     * @param Request $request
     * @return false|string
     */
    public function storeFile(Request $request): false|string
    {
        $extension = $request->file('attach')->getClientOriginalExtension();
        $filename = time() . '.' . $extension;
        $request->file('attach')->move('uploads/requests', $filename);

        return $filename;
    }


}