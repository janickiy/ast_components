<?php

namespace App\Services;

use App\Helpers\SettingsHelper;
use App\Mail\NomenclatureRequestMailer;
use App\Models\Requests;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Mail;

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

    /**
     * @param Request $request
     * @return void
     */
    public function notify(Request $request): void
    {
        $data = [
            'company' => $request->input('company'),
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'attach' => $attach ?? null,
            'message' => $request->input('message'),
            'nomenclature' => $request->input('nomenclature'),
            'count' => $request->input('count'),
            'unit' => $request->input('unit'),
        ];

        Mail::to(explode(",", SettingsHelper::getInstance()->getValueForKey('EMAIL_NOTIFY')))->send(new NomenclatureRequestMailer($data));
    }

}