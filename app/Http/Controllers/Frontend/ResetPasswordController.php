<?php

namespace App\Http\Controllers\Frontend;


use App\Models\Customers;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\ResetPassword\ResetRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;


class ResetPasswordController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        return view('frontend.auth.index')->with('title', 'Сброс пароля');
    }

    /**
     * Сброс пароля (reset password).
     *
     * @param string $token
     * @param string $email
     * @return View
     */
    public function form(string $token, string $email): View
    {
        return view('frontend.auth.reset_password', [
            'token' => $token,
            'email' => $email,
        ])->with('title', 'Сброс пароля');
    }

    /**
     * @param ResetRequest $request
     * @return RedirectResponse
     */
    public function reset(ResetRequest $request): RedirectResponse
    {
        try {
            $status = Password::broker('customer')->reset(
                [
                    'token' => $request->token,
                    'email' => $request->email,
                    'password' => $request->password,
                ],

                function (Customers $customer, string $password) {
                    $customer->forceFill([
                        'password' => Hash::make($password),
                    ])->save();

                    event(new PasswordReset($customer));
                }
            );

            if ($status === Password::PASSWORD_RESET) {
                return redirect()->route('frontend.password.reset')->with('success', 'Пароль успешно изменен');
            }

            return redirect()
                ->back()
                ->with('error', 'Ошибка изменения пароля')
                ->withInput();

        } catch (\Exception $e) {
            report($e);

            return redirect()
                ->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }
    }
}