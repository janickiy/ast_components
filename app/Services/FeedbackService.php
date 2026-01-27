<?php

namespace App\Services;

use App\Helpers\SettingsHelper;
use App\Mail\FeedbackMailer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class FeedbackService
{
    /**
     * @param Request $request
     * @return void
     */
    public function notify(Request $request): void
    {
        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'message' => $request->input('message'),
        ];

        Mail::to(explode(",", SettingsHelper::getInstance()->getValueForKey('EMAIL_NOTIFY')))->send(new FeedbackMailer($data));
    }

}