<?php

use App\Http\Controllers\V1\AuthController;
use App\Http\Controllers\V1\CoinController;
use App\Http\Controllers\V1\OrderBookController;
use App\Http\Controllers\V1\OrderController;
use App\Http\Controllers\V1\SpotOrderPlacementController;
use App\Http\Controllers\V1\TradeController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1', 'middleware' => 'auth:sanctum'], function() {
    Route::post('/auth/token', [AuthController::class, 'token'])->withoutMiddleware('auth:sanctum')->name('auth.token');
    Route::get('/auth/whoami', [AuthController::class, 'whoami'])->name('auth.whoami');

    Route::get('/coins', [CoinController::class, 'index'])->withoutMiddleware('auth:sanctum')->name('coins.index');

    Route::post('/orders/spot', SpotOrderPlacementController::class)->name('orders.placement.spot');
    
    Route::get('/orders/book', OrderBookController::class)->name('orders.book');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');

    Route::get('/trades', [TradeController::class, 'index'])->name('trades.index');
});
