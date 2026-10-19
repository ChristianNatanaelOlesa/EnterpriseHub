<?php

namespace App\Providers;

use App\Interfaces\Master\ICompanyRepository;
use App\Repositories\Master\CompanyRepository;
use App\Support\Permission;
use App\Models\Workflow\WfInstanceStep;
use App\Enums\WorkflowStatus;
use Illuminate\Support\Facades\View;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            ICompanyRepository::class,
            CompanyRepository::class
        );
    }

    public function boot(): void
    {
        Blueprint::macro('auditColumns', function () {
            $this->dateTime('InputDate')->useCurrent();
            $this->string('InputUser', 50)->default('Admin');

            $this->dateTime('ModifDate')->useCurrent();
            $this->string('ModifUser', 50)->default('Admin');

            $this->string('DeletedBy', 50)->nullable();
            $this->dateTime('DeletedDate')->nullable();
        });

        Paginator::useBootstrapFive();

        Blade::if('canOpen', fn (string $routeName) => Permission::canOpen($routeName));
        Blade::if('canAdd', fn (string $routeName) => Permission::canAdd($routeName));
        Blade::if('canEdit', fn (string $routeName) => Permission::canEdit($routeName));
        Blade::if('canDelete', fn (string $routeName) => Permission::canDelete($routeName));
        Blade::if('canPrint', fn (string $routeName) => Permission::canPrint($routeName));
        Blade::if('canExport', fn (string $routeName) => Permission::canExport($routeName));
        Blade::if('canApprove', fn (string $routeName) => Permission::canApprove($routeName));
        Blade::if('canPermission', fn (string $permission, string $routeName) => Permission::can($permission, $routeName));

        View::composer('layouts.navbar', function ($view) {
            $pendingApprovalCount = 0;

            if (auth()->check()) {
                $pendingApprovalCount = WfInstanceStep::query()
                    ->where('Status', 'ACTIVE')
                    ->where('ApproverUserID', (int) auth()->user()->UserID)
                    ->whereHas('instance', function ($query) {
                        $query->where('Status', WorkflowStatus::WAITING_APPROVAL->value);
                    })
                    ->count();
            }

            $view->with('pendingApprovalCount', $pendingApprovalCount);
        });
    }
}
