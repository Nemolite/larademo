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
Route::get('/contacts',[\App\Http\Controllers\MainController::class, 'contacts'])->name('contacts');
Route::get('/cat/{id}',[\App\Http\Controllers\MainController::class, 'cat'])->name('cat');
Route::post('/cartproduct',[\App\Http\Controllers\MainController::class, 'cartproduct'])->name('cartproduct');


Auth::routes();
// Панель управления магазином (только для админа)
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

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


    // users

        // Панель управления аккаунтом, заказми, корзиной (для пользователя)
        Route::get('/cart',[\App\Http\Controllers\MainController::class, 'cart'])->name('cart');
        Route::get('/account',[\App\Http\Controllers\MainController::class, 'account'])->name('account');

});








