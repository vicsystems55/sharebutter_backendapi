<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Example API route
Route::get('/hello', function () {
    return response()->json(['message' => 'Hello from API!']);
});

// Add your API routes below

// Authentication routes
Route::post('/register', [App\Http\Controllers\ApiAuthController::class, 'register']);
Route::post('/login', [App\Http\Controllers\ApiAuthController::class, 'login']);
Route::post('/forgot-password', [App\Http\Controllers\ApiAuthController::class, 'forgotPassword']);
Route::post('/verify-otp', [App\Http\Controllers\ApiAuthController::class, 'verifyOtp']);
Route::post('/logout', [App\Http\Controllers\ApiAuthController::class, 'logout'])->middleware('auth:sanctum');
