<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientServiceController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\GovernmentController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\ProviderTypeController;
use App\Http\Controllers\SpecializationController;
use App\Http\Controllers\SubSpecializationController;
use App\Http\Controllers\PHPMailerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/// Auth Routes
Route::prefix("auth")->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('update-profile', [AuthController::class, 'updateProfile']);
    Route::post('reset-password', [AuthController::class, 'resetPassword']);
    Route::post('forget-password', [AuthController::class, 'forgetPassword']);
});

// Country Routes
Route::apiResource('countries', CountryController::class);
Route::post('countries/{id}/update', [CountryController::class, 'update']);

// Government Routes
Route::apiResource('governments', GovernmentController::class);

// Provider Type Routes
Route::apiResource('provider-types', ProviderTypeController::class);

// Specialization Routes
Route::apiResource('specializations', SpecializationController::class);

// Sub Specialization Routes
Route::apiResource('sub-specializations', SubSpecializationController::class);

// Provider Routes
Route::apiResource('providers', ProviderController::class);

// Client Service
Route::apiResource('client-service', ClientServiceController::class);
Route::post('client-service/{id}/update', [ClientServiceController::class, 'update']);

// OTP
Route::post('send-otp', [PHPMailerController::class, 'sendOTP']);
Route::post('verify-otp', [PHPMailerController::class, 'verifyOTP']);