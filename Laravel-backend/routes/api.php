<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PreorderController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::get('site-configs', function () {
    return response()->json(
        [
            'recaptchaStatus' => recaptchaStatus()
        ],
        200
    );
});


Route::controller(PreorderController::class)->prefix("preorder")->name("preorder.")->group(function () {
    Route::get('products', 'products')->name('products');
    Route::middleware(['throttle:preorder'])->post('store', 'store')->name('store');
});


Route::post('/login', [AuthController::class, 'login']);


Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/preorders', [UserController::class, 'preorders']);
    Route::post('/preorders/{id}/delete', [UserController::class, 'softDelete']);

    Route::get('/preorders/trashed', [UserController::class, 'trash']);
    Route::post('/preorders/trashed/{id}/restore', [UserController::class, 'restore']);

    Route::post('/logout', [AuthController::class, 'logout']);
});
