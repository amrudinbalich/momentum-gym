<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// auth
Route::post('/login', [AuthController::class, 'login'])->name('auth.login.store');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register.store');
Route::post('/refresh-token', [AuthController::class, 'refreshToken'])
    ->name('auth.refresh-token')->middleware('auth:sanctum');


// Public Browsing Routes (No Auth Required)
Route::prefix('v1')->group(function () {
    
    // Products Endpoints
    Route::get('/products', [ProductController::class, 'index']);          // List/Filter products
    Route::get('/products/{product:sku}', [ProductController::class, 'show']); // Fetch single product by SKU

    // Categories Endpoints
    Route::get('/categories', [CategoryController::class, 'index']);       // List categories
    Route::get('/categories/{category:slug}', [CategoryController::class, 'show']); // Get products by category slug

    // Brands Endpoints
    Route::get('/brands', [BrandController::class, 'index']);             // List brands
    Route::get('/brands/{brand:slug}', [BrandController::class, 'show']); // Get products by brand slug

});

// Protected Administrative Routes (Requires Sanctum/Auth)
Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    
    // Write operations for Products
    Route::post('/products', [ProductController::class, 'store']);         // Create product
    Route::put('/products/{product}', [ProductController::class, 'update']); // Update product
    Route::delete('/products/{product}', [ProductController::class, 'destroy']); // Delete product

    // Write operations for Categories
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::put('/categories/{category}', [CategoryController::class, 'update']);
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);

    // Write operations for Brands
    Route::post('/brands', [BrandController::class, 'store']);
    Route::put('/brands/{brand}', [BrandController::class, 'update']);
    Route::delete('/brands/{brand}', [BrandController::class, 'destroy']);
    
});