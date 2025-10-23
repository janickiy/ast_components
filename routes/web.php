<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{
    AuthController,
    CategoryController,
    FeedbackController,
    NewsController,
    DashboardController,
    DataTableController,
    UsersController,
};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.submit');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard.index');

Route::group(['prefix' => 'category'], function () {
    Route::get('', [CategoryController::class, 'index'])->name('admin.category.index')->middleware(['permission:admin|moderator']);
    Route::get('create', [CategoryController::class, 'create'])->name('admin.category.create')->middleware(['permission:admin|moderator']);
    Route::post('store', [CategoryController::class, 'store'])->name('admin.category.store')->middleware(['permission:admin|moderator']);
    Route::get('edit/{id}', [CategoryController::class, 'edit'])->name('admin.category.edit')->where('id', '[0-9]+')->middleware(['permission:admin|moderator']);
    Route::put('update', [CategoryController::class, 'update'])->name('admin.category.update')->middleware(['permission:admin|moderator']);
    Route::post('destroy', [CategoryController::class, 'destroy'])->name('admin.category.destroy')->middleware(['permission:admin|moderator']);
});

Route::get('feedback',FeedbackController::class)->name('admin.feedback.index');

Route::group(['prefix' => 'news'], function () {
    Route::get('', [NewsController::class, 'index'])->name('admin.news.index');
    Route::get('create', [NewsController::class, 'create'])->name('admin.news.create');
    Route::post('store', [NewsController::class, 'store'])->name('admin.news.store');
    Route::get('edit/{id}', [NewsController::class, 'edit'])->name('admin.news.edit')->where('id', '[0-9]+');
    Route::put('update', [NewsController::class, 'update'])->name('admin.news.update');
    Route::post('destroy', [NewsController::class, 'destroy'])->name('admin.news.destroy');
});


Route::group(['prefix' => 'users'], function () {
    Route::get('', [UsersController::class, 'index'])->name('admin.users.index');
    Route::get('create', [UsersController::class, 'create'])->name('admin.users.create');
    Route::post('store', [UsersController::class, 'store'])->name('admin.users.store');
    Route::get('edit/{id}', [UsersController::class, 'edit'])->name('admin.users.edit')->where('id', '[0-9]+');
    Route::put('update', [UsersController::class, 'update'])->name('admin.users.update');
    Route::delete('destroy', [UsersController::class, 'destroy'])->name('admin.users.destroy')->where('id', '[0-9]+');
});

Route::group(['prefix' => 'datatable'], function () {
    Route::any('category', [DataTableController::class, 'category'])->name('admin.datatable.category');
    Route::any('feedback', [DataTableController::class, 'feedback'])->name('admin.datatable.feedback');
    Route::any('users', [DataTableController::class, 'users'])->name('admin.datatable.users');
});