<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdressController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ReviewController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('promotions', [PromotionController::class, 'index']);
Route::post('products', [ProductController::class, 'store']);
Route::get('products', [ProductController::class, 'index']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);
Route::get('/products/{product}/reviews', [ReviewController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
        Route::post('/products/{product}/reviews', [ReviewController::class, 'store']);
    Route::put('/reviews/{review}', [ReviewController::class, 'update']);
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy']);
    Route::post('favorites/{product}', [FavoriteController::class, 'toggle']);
    Route::get('favorites', [FavoriteController::class, 'index']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

// Route prefix for category admin
Route::prefix('admin')->middleware('auth:sanctum')->group(function () {
    Route::post('categories', [CategoriesController::class, 'store']);
    Route::get('categories', [CategoriesController::class, 'index']);
    Route::put('categories/{categories}', [CategoriesController::class, 'update']);
    Route::delete('categories/{categories}', [CategoriesController::class, 'destroy']);
    Route::post('promotions', [PromotionController::class, 'store']);
    Route::post('addresses', [AdressController::class, 'store']);
    Route::get('addresses', [AdressController::class, 'index']);
});