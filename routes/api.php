<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\ClientServiceController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\FavoriteProvidersController;
use App\Http\Controllers\GovernmentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\ProviderTypeController;
use App\Http\Controllers\SpecializationController;
use App\Http\Controllers\Store\ProductDescriptionContentController;
use App\Http\Controllers\Store\ProductDescriptionTitleController;
use App\Http\Controllers\SubSpecializationController;
use App\Http\Controllers\PHPMailerController;
use App\Http\Controllers\PreviousWorkImageController;
use App\Http\Controllers\ProviderPreviousWorksController;
use App\Http\Controllers\ProviderServiceController;
use App\Http\Controllers\ProviderServiceFeatureController;
use App\Http\Controllers\ProviderReviewsController;
use App\Http\Controllers\RequestServicesController;
use App\Http\Controllers\Store\StoreCartController;
use App\Http\Controllers\Store\StoreCategoryController;
use App\Http\Controllers\Store\StoreOrderController;
use App\Http\Controllers\Store\StoreProductController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RequestOffersController;
use App\Http\Controllers\SavedJobController;
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
    Route::post('delete-account', [AuthController::class, 'deleteAccount'])->middleware('auth:sanctum');
    Route::post('get-verify-code', [AuthController::class, 'getVerifyCode']);
    Route::post('switch-provider-account', [AuthController::class, 'switchProviderAccount'])->middleware('auth:sanctum');
    Route::post('switch-client-account', [AuthController::class, 'switchClientAccount'])->middleware('auth:sanctum');
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
Route::apiResource('providers', ProviderController::class);
Route::get('providers/{id}/services', [ProviderController::class, 'services']);
Route::post('providers/{id}/update', [ProviderController::class, 'update'])->middleware(['auth:sanctum']);

// Provider Contacts
Route::apiResource('provider-contacts', \App\Http\Controllers\ProviderContactController::class);
Route::get('provider/{id}/contacts', [\App\Http\Controllers\ProviderContactController::class, 'providerContacts']);

// Provider Service
Route::apiResource('provider-service', ProviderServiceController::class);
Route::post('provider-service/{id}/update', [ProviderServiceController::class, 'update'])->middleware(['auth:sanctum']);
Route::get("specializations/{id}/services", [ProviderServiceController::class, "specializationsServices"]);

// Client Service
Route::apiResource('client-service', ClientServiceController::class)->middleware(['auth:sanctum']);
Route::post('client-service/{id}/update', [ClientServiceController::class, 'update'])->middleware(['auth:sanctum']);

// Provider Service Features
Route::apiResource('provider-service-features', ProviderServiceFeatureController::class);

// Provider Service Reviews
Route::apiResource('provider-service-reviews', ProviderReviewsController::class);

// Provider Previous Works
Route::apiResource('provider-previous-works', ProviderPreviousWorksController::class);
Route::post("provider-previous-works/{id}/update", [ProviderPreviousWorksController::class, "update"]);

// Previous Works images
Route::apiResource('previous-work-images', PreviousWorkImageController::class);
Route::post('previous-work-images/{id}/update', [PreviousWorkImageController::class, 'update'])->middleware(['auth:sanctum']);

// OTP
Route::post('send-otp', [PHPMailerController::class, 'sendOTP']);
Route::post('verify-otp', [PHPMailerController::class, 'verifyOTP']);

// Banners
Route::apiResource('banners', \App\Http\Controllers\BannerController::class);
Route::post('banners/{id}/update', [\App\Http\Controllers\BannerController::class, 'update']);

// Jobs
Route::apiResource('jobs', JobController::class);
Route::get('provider-jobs', [JobController::class, 'providerJobs'])->middleware(['auth:sanctum']);

// Job Applications
Route::post('job-application', [JobApplicationController::class, 'apply'])->middleware(['auth:sanctum']);
Route::get('client/job-application', [JobApplicationController::class, 'clientApplications'])->middleware(['auth:sanctum']);
Route::get('job-applications', [JobApplicationController::class, 'jobApplications'])->middleware(['auth:sanctum']);
Route::delete('job-applications/{id}', [JobApplicationController::class, 'destroy'])->middleware(['auth:sanctum']);
Route::post('job-applications/{id}/update-status', [JobApplicationController::class, 'updateStatus'])->middleware(['auth:sanctum']);
Route::get('job-applications/search', [JobApplicationController::class, 'searchJobApplication'])->middleware(['auth:sanctum']);


// Saved Jobs
Route::apiResource('saved-jobs', SavedJobController::class)->middleware(['auth:sanctum']);

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
Route::apiResource('request-offers', RequestOffersController::class)->middleware(['auth:sanctum']);
Route::patch('request-offers/{id}/accept-offer', [RequestOffersController::class, 'acceptOffer'])->middleware(['auth:sanctum']);
Route::post('user-offers', [RequestOffersController::class, 'userOffers'])->middleware(['auth:sanctum']);

// Clients
Route::apiResource('clients', ClientsController::class)->middleware(['auth:sanctum']);
Route::post('clients/{id}/update', [ClientsController::class, 'update'])->middleware(['auth:sanctum']);
Route::get('clients/{id}/services', [ClientsController::class, 'services'])->middleware(['auth:sanctum']);

/// Store Routes

Route::prefix("store")->group(function () {
    // Store Category routes
    Route::apiResource('categories', StoreCategoryController::class);
    Route::post('categories/{id}/update', [StoreCategoryController::class, 'update'])->middleware(['auth:sanctum']);

    // Store Product routes
    Route::apiResource('products', StoreProductController::class);
    Route::post('products/{id}/update', [StoreProductController::class, 'update'])->middleware(['auth:sanctum']);
    Route::get("top-selling-products", [StoreProductController::class, "topSelling"]);
    Route::apiResource('product-description-titles', ProductDescriptionTitleController::class);
    Route::apiResource('product-description-contents', ProductDescriptionContentController::class);

    // Store Cart routes
    Route::apiResource('carts', StoreCartController::class)->middleware(['auth:sanctum']);
    Route::post('cart/clear', [StoreCartController::class, 'clear'])->middleware(['auth:sanctum']);

    // Store Orders routes
    Route::apiResource('orders', StoreOrderController::class)->middleware(['auth:sanctum']);
    Route::get('admin-orders', [StoreOrderController::class, 'adminOrders'])->middleware(['auth:sanctum']);

    // Contact Us
    Route::get('contact-us', [\App\Http\Controllers\Store\ShopContactUsController::class, 'index']);
    Route::post('contact-us', [\App\Http\Controllers\Store\ShopContactUsController::class, 'store'])->middleware(['auth:sanctum']);
});

/// Complaint Routes
Route::apiResource('complaints', ComplaintController::class)->except("show")->middleware(['auth:sanctum']);
Route::get('complaints/users', [ComplaintController::class, "getComplaintsUsers"])->middleware();

// Notifications Routes
Route::post('send-notification', [NotificationController::class, 'store']);
Route::get('notifications', [NotificationController::class, 'index']);

// Admin Routes
Route::apiResource('admins', AdminController::class)->middleware(['auth:sanctum']);
Route::post('admins/{id}/update', [AdminController::class, 'update'])->middleware(['auth:sanctum']);
Route::get('admin/waiting-providers', [AdminController::class, 'waitingProviders'])->middleware(['auth:sanctum']);
Route::post('admin/accept-provider', [AdminController::class, 'acceptProvider'])->middleware(['auth:sanctum']);
Route::post('admin/reject-provider', [AdminController::class, 'rejectProvider'])->middleware(['auth:sanctum']);
