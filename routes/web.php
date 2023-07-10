<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
Route::get('/', function () {
    return view('welcome');
});
*/

// Маршруты для фронта
Route::get('/',[\App\Http\Controllers\MainController::class, 'index'])->name('index');
Route::post('/',[\App\Http\Controllers\MainController::class, 'index'])->name('indexsort');
Route::get('/contacts',[\App\Http\Controllers\MainController::class, 'contacts'])->name('contacts');
Route::get('/onas',[\App\Http\Controllers\MainController::class, 'onas'])->name('onas');
Route::get('/cat/{id}',[\App\Http\Controllers\MainController::class, 'cat'])->name('cat');
Route::post('/cartproduct',[\App\Http\Controllers\MainController::class, 'cartproduct'])->name('cartproduct');
Route::post('/showproduct',[\App\Http\Controllers\MainController::class, 'showproduct'])->name('showproduct');
Route::post('/contacts',[\App\Http\Controllers\MainController::class, 'contacts'])->name('contacts');


Auth::routes();
// Панель управления магазином (только для админа)
Route::get('/admin', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout')->name('logout');

// https://habr.com/ru/articles/671018/
Route::middleware('auth')->group(function() {
    // admin

        // Работа с категориями
        Route::get('/category', [App\Http\Controllers\HomeController::class, 'category'])->name('category');
        Route::post('/addcategory', [App\Http\Controllers\HomeController::class, 'addcategory'])->name('addcategory');
        Route::get('/addcategory', [App\Http\Controllers\HomeController::class, 'addcategory'])->name('addcategory');
        Route::get('/updatecategory/{id}', [App\Http\Controllers\HomeController::class, 'updatecategory'])->name('updatecategory');
        Route::post('/updatecat', [App\Http\Controllers\HomeController::class, 'updatecat'])->name('updatecat');
        Route::post('/deletecategory', [App\Http\Controllers\HomeController::class, 'deletecategory'])->name('deletecategory');

        //Работа с товаром
        Route::get('/product',[\App\Http\Controllers\HomeController::class, 'product'])->name('product');
        Route::post('/addproduct',[\App\Http\Controllers\HomeController::class, 'addproduct'])->name('addproduct');
        Route::get('/updateproduct/{id}',[\App\Http\Controllers\HomeController::class, 'updateproduct'])->name('updateproduct');
        Route::post('/updateprod',[\App\Http\Controllers\HomeController::class, 'updateprod'])->name('updateprod');
        Route::post('/deleteproduct',[\App\Http\Controllers\HomeController::class, 'deleteproduct'])->name('deleteproduct');

        // Работа с заказами
        Route::get('/adminorders',[\App\Http\Controllers\OrderController::class, 'adminorders'])->name('adminorders');
        Route::post('/adminorders',[\App\Http\Controllers\OrderController::class, 'adminordersstatus'])->name('adminordersstatus');
        Route::post('/adminordersfilter',[\App\Http\Controllers\OrderController::class, 'adminordersfilter'])->name('adminordersfilter');

    // users

        // Панель управления аккаунтом, заказми, корзиной (для пользователя)
        Route::get('/cart',[\App\Http\Controllers\MainController::class, 'cart'])->name('cart');
        Route::get('/account',[\App\Http\Controllers\MainController::class, 'account'])->name('account');

        // Оформление заказ
        Route::post('/orders',[\App\Http\Controllers\MainController::class, 'orders'])->name('orders');

        // Возможность удаление последнего заказа formdelorder
       Route::post('/formdelorder',[\App\Http\Controllers\MainController::class, 'formdelorder'])->name('formdelorder');

        // Удаление товара из корзины
        Route::post('/cartproductdel',[\App\Http\Controllers\MainController::class, 'cartproductdel'])->name('cartproductdel');

        // Подтверждение заказ
        Route::post('/checkout',[\App\Http\Controllers\MainController::class, 'checkout'])->name('checkout');

});








