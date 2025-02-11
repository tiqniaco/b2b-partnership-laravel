<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\ClientServiceController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\FavoriteProvidersController;
use App\Http\Controllers\GovernmentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\ProviderTypeController;
use App\Http\Controllers\SpecializationController;
use App\Http\Controllers\SubSpecializationController;
use App\Http\Controllers\PHPMailerController;
use App\Http\Controllers\ProviderPreviousWorksController;
use App\Http\Controllers\ProviderServiceController;
use App\Http\Controllers\ProviderServiceFeatureController;
use App\Http\Controllers\ProviderReviewsController;
use App\Http\Controllers\RequestServicesController;
use App\Http\Controllers\Store\StoreCartController;
use App\Http\Controllers\Store\StoreCategoryController;
use App\Http\Controllers\Store\StoreOrderController;
use App\Http\Controllers\Store\StoreProductController;
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
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::post('update-profile', [AuthController::class, 'updateProfile'])->middleware('auth:sanctum');
    Route::post('reset-password', [AuthController::class, 'resetPassword'])->middleware('auth:sanctum');
    Route::post('forget-password', [AuthController::class, 'forgetPassword']);
});

// Country Routes
Route::get('countries', [CountryController::class, 'index']);
Route::post('countries', [CountryController::class, 'store'])->middleware(['auth:sanctum']);
Route::get('countries/{id}', [CountryController::class, 'show']);
Route::post('countries/{id}/update', [CountryController::class, 'update'])->middleware(['auth:sanctum']);
Route::delete('countries/{id}', [CountryController::class, 'destroy'])->middleware(['auth:sanctum']);

// Government Routes
Route::apiResource('governments', GovernmentController::class);

// Provider Type Routes
Route::apiResource('provider-types', ProviderTypeController::class);

// Specialization Routes
Route::apiResource('specializations', SpecializationController::class);
Route::post('specializations/{id}/update', [SpecializationController::class, 'update']);
Route::post('specializations/providers', [SpecializationController::class, 'providers']);

// Sub Specialization Routes
Route::apiResource('sub-specializations', SubSpecializationController::class);
Route::post('sub-specializations/{id}/update', [SubSpecializationController::class, 'update']);

// Provider Routes
Route::apiResource('providers', ProviderController::class)->middleware(['auth:sanctum']);
Route::get('providers/{id}/services', [ProviderController::class, 'services'])->middleware(['auth:sanctum']);
Route::post('providers/{id}/update', [ProviderController::class, 'update'])->middleware(['auth:sanctum']);

// Provider Contacts
Route::apiResource('provider-contacts', \App\Http\Controllers\ProviderContactController::class);
Route::get('provider/{id}/contacts', [\App\Http\Controllers\ProviderContactController::class, 'providerContacts']);

// Provider Service
Route::apiResource('provider-service', ProviderServiceController::class);
Route::post('provider-service/{id}/update', [ProviderServiceController::class, 'update']);
Route::get("specializations/{id}/services", [ProviderServiceController::class, "specializationsServices"])->middleware(['auth:sanctum']);;

// Provider Service
Route::apiResource('client-service', ClientServiceController::class);
Route::post('client-service/{id}/update', [ClientServiceController::class, 'update']);

// Provider Service Features
Route::apiResource('provider-service-features', ProviderServiceFeatureController::class);

// Provider Service Reviews
Route::apiResource('provider-service-reviews', ProviderReviewsController::class);

// Provider Previous Works
Route::apiResource('provider-previous-works', ProviderPreviousWorksController::class);
Route::post("provider-previous-works/{id}/update", [ProviderPreviousWorksController::class, "update"]);

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
    Route::get('top-services', [HomeController::class, 'topServices']);
    Route::get('new-services', [HomeController::class, 'newServices']);
    Route::get('new-jobs', [HomeController::class, 'newJobs']);
    Route::get('top-providers', [HomeController::class, "topProviders"]);
    Route::get("countries-top-providers", [HomeController::class, "countriesProviders"]);
    Route::get("country/{id}/top-providers", [HomeController::class, 'countryTopProviders']);
});

// Favorites Services
Route::get('favorite-providers', [FavoriteProvidersController::class, 'index']);
Route::post('toggle-favorite', [FavoriteProvidersController::class, 'store']);

// Request Services
Route::apiResource('request-services', RequestServicesController::class)->middleware(['auth:sanctum']);
Route::post('request-services/{id}/update', [RequestServicesController::class, 'update'])->middleware(['auth:sanctum']);

// Request Offers
Route::apiResource('request-offers', \App\Http\Controllers\RequestOffersController::class)->middleware(['auth:sanctum']);
Route::patch('request-offers/{id}/update-status', [\App\Http\Controllers\RequestOffersController::class, 'changeOfferStatus'])->middleware(['auth:sanctum']);

// Clients
Route::apiResource('clients', ClientsController::class)->middleware(['auth:sanctum']);
Route::post('clients/{id}/update', [ClientsController::class, 'update'])->middleware(['auth:sanctum']);
Route::get('clients/{id}/services', [ClientsController::class, 'services'])->middleware(['auth:sanctum']);

/// Store Routes

Route::prefix("store")->group(function () {
    // Store Category routes
    Route::apiResource('categories', StoreCategoryController::class)->middleware(['auth:sanctum']);
    Route::post('categories/{id}/update', [StoreCategoryController::class, 'update'])->middleware(['auth:sanctum']);

    // Store Product routes
    Route::apiResource('products', StoreProductController::class)->middleware(['auth:sanctum']);
    Route::post('products/{id}/update', [StoreProductController::class, 'update'])->middleware(['auth:sanctum']);

    // Store Cart routes
    Route::apiResource('carts', StoreCartController::class)->middleware(['auth:sanctum']);

    // Store Orders routes
    Route::apiResource('orders', StoreOrderController::class)->middleware(['auth:sanctum']);
});