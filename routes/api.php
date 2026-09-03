<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\OrderApiController;
use App\Http\Controllers\Api\CustomerAuthController;
use App\Http\Controllers\Api\PageApiController;

Route::get('/home', [HomeController::class, 'index']);
Route::get('/pages/{key}', [PageApiController::class, 'show']);
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/mega-menu', [CategoryController::class, 'megaMenu']);

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{slug_or_id}', [ProductController::class, 'show']);

Route::get('/news', [NewsController::class, 'index']);
Route::get('/news/{slug_or_id}', [NewsController::class, 'show']);

Route::get('/projects', [ProjectController::class, 'index']);
Route::get('/projects/{slug_or_id}', [ProjectController::class, 'show']);

Route::get('/services', [ServiceController::class, 'index']);
Route::get('/services/{slug_or_id}', [ServiceController::class, 'show']);

Route::post('/orders', [OrderApiController::class, 'store']);

// Customer Auth Routes
Route::post('/customer/register', [CustomerAuthController::class, 'register']);
Route::post('/customer/verify-email', [CustomerAuthController::class, 'verifyRegistration']);
Route::post('/customer/resend-code', [CustomerAuthController::class, 'resendVerificationCode']);
Route::post('/customer/login', [CustomerAuthController::class, 'login']);
Route::post('/customer/forgot-password', [CustomerAuthController::class, 'forgotPassword']);
Route::post('/customer/verify-otp', [CustomerAuthController::class, 'verifyOtp']);
Route::post('/customer/reset-password', [CustomerAuthController::class, 'resetPassword']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/customer/me', [CustomerAuthController::class, 'me']);
    Route::post('/customer/logout', [CustomerAuthController::class, 'logout']);
});


