<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CanteenController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\MenuController;
use App\Http\Controllers\API\MenuOptionController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\PaymentController;
use App\Http\Controllers\API\QueueController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    // =====================================================
    // PUBLIC API
    // =====================================================

    // Authentication
    Route::post('/auth/register', [AuthController::class, 'register']);
    Route::post('/auth/login', [AuthController::class, 'login']);

    // Canteens
    Route::get('/canteens', [CanteenController::class, 'index']);
    Route::get('/canteens/{id}', [CanteenController::class, 'show']);

    // Categories
    Route::get('/categories', [CategoryController::class, 'index']);

    // Menus
    Route::get('/menus', [MenuController::class, 'index']);
    Route::get('/menus/{id}', [MenuController::class, 'show']);

    // Menu options
    Route::get('/menus/{menuId}/options', [
        MenuOptionController::class,
        'index'
    ]);


    // =====================================================
    // AUTHENTICATED API
    // =====================================================

    Route::middleware('auth:sanctum')->group(function () {

        // Authentication
        Route::post('/auth/logout', [AuthController::class, 'logout']);

        // Current user
        Route::get('/user', [AuthController::class, 'user']);

        // Orders
        Route::get('/orders', [OrderController::class, 'index']);
        Route::post('/orders', [OrderController::class, 'store']);
        Route::get('/orders/{id}', [OrderController::class, 'show']);

        Route::patch('/orders/{id}/status', [
            OrderController::class,
            'updateStatus'
        ]);

        // Payment
        Route::get('/orders/{orderId}/payment', [
            PaymentController::class,
            'show'
        ]);

        Route::post('/orders/{orderId}/payment', [
            PaymentController::class,
            'store'
        ]);

        // Queue
        Route::get('/orders/{orderId}/queue', [
            QueueController::class,
            'show'
        ]);
    });
});