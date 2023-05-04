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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/category/{category}', [App\Http\Controllers\CategoryController::class, 'index'])->name('category');
Route::get('/', [App\Http\Controllers\MainPageController::class, 'index'])->name('mainpage');
Route::get('cart', [App\Http\Controllers\OrderController::class, 'currentOrderShow'])->name('cart');

Route::get('add-to-cart/{item}', [App\Http\Controllers\ItemController::class, 'addToCart'])->name('addtocart');
//POST запрос с полями: cartKey, itemId, quantity плюс KEY корзины http://shopcat.local/api/cart/3496dd7c2933c09015eb7ee6cab34c24
Route::post('/cart/{item}', [App\Http\Controllers\OrderController::class, 'addItemWeb'])->name('addItemToCartWeb');

Route::patch('/cart/{item}', [App\Http\Controllers\OrderController::class, 'updateCart'])->name('updateCartWeb');
Route::delete('/cart/{item}', [App\Http\Controllers\OrderController::class, 'removeFromCartWeb'])->name('removeFromCartWeb');
Route::post('/order/{order}', [App\Http\Controllers\OrderController::class, 'store'])->name('createorder');
Route::get('/orders', [App\Http\Controllers\OrderController::class, 'index'])->name('orderslist');
Route::get('/order/{order}', [App\Http\Controllers\OrderController::class, 'show'])->name('singleorder');
Route::get('/item/{item}', [App\Http\Controllers\ItemController::class, 'show'])->name('singleitem');
