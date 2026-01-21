<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;

// ------------------ Public Routes ------------------
// أي حد يقدر يشوف المنتجات والتصنيفات
Route::get('products', [ProductController::class, 'index']);
Route::get('products/{id}', [ProductController::class, 'show']);

Route::get('categories', [CategoryController::class, 'index']);
Route::get('categories/{id}', [CategoryController::class, 'show']);

// ------------------ Auth Routes ------------------
Route::post('/register', [AuthController::class, 'register']); // تسجيل المستخدم العادي
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

// ------------------ User Protected Routes ------------------
Route::middleware('auth:sanctum')->group(function () {
    // Cart
    Route::get('cart', [CartController::class, 'index']);
    Route::post('cart/add', [CartController::class, 'add']);
    Route::put('cart/update/{item_id}', [CartController::class, 'update']);
    Route::delete('cart/remove/{item_id}', [CartController::class, 'remove']);

    // Orders
    Route::post('/orders/create', [OrderController::class, 'createFromCart']); // تحويل السلة لطلب
    Route::get('/orders', [OrderController::class, 'index']);                    // الطلبات الخاصة بالمستخدم
    Route::get('/orders/{order_id}', [OrderController::class, 'show']);         // تفاصيل طلب معين
});

// ------------------ Admin Routes ------------------
Route::middleware(['auth:sanctum', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
    // Products Management
    Route::apiResource('admin/products', ProductController::class);

    // Categories Management
    Route::apiResource('admin/categories', CategoryController::class);

    // Orders Management (Dashboard View)
    Route::get('/admin/orders', [OrderController::class, 'adminIndex']);
    Route::get('/admin/orders/{order_id}', [OrderController::class, 'show']);
    Route::put('/admin/orders/{order_id}/status', [OrderController::class, 'updateStatus']);

});
