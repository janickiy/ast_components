<?php

namespace App\Http\Controllers\Frontend;


use App\Helpers\StringHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Auth\LoginRequest;
use App\Http\Requests\Frontend\Auth\RegisterRequest;
use App\Http\Requests\Frontend\Auth\ForgotPasswordRequest;
use App\Models\Customers;
use App\Models\Logs;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:customer');
    }

    /**
     * Авторизация
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::guard('customer')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            auth()->guard('customer')->user()->log(Logs::ACTION_LOGIN);

            return response()->json([
                'success' => true,
                'message' => 'Вы успешно авторизовались',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Неверный email или пароль',
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Регистрация
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $customer = Customers::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::guard('customer')->login($customer);

        $customer->log(Logs::ACTION_REGISTRATION);

        return response()->json([
            'success' => true,
            'message' => 'Вы успешно зарегистрировались',
        ]);
    }

    /**
     * Восстановление пароля
     *
     * @param ForgotPasswordRequest $request
     * @return JsonResponse
     */
    public function sendResetLink(ForgotPasswordRequest $request): JsonResponse
    {
        try {
            $status = Password::broker('customer')->sendResetLink(
                $request->only('email')
            );

            if ($status === Password::RESET_LINK_SENT) {

                $customer = Customers::where('email', $request->email)->first();

                $customer->log(Logs::ACTION_PASSWORD_RESET);

                return response()->json([
                    'success' => true,
                    'message' => 'Ссылка для сброса пароля отправлена на ваш email',
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Не удалось отправить ссылку. Попробуйте позже.',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);

        } catch (\Exception $e) {
            Log::error('Password reset link error: ' . $e->getMessage(), [
                'email' => $request->email,
                'exception' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}