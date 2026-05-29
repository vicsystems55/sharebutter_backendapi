<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AttendeeProfileController;
use App\Http\Controllers\OrganizerProfileController;
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


Route::get('/categories', [CategoryController::class, 'index']);




Route::get('/events', [EventController::class, 'index']);
Route::get('/events/{event:slug}', [EventController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/events', [EventController::class, 'store']);
});

Route::get('/my-events', [EventController::class, 'myEvents'])->middleware('auth:sanctum');


Route::middleware(['auth:sanctum'])
    ->prefix('admin')
    ->group(function () {
        Route::get('/events', [EventController::class, 'adminIndex']);
        Route::get('/events/{event}', [EventController::class, 'adminShow']);

        Route::post('/events/{event}/certify', [EventController::class, 'certify']);
        Route::post('/events/{event}/publish', [EventController::class, 'publish']);
        Route::post('/events/{event}/reject', [EventController::class, 'reject']);
        Route::post('/events/{event}/suspend', [EventController::class, 'suspend']);
         Route::get('/organizers', [OrganizerProfileController::class, 'adminIndex']);
        Route::post('/organizers/{organizerProfile}/approve', [OrganizerProfileController::class, 'approve']);
        Route::post('/organizers/{organizerProfile}/reject', [OrganizerProfileController::class, 'reject']);
    });




Route::get('/attendee-onboarding/options', [AttendeeProfileController::class, 'options']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/attendee-profile', [AttendeeProfileController::class, 'show']);
    Route::post('/attendee-profile', [AttendeeProfileController::class, 'store']);
});



Route::get('/organizer-onboarding/options', [OrganizerProfileController::class, 'options']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/organizer-profile', [OrganizerProfileController::class, 'show']);
    Route::post('/organizer-profile', [OrganizerProfileController::class, 'store']);
});
