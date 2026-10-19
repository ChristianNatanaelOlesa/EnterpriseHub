<?php

namespace App\Services\Transaction\Providers;

use App\Models\EForm\TrEmpApp;
use App\Services\Transaction\AbstractTransactionDetailProvider;

class EmployeeApplicationDetailProvider extends AbstractTransactionDetailProvider
{
    protected string $modelClass = TrEmpApp::class;

    protected array $with = [
        'empForm',
    ];

    public function supports(string $module): bool
    {
        return in_array($module, [
            'EMPLOYEE_APPLICATION_EXTERNAL',
            'EMPLOYEE_APPLICATION_INTERNAL',
        ], true);
    }
}
