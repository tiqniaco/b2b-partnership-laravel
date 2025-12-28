<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Iosbenfit\IosbenfitController;
use App\Http\Controllers\Admin\IosIncluded\IosIncludedController;
use App\Http\Controllers\Admin\ios\iosController;
use App\Http\Controllers\Admin\UserPackage\UserPackageController;
use App\Http\Controllers\Admin\Package\PackageController;
use App\Http\Controllers\Admin\MonthsPlan\MonthsPlanController;


Route::prefix('v1')->group(function () {    Route::apiResource('ios', iosController::class)->names('ios');
    Route::apiResource('ios_includeds', IosIncludedController::class)->names('ios_included');
    Route::apiResource('iosbenfits', IosbenfitController::class)->names('iosbenfit');
});
