<?php

use App\Http\Controllers\V1\AuthController;
use App\Http\Controllers\V1\OrderPlacementController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1', 'middleware' => 'auth:sanctum'], function() {
    Route::post('/auth/token', [AuthController::class, 'token'])->withoutMiddleware('auth:sanctum')->name('auth.token');
    Route::get('/auth/whoami', [AuthController::class, 'whoami'])->name('user.whoami');

    Route::get('/coins', [\App\Http\Controllers\V1\CoinController::class, 'index'])->withoutMiddleware('auth:sanctum')->name('coins.index');

    Route::post('/orders', OrderPlacementController::class)->name('orders.placement');
});
