<?php

namespace App\Services;


use Illuminate\Http\Request;

class FeedbackService
{
    /**
     * @param Request $request
     * @return false|string
     */
    public function storeFile(Request $request): false|string
    {
        $extension = $request->file('value')->getClientOriginalExtension();
        $filename = time() . '.' . $extension;

        if ($request->file('value')->move('uploads/attach', $filename) === false) {
            return false;
        }

        return $filename;
    }
}