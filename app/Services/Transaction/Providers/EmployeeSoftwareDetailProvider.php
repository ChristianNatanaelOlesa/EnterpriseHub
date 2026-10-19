<?php

namespace App\Services\Transaction\Providers;

use App\Models\EForm\TrEmpSoftware;
use App\Services\Transaction\AbstractTransactionDetailProvider;

class EmployeeSoftwareDetailProvider extends AbstractTransactionDetailProvider
{
    protected string $modelClass = TrEmpSoftware::class;

    protected array $with = [
        'empForm',
        'division',
    ];

    public function supports(string $module): bool
    {
        return $module === 'EMPLOYEE_SOFTWARE';
    }
}
