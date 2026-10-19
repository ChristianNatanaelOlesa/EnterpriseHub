<?php

namespace App\Services\Transaction\Providers;

use App\Models\EForm\TrEmpEquip;
use App\Services\Transaction\AbstractTransactionDetailProvider;

class EmployeeEquipmentDetailProvider extends AbstractTransactionDetailProvider
{
    protected string $modelClass = TrEmpEquip::class;

    protected array $with = [
        'empForm',
        'asset',
    ];

    public function supports(string $module): bool
    {
        return $module === 'EMPLOYEE_EQUIPMENT';
    }
}
