<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Models\User;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// auth
Route::post('/login', [AuthController::class, 'login'])->name('auth.login.store');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register.store');
Route::post('/refresh-token', [AuthController::class, 'refreshToken'])
    ->name('auth.refresh-token')->middleware('auth:sanctum');


Route::get('/users', function () {
    return response()->json(
        User::all()
    );
});


Route::get('/info', function () {
    return response()->json(
        [
            'version' => 'v1',
            'author' => 'Amrudin Balic',
            'description' => 'CRM Fitness application for managing clients, staff & scheduling.',
            'author_socials' => [
                'github' => 'github.com/amrudinbalich',
                'linkedin' => 'linkedin.com/amrudin-balich',
            ],
            'word' => 'Hello from developer :)'
        ]
    );
});

Route::get('/products', function () {
    return response()->json([
        [
            'id' => 44,
            'name' => 'Aorus 420G MK Motherboard',
            'description' => 'Asus motherboard, supports DDR5 context. AM6 Socket.',
            'price' => 244.49,
            'discount_price' => null,
            'group_id' => 2, // motherboards

        ]
    ]);
});


Route::post('/groups/{secretNum}', function ($secretNum) {
    $secret = 45;

    if($secretNum != $secret) {
        http_response_code(400);

        return response()->json([
            'message' => 'Wrong number.'
        ]);
    }

    return response()->json([
        'message' => 'Group created!'
    ]);
});