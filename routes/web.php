<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{
    AuthController,
    AjaxController,
    CatalogController,
    FeedbackController,
    ProductsController,
    NewsController,
    DashboardController,
    DataTableController,
    UsersController,
    SettingsController,
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

Route::group(['prefix' => 'cp'], function () {

    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard.index');

    Route::group(['prefix' => 'catalog'], function () {
        Route::get('', [CatalogController::class, 'index'])->name('admin.catalog.index')->middleware(['permission:admin|moderator']);
        Route::get('create', [CatalogController::class, 'create'])->name('admin.catalog.create')->middleware(['permission:admin|moderator']);
        Route::post('store', [CatalogController::class, 'store'])->name('admin.catalog.store')->middleware(['permission:admin|moderator']);
        Route::get('edit/{id}', [CatalogController::class, 'edit'])->name('admin.catalog.edit')->where('id', '[0-9]+')->middleware(['permission:admin|moderator']);
        Route::put('update', [CatalogController::class, 'update'])->name('admin.catalog.update')->middleware(['permission:admin|moderator']);
        Route::post('destroy', [CatalogController::class, 'destroy'])->name('admin.catalog.destroy')->middleware(['permission:admin|moderator']);
    });

    Route::get('feedback', FeedbackController::class)->name('admin.feedback.index');

    Route::group(['prefix' => 'news'], function () {
        Route::get('', [NewsController::class, 'index'])->name('admin.news.index');
        Route::get('create', [NewsController::class, 'create'])->name('admin.news.create');
        Route::post('store', [NewsController::class, 'store'])->name('admin.news.store');
        Route::get('edit/{id}', [NewsController::class, 'edit'])->name('admin.news.edit')->where('id', '[0-9]+');
        Route::put('update', [NewsController::class, 'update'])->name('admin.news.update');
        Route::post('destroy', [NewsController::class, 'destroy'])->name('admin.news.destroy');
    });

    Route::middleware(['permission:admin'])->group(function () {
        Route::group(['prefix' => 'users'], function () {
            Route::get('', [UsersController::class, 'index'])->name('admin.users.index');
            Route::get('create', [UsersController::class, 'create'])->name('admin.users.create');
            Route::post('store', [UsersController::class, 'store'])->name('admin.users.store');
            Route::get('edit/{id}', [UsersController::class, 'edit'])->name('admin.users.edit')->where('id', '[0-9]+');
            Route::put('update', [UsersController::class, 'update'])->name('admin.users.update');
            Route::delete('destroy', [UsersController::class, 'destroy'])->name('admin.users.destroy')->where('id', '[0-9]+');
        });
    });

    Route::middleware(['permission:admin'])->group(function () {
        Route::group(['prefix' => 'settings'], function () {
            Route::get('', [SettingsController::class, 'index'])->name('admin.settings.index');
            Route::get('create/{type}', [SettingsController::class, 'create'])->name('admin.settings.create');
            Route::post('store', [SettingsController::class, 'store'])->name('admin.settings.store');
            Route::get('edit/{id}', [SettingsController::class, 'edit'])->name('admin.settings.edit')->where('id', '[0-9]+');
            Route::put('update', [SettingsController::class, 'update'])->name('admin.settings.update');
            Route::post('destroy', [SettingsController::class, 'destroy'])->name('admin.settings.destroy');
        });
    });

    Route::group(['prefix' => 'products'], function () {
        Route::get('', [ProductsController::class, 'index'])->name('admin.products.index');
        Route::get('create', [ProductsController::class, 'create'])->name('admin.products.create');
        Route::post('store', [ProductsController::class, 'store'])->name('admin.products.store');
        Route::get('edit/{id}', [ProductsController::class, 'edit'])->name('admin.products.edit')->where('id', '[0-9]+');
        Route::put('update', [ProductsController::class, 'update'])->name('admin.products.update');
        Route::post('destroy', [ProductsController::class, 'destroy'])->name('admin.products.destroy');
    });


    Route::any('ajax', AjaxController::class)->name('admin.ajax');

    Route::group(['prefix' => 'datatable'], function () {
        Route::any('category', [DataTableController::class, 'category'])->name('admin.datatable.category');
        Route::any('products', [DataTableController::class, 'products'])->name('admin.datatable.products');
        Route::any('news', [DataTableController::class, 'news'])->name('admin.datatable.news');
        Route::any('feedback', [DataTableController::class, 'feedback'])->name('admin.datatable.feedback');
        Route::any('users', [DataTableController::class, 'users'])->name('admin.datatable.users')->middleware(['permission:admin']);
        Route::any('settings', [DataTableController::class, 'settings'])->name('admin.datatable.settings');
    });

});