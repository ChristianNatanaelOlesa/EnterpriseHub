<?php

namespace App\Services\Transaction\Providers;

use App\Models\EForm\TrEmpITArea;
use App\Services\Transaction\AbstractTransactionDetailProvider;

class EmployeeITAreaDetailProvider extends AbstractTransactionDetailProvider
{
    protected string $modelClass = TrEmpITArea::class;

    protected array $with = [
        'empForm',
        'division',
    ];

    public function supports(string $module): bool
    {
        return $module === 'EMPLOYEE_IT_AREA';
    }
}
