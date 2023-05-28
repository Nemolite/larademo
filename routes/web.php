<?php

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
/**
 * Helper route
 */
Route::get('/add',[\App\Http\Controllers\MainController::class, 'add'])->name('add');
/**
 * Маршруты
 */
Route::get('/',[\App\Http\Controllers\MainController::class, 'index'])->name('index');
Route::get('/cart',[\App\Http\Controllers\MainController::class, 'cart'])->name('cart');
Route::get('/account',[\App\Http\Controllers\MainController::class, 'account'])->name('account');
Route::get('/contacts',[\App\Http\Controllers\MainController::class, 'contacts'])->name('contacts');

Route::get('/category/{id}',[\App\Http\Controllers\MainController::class, 'category'])->name('category');


Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/addcategory', [App\Http\Controllers\HomeController::class, 'addcategory'])->name('addcategory');
Route::get('/addcategory', [App\Http\Controllers\HomeController::class, 'addcategory'])->name('addcategory');
