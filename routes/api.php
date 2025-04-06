<?php

use App\Http\Controllers\V1\AuthController;
use App\Http\Controllers\V1\CoinController;
use App\Http\Controllers\V1\SpotOrderPlacementController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1', 'middleware' => 'auth:sanctum'], function() {
    Route::post('/auth/token', [AuthController::class, 'token'])->withoutMiddleware('auth:sanctum')->name('auth.token');
    Route::get('/auth/whoami', [AuthController::class, 'whoami'])->name('auth.whoami');

    Route::get('/coins', [CoinController::class, 'index'])->withoutMiddleware('auth:sanctum')->name('coins.index');

    Route::post('/orders/spot', SpotOrderPlacementController::class)->name('orders.placement.spot');
});
