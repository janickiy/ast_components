<?php

namespace App\Http\Controllers;

use App\Models\Client;
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
            $request->session()->regenerate();

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

    public function updateAccount(Request $request)
    {
        $user = Auth::guard('client')->user();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['nullable', 'string', 'min:8'],
        ]);

        if ($user->email != $data['email'])
        {
            $emailExists = Client::where('email', $data['email'])->exists();
            if ($emailExists)
            {
                return response()->json([
                    'message' => 'Данный email уже используется другим пользователем',
                    'ok' => false,
                ], 422);
            }
        }

        $user->name = $data['name'];
        $user->email = $data['email'];
        if (!empty($data['password']))
        {
            $user->password = Hash::make($data['password']);
        }
        $user->save();

        return response()->json([
            'message' => 'Данные аккаунта успешно обновлены',
            'user' => $user,
            'ok' => true,
        ], 200);
    }

    public function authButtonWidget()
    {

        $html = view('partials.auth-button', [])->render();
        return response()->json(['html' => $html], 200);
    }
}
