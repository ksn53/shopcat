<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::prefix('sanctum')->namespace('API')->group(function() {
    //POST запрос: name, password, email, phhone, token (имя токена) http://shopcat.local/api/sanctum/register
    //ответ - токен пользователя
    Route::post('register', [App\Http\Controllers\API\AuthController::class, 'register']);
    //POST запрос: password, email, token (имя токена) http://shopcat.local/api/sanctum/token
    //ответ - токен пользователя
    Route::post('token', [App\Http\Controllers\API\AuthController::class, 'token']);
});

//На входе GET запрос и slug товара http://shopcat.local/api/item/kwqv
Route::get('/item/{item}', [App\Http\Controllers\ItemController::class, 'showApi'])->name('singleitemApi');

//Просто GET запрос без параметров http://shopcat.local/api/items
Route::get('/items', [App\Http\Controllers\ItemController::class, 'indexApi'])->name('indexApi');

//На входе GET запрос и ID заказа http://shopcat.local/api/order/1
Route::get('/order/{order}', [App\Http\Controllers\OrderController::class, 'showApi'])->name('singleOrderApi');

//Просто GET запрос без параметров плюс Bearer токен пользователя http://shopcat.local/api/orders
Route::get('/orders', [App\Http\Controllers\OrderController::class, 'indexApi'])->middleware('auth:sanctum')->name('indexOrderApi');

//Просто GET запрос без параметров http://shopcat.local/api/categorys
Route::get('/categorys', [App\Http\Controllers\CategoryController::class, 'treeApi']);

//На входе GET запрос с опциональными параметрами:
// category, minprice, maxprice, maxweight, minweight товара http://shopcat.local/api/filteritems
Route::get('/filteritems', [App\Http\Controllers\API\ApiItemsController::class, 'index']);

//Просто GET запрос без параметров http://shopcat.local/api/carts
Route::get('/carts', [App\Http\Controllers\API\CartController::class, 'index'])->middleware('auth:sanctum');

//На входе GET запрос и KEY корзины http://shopcat.local/api/cart/3496dd7c2933c09015eb7ee6cab34c24
Route::get('/cart/{cart}', [App\Http\Controllers\API\CartController::class, 'show'])->name('singleCart');

//На входе GET запрос и KEY корзины http://shopcat.local/api/newcart
//На выходе KEY пустой корзины
Route::get('/newcart', [App\Http\Controllers\API\CartController::class, 'store'])->name('newCart');

//POST запрос с полями: cartKey, itemId, quantity плюс KEY корзины http://shopcat.local/api/cart/3496dd7c2933c09015eb7ee6cab34c24
Route::post('/cart/{cart}', [App\Http\Controllers\API\CartController::class, 'addItem'])->name('addItemToCart');

//POST запрос с полями: name, email, phone и KEY корзины для формирования заказа
Route::post('/cart/order/{cart}', [App\Http\Controllers\OrderController::class, 'storeApi']);

//На входе GET запрос и KEY для удаления корзины http://shopcat.local/api/cart/del/3496dd7c2933c09015eb7ee6cab34c24
Route::get('/cart/del/{cart}', [App\Http\Controllers\API\CartController::class, 'destroy'])->middleware('auth:sanctum');
