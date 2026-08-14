<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Support\BlueprintMacros;
use App\Interfaces\Master\ICompanyRepository;
use App\Repositories\Master\CompanyRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            ICompanyRepository::class,
            CompanyRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        BlueprintMacros::register();
    }
}
