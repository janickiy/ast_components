<?php

namespace App\Http\Controllers\Frontend;


use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Auth\LoginRequest;
use App\Http\Requests\Frontend\Auth\RegisterRequest;
use App\Http\Requests\Frontend\Auth\ForgotPasswordRequest;
use App\Models\Customers;
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
        $cartSnapshot = $request->session()->get('cart'); // <—

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::guard('customer')->attempt($credentials, true)) {
            $request->session()->regenerate();

            // восстановили корзину
            if ($cartSnapshot !== null) {
                $request->session()->put('cart', $cartSnapshot);
            }

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
        $cartSnapshot = session('cart'); // <—

        $customer = Customers::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::guard('customer')->login($customer);

        if ($cartSnapshot !== null) {
            session(['cart' => $cartSnapshot]);
        }

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
            report($e);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}