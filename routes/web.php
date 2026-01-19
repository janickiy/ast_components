<?php


use App\Http\Controllers\Frontend\{
    AuthController,
    CartController,
    ComplaintController,
    FrontendController,
    ProfileController,
    ResetPasswordController,
    RequestsController,
};
use Illuminate\Support\Facades\Route;

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

// Запрос номенклатуры
Route::group(['prefix' => 'nomenclature-request'], function () {
    // Форма добавления
    Route::get('', [RequestsController::class, 'index'])->name('frontend.nomenclature_request.index');
    // Добавляем запрос на номенклатуру
    Route::post('store', [RequestsController::class, 'add'])->name('frontend.nomenclature_request.store');
});

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

// Корзина
Route::get('/cart', [CartController::class, 'index'])->name('frontend.cart.index');

Route::prefix('/cart')->name('frontend.cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::post('/qty', [CartController::class, 'setQty'])->name('qty');
    Route::post('/remove', [CartController::class, 'remove'])->name('remove');
    Route::post('/undo', [CartController::class, 'undoRemove'])->name('undo');
    Route::post('/toggle', [CartController::class, 'toggle'])->name('toggle');
    Route::post('/select-all', [CartController::class, 'selectAll'])->name('selectAll');
    Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');
});

// Личный кабинет
Route::group(['prefix' => 'profile'], function () {
    // Профиль
    Route::get('', [ProfileController::class, 'index'])->name('frontend.profile.index');
    // Получаем список заказов
    Route::get('orders', [ProfileController::class, 'orders'])->name('frontend.profile.orders');
    // Получаем список запросов
    Route::get('requests', [ProfileController::class, 'requests'])->name('frontend.profile.requests');
    // Редактирование общей информации
    Route::post('update', [ProfileController::class, 'updateGeneralInfo'])->name('frontend.profile.update.general');
    // Редактирование информации о компании
    Route::post('company', [ProfileController::class, 'updateCompanyInfo'])->name('frontend.profile.update.company');
    // Получаем список претензий
    Route::post('complaints', [ComplaintController::class, 'store'])->name('frontend.profile.complaints.store');
    // Выход
    Route::get('logout', [ProfileController::class, 'logout'])->name('frontend.profile.logout');

});

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login'])->name('frontend.auth.login');
    Route::post('register', [AuthController::class, 'register'])->name('frontend.auth.register');
    Route::post('send-reset-link', [AuthController::class, 'sendResetLink'])->name('frontend.auth.send_reset_link');
});

Route::get('password-reset/{token}/{email}', ResetPasswordController::class)->name('frontend.password.reset');
