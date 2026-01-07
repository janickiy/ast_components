<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Routes in this file are stateless and assigned the "api" middleware group.
|
*/

Route::prefix('v1')->group(function () {
    Route::post('login', [LoginController::class, 'login'])->name('api.v1.login');
    Route::post('register', [RegisterController::class, 'register'])->name('api.v1.register');
    Route::post('forgot', [LoginController::class, 'forgotPassword'])->name('api.v1.forgot');
    Route::post('logout', [LoginController::class, 'logout'])->name('api.v1.logout')->middleware('auth');
});
