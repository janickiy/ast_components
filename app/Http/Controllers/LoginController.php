<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;

class LoginController extends Controller
{


    /**
     * Handle a login request to the application.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $remember = (bool) $request->filled('remember');

        if (Auth::guard('client')->attempt($credentials, $remember))
        {
            // $request->session()->regenerate();

            return response()->json([
                'message' => 'Вход выполнен успешно',
                'user' => Auth::guard('client')->user(),
                'ok' => true,
            ], 200);
        }

        return response()->json([
            'message' => 'Неверное имя пользователя или пароль',
            'ok' => false,
        ], 422);
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        Auth::guard('client')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Выход выполнен успешно'], 200);
    }

    /**
     * Send a password reset token for the given login.
     */
    public function forgotPassword(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'string'],
        ]);
        $status = Password::broker('clients')->sendResetLink(
            $request->only('email')
        );
        return response()->json(['sent' => $status == Password::ResetLinkSent], 200);
    }
}
