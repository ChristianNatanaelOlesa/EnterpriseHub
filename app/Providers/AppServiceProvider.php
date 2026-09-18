<?php

namespace App\Providers;

use App\Interfaces\Master\ICompanyRepository;
use App\Repositories\Master\CompanyRepository;
use App\Support\Permission;
use Illuminate\Support\Facades\Blade;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

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
        Paginator::useBootstrapFive();

        Blade::if('canOpen', function (string $routeName) {
            return Permission::canOpen($routeName);
        });

        Blade::if('canAdd', function (string $routeName) {
            return Permission::canAdd($routeName);
        });

        Blade::if('canEdit', function (string $routeName) {
            return Permission::canEdit($routeName);
        });

        Blade::if('canDelete', function (string $routeName) {
            return Permission::canDelete($routeName);
        });

        Blade::if('canPrint', function (string $routeName) {
            return Permission::canPrint($routeName);
        });

        Blade::if('canExport', function (string $routeName) {
            return Permission::canExport($routeName);
        });

        Blade::if('canApprove', function (string $routeName) {
            return Permission::canApprove($routeName);
        });
    }
}
