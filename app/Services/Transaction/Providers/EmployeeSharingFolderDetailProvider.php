<?php

namespace App\Services\Transaction\Providers;

use App\Models\EForm\TrEmpSharingFolder;
use App\Services\Transaction\AbstractTransactionDetailProvider;

class EmployeeSharingFolderDetailProvider extends AbstractTransactionDetailProvider
{
    protected string $modelClass = TrEmpSharingFolder::class;

    protected array $with = [
        'empForm',
        'division',
        'details',
    ];

    public function supports(string $module): bool
    {
        return $module === 'EMPLOYEE_SHARING_FOLDER';
    }
}
