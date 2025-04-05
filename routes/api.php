<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1', 'middleware' => 'auth:sanctum'], function() {
    Route::get('/whoami', fn (Request $request) => $request->user());

    Route::get('/coins', [\App\Http\Controllers\V1\CoinController::class, 'index'])->withoutMiddleware('auth:sanctum');
});
