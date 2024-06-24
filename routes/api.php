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

Route::post('/order', [\App\Http\Controllers\API\V1\OrderController::class, 'store']);
Route::post('/coupon', [\App\Http\Controllers\API\V1\CouponController::class, 'show']);
Route::get('/store/status', [\App\Http\Controllers\API\V1\StoreStatusController::class, 'show']);
Route::get('/areas', [\App\Http\Controllers\API\V1\AreaController::class, 'index']);
Route::get('/payment-methods', [\App\Http\Controllers\API\V1\PaymentMethodController::class, 'index']);
Route::get('/settings', [\App\Http\Controllers\API\V1\SettingsController::class, 'index']);
Route::get('/categories/items/pos', [\App\Http\Controllers\API\V1\PosController::class, 'index']);
Route::get('/items/{item}/quantity/{quantity}', [\App\Http\Controllers\API\V1\PosController::class, 'inventoryQuantity']);
Route::get('/items/{item}/quantity/{quantity}/add', [\App\Http\Controllers\API\V1\PosController::class, 'inventoryQuantityAdd']);
Route::get('/categories/items/android', [\App\Http\Controllers\API\V1\AndroidController::class, 'index']);
Route::get('/categories/items/ios', [\App\Http\Controllers\API\V1\IosController::class, 'index']);

Route::post('/login', [\App\Http\Controllers\API\V1\AuthController::class, 'authenticate']);
// Route::post('/register', [\App\Http\Controllers\API\V1\AuthController::class, 'register']);
Route::middleware(['auth:api'])->group(function () {
    Route::delete('/logout', [\App\Http\Controllers\API\V1\AuthController::class, 'logout']);
    Route::get('/user', [\App\Http\Controllers\API\V1\UserController::class, 'show']);
    Route::get('/user/orders', [\App\Http\Controllers\API\V1\UserOrderController::class, 'index']);
    Route::get('/user/orders/{id}', [\App\Http\Controllers\API\V1\UserOrderController::class, 'show']);
});

//Recently Added
Route::post('/register', [\App\Http\Controllers\API\V1\RegisterController::class, 'test']);