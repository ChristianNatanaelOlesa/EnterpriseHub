<?php

namespace App\Services\Transaction\Providers;

use App\Models\EForm\TrEmpEmail;
use App\Services\Transaction\AbstractTransactionDetailProvider;

class EmployeeEmailDetailProvider extends AbstractTransactionDetailProvider
{
    protected string $modelClass = TrEmpEmail::class;

    protected array $with = [
        'empForm',
    ];

    public function supports(string $module): bool
    {
        return $module === 'EMPLOYEE_EMAIL';
    }
}
