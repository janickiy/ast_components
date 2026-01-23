<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Customers;
use App\Http\Controllers\Controller;
use App\Models\Invites;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    /**
     * Сброс пароля (reset password).
     *
     * @param string $token
     * @param string $email
     * @return View
     */
    public function __invoke(string $token, string $email): View
    {
        $title = 'Сброс пароля';

        $options = Invites::getPlatformList();
        $password = Str::password();

        $status = Password::broker('customer')->reset(
            [
                'token' => $token,
                'email' => $email,
                'password' => $password,
            ],

            function (Customers $customer, string $password) {
                $customer->forceFill([
                    'password' => Hash::make($password),
                ])->save();

                event(new PasswordReset($customer));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return view('frontend.auth.reset_password', [
                'msg' => 'Новый пароль создан и отправлен на адрес электронной почты указанный в профиле',
                'options' => $options,
            ])->with('title', $title);
        }

        return view('frontend.auth.reset_password', [
            'error' => __($status),
            'options' => $options,
        ])->with('title', $title);
    }
}