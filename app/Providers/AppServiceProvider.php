<?php

namespace App\Providers;

use App\Repositories\Iosbenfit\IosbenfitRepositoryInterface;
use App\Repositories\Iosbenfit\IosbenfitRepository;

use App\Repositories\IosIncluded\IosIncludedRepositoryInterface;
use App\Repositories\IosIncluded\IosIncludedRepository;

use App\Repositories\ios\iosRepositoryInterface;
use App\Repositories\ios\iosRepository;

use App\Repositories\UserPackage\UserPackageRepositoryInterface;
use App\Repositories\UserPackage\UserPackageRepository;

use App\Repositories\Package\PackageRepositoryInterface;
use App\Repositories\Package\PackageRepository;

use App\Repositories\MonthsPlan\MonthsPlanRepositoryInterface;
use App\Repositories\MonthsPlan\MonthsPlanRepository;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void {
//
        $this->app->bind(MonthsPlanRepositoryInterface::class, MonthsPlanRepository::class);
        $this->app->bind(PackageRepositoryInterface::class, PackageRepository::class);
        $this->app->bind(UserPackageRepositoryInterface::class, UserPackageRepository::class);
        $this->app->bind(iosRepositoryInterface::class, iosRepository::class);
        $this->app->bind(IosIncludedRepositoryInterface::class, IosIncludedRepository::class);
        $this->app->bind(IosbenfitRepositoryInterface::class, IosbenfitRepository::class);
}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
