<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;

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


//Главная страница
Route::get('', [FrontendController::class, 'index'])->name('frontend.index');
//Страницы и разделы
Route::get('/page/{slug}', [FrontendController::class, 'page'])->name('frontend.page');
//Пригласить на тендер
Route::get('/invite', [FrontendController::class, 'invite'])->name('frontend.invite');
Route::post('/invite', [FrontendController::class, 'sendInvite'])->name('frontend.send_invite');
//Запрос номенклатуры
Route::get('/nomenclature-request', [FrontendController::class, 'nomenclatureRequest'])->name('frontend.nomenclature_request');
Route::post('/send-nomenclature-request', [FrontendController::class, 'sendNomenclatureRequest'])->name('frontend.send_nomenclature_request');
//Новости
Route::get('/news', [FrontendController::class, 'news'])->name('frontend.news');
//Описание новости
Route::get('/news/{slug}', [FrontendController::class, 'newsItem'])->name('frontend.news_item');
//каталог
Route::get('/catalog/{slug?}', [FrontendController::class, 'catalog'])->name('frontend.catalog');
//Контакты
Route::get('/contacts', [FrontendController::class, 'contacts'])->name('frontend.contacts');
Route::post('/contacts', [FrontendController::class, 'sendFeedback'])->name('frontend.send_feedback');
//Конверторы
Route::get('/converters', [FrontendController::class, 'converters'])->name('frontend.converters');
//Производители
Route::get('/manufacturers', [FrontendController::class, 'manufacturers'])->name('frontend.manufacturers');
// Описание производителя
Route::get('/manufacturer/{slug}', [FrontendController::class, 'manufacturer'])->name('frontend.manufacturer');

Route::any('/get-subcategory', [FrontendController::class, 'getSubcategory'])->name('frontend.get_subcategory');

// Доставка и оплата
Route::any('/conditions', [FrontendController::class, 'conditions'])->name('frontend.conditions');

Route::get('product/{slug}', [FrontendController::class, 'product'])->name('frontend.product');