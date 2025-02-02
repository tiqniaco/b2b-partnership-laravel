<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientServiceController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\FavoriteServiceController;
use App\Http\Controllers\GovernmentController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\ProviderTypeController;
use App\Http\Controllers\SpecializationController;
use App\Http\Controllers\SubSpecializationController;
use App\Http\Controllers\PHPMailerController;
use App\Http\Controllers\ProviderServiceController;
use App\Http\Controllers\ProviderServiceFeatureController;
use App\Http\Controllers\ProviderServiceReviewController;
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
Route::post('specializations/{id}/update', [SpecializationController::class, 'update']);

// Sub Specialization Routes
Route::apiResource('sub-specializations', SubSpecializationController::class);
Route::post('sub-specializations/{id}/update', [SubSpecializationController::class, 'update']);

// Provider Routes
Route::apiResource('providers', ProviderController::class);

// Provider Service
Route::apiResource('provider-service', ProviderServiceController::class);
Route::post('provider-service/{id}/update', [ProviderServiceController::class, 'update']);

// Provider Service
Route::apiResource('client-service', ClientServiceController::class);
Route::post('client-service/{id}/update', [ClientServiceController::class, 'update']);

// Provider Service Features
Route::apiResource('provider-service-features', ProviderServiceFeatureController::class);

// Provider Service Reviews
Route::apiResource('provider-service-reviews', ProviderServiceReviewController::class);

// OTP
Route::post('send-otp', [PHPMailerController::class, 'sendOTP']);
Route::post('verify-otp', [PHPMailerController::class, 'verifyOTP']);

// Banners
Route::apiResource('banners', \App\Http\Controllers\BannerController::class);
Route::post('banners/{id}/update', [\App\Http\Controllers\BannerController::class, 'update']);

// Jobs
Route::apiResource('jobs', \App\Http\Controllers\JobsController::class);
Route::post('jobs/{id}/update', [\App\Http\Controllers\JobsController::class, 'update']);

// Home Slider
Route::prefix('home')->group(function () {
    Route::get('top-services', [\App\Http\Controllers\HomeController::class, 'topServices']);
    Route::get('new-services', [\App\Http\Controllers\HomeController::class, 'newServices']);
    Route::get('new-jobs', [\App\Http\Controllers\HomeController::class, 'newJobs']);
});

// Favorites Services
Route::get('favorite-services', [FavoriteServiceController::class, 'index']);
Route::post('toggle-favorite', [FavoriteServiceController::class, 'store']);
