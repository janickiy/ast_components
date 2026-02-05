<?php

namespace App\Services;

use App\Helpers\SettingsHelper;
use App\Mail\InviteMailer;
use App\Models\Invites;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Mail;

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
        $originName = $request->file('attach')->getClientOriginalName();

        if ($request->file('attach')->move('uploads/' . Invites::getTableName(), $filename) === false) {
            throw new Exception(sprintf('Не удалось сохранить %s!', $originName));
        }

        return $filename;
    }

    /**
     * @param Request $request
     * @return void
     */
    public function notify(Request $request): void
    {
        $data = [
            'company' => $request->company,
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'platform' => $request->input('platform'),
            'numb' => $request->input('numb'),
            'message' => $request->input('message'),
        ];

        Mail::to(explode(",", SettingsHelper::getInstance()->getValueForKey('EMAIL_NOTIFY')))->send(new InviteMailer($data));
    }
}