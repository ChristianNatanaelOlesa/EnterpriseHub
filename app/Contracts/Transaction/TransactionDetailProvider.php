<?php

namespace App\Contracts\Transaction;

use Illuminate\Database\Eloquent\Model;

interface TransactionDetailProvider
{
    /**
     * Determine whether this provider handles the given workflow module.
     */
    public function supports(string $module): bool;

    /**
     * Resolve the underlying transaction for the workflow transaction ID.
     */
    public function resolve(string $transactionId): ?Model;

    /**
     * Return display-ready sections for the transaction detail UI.
     *
     * The workflow layer does not interpret these fields; it only passes them
     * to the transaction detail component.
     */
    public function sections(Model $transaction): array;
}
