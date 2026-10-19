<?php

namespace App\Services\Transaction\Providers;

use App\Models\EForm\TrEmpNetwork;
use App\Services\Transaction\AbstractTransactionDetailProvider;

class EmployeeNetworkDetailProvider extends AbstractTransactionDetailProvider
{
    protected string $modelClass = TrEmpNetwork::class;

    protected array $with = [
        'empForm',
        'division',
    ];

    public function supports(string $module): bool
    {
        return $module === 'EMPLOYEE_NETWORK';
    }
}
