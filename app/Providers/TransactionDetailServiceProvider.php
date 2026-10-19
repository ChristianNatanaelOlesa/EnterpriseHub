<?php

namespace App\Providers;

use App\Services\Transaction\Providers\EmployeeApplicationDetailProvider;
use App\Services\Transaction\Providers\EmployeeEmailDetailProvider;
use App\Services\Transaction\Providers\EmployeeEquipmentDetailProvider;
use App\Services\Transaction\Providers\EmployeeInfraDetailProvider;
use App\Services\Transaction\Providers\EmployeeITAreaDetailProvider;
use App\Services\Transaction\Providers\EmployeeNetworkDetailProvider;
use App\Services\Transaction\Providers\EmployeeSharingFolderDetailProvider;
use App\Services\Transaction\Providers\EmployeeSoftwareDetailProvider;
use App\Services\Transaction\TransactionDetailRegistry;
use Illuminate\Support\ServiceProvider;

class TransactionDetailServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->tag([
            EmployeeEquipmentDetailProvider::class,
            EmployeeSoftwareDetailProvider::class,
            EmployeeITAreaDetailProvider::class,
            EmployeeInfraDetailProvider::class,
            EmployeeSharingFolderDetailProvider::class,
            EmployeeNetworkDetailProvider::class,
            EmployeeEmailDetailProvider::class,
            EmployeeApplicationDetailProvider::class,
        ], 'transaction.detail.providers');

        $this->app->singleton(TransactionDetailRegistry::class, function ($app) {
            return new TransactionDetailRegistry(
                $app->tagged('transaction.detail.providers')
            );
        });
    }
}
