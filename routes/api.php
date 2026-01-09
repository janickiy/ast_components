<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Routes in this file are stateless and assigned the "api" middleware group.
|
*/

Route::prefix('v1')->middleware([
        EncryptCookies::class,
        AddQueuedCookiesToResponse::class,
        StartSession::class,
        ShareErrorsFromSession::class,
    ])
    ->group(function ()
    {
        Route::post('login', [LoginController::class, 'login'])->name('api.v1.login');
        Route::post('register', [RegisterController::class, 'register'])->name('api.v1.register');
        Route::post('forgot', [LoginController::class, 'forgotPassword'])->name('api.v1.forgot');
        Route::post('logout', [LoginController::class, 'logout'])->name('api.v1.logout')->middleware('auth:client');
        Route::get('auth-button', [LoginController::class, 'authButtonWidget'])->name('api.v1.auth_button_widget');
        Route::patch('account', [LoginController::class, 'updateAccount'])->name('api.v1.update_profile')->middleware('auth:client');
    });
