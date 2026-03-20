<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\ResetPassword\ResetRequest;
use App\Models\Customers;
use Exception;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    public function index(): View
    {
        return view('frontend.auth.index', [
            'title' => 'Сброс пароля',
        ]);
    }

    public function form(string $token, string $email): View
    {
        return view('frontend.auth.reset_password', [
            'token' => $token,
            'email' => $email,
            'title' => 'Сброс пароля',
        ]);
    }

    public function reset(ResetRequest $request): RedirectResponse
    {
        try {
            $status = Password::broker('customer')->reset(
                [
                    'token' => $request->token,
                    'email' => $request->email,
                    'password' => $request->password,
                ],
                function (Customers $customer, string $password): void {
                    $customer->forceFill([
                        'password' => Hash::make($password),
                    ])->save();

                    event(new PasswordReset($customer));
                },
            );

            if ($status === Password::PASSWORD_RESET) {
                return redirect()
                    ->route('frontend.password.reset')
                    ->with('success', 'Пароль успешно изменен');
            }

            return back()
                ->withInput()
                ->with('error', 'Ошибка изменения пароля');
        } catch (Exception $exception) {
            report($exception);

            return back()
                ->withInput()
                ->with('error', $exception->getMessage());
        }
    }
}