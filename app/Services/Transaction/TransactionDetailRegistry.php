<?php

namespace App\Services\Transaction;

use App\Contracts\Transaction\TransactionDetailProvider;

class TransactionDetailRegistry
{
    /**
     * @param iterable<TransactionDetailProvider> $providers
     */
    public function __construct(
        protected iterable $providers,
    ) {
    }

    public function provider(string $module): ?TransactionDetailProvider
    {
        foreach ($this->providers as $provider) {
            if ($provider->supports($module)) {
                return $provider;
            }
        }

        return null;
    }

    public function resolve(string $module, string $transactionId): mixed
    {
        return $this->provider($module)?->resolve($transactionId);
    }

    /**
 * Resolve a transaction for an authorized workflow participant.
 */
    public function resolveForWorkflow(
        string $module,
        string $transactionId
    ): mixed {
        $provider = $this->provider($module);

        if (!$provider) {
            return null;
        }

        if ($provider instanceof AbstractTransactionDetailProvider) {
            return $provider->resolveForWorkflow($transactionId);
        }

        // Fail closed for providers without an explicit workflow resolver.
        return null;
    }

    /**
     * Build detail sections for an authorized workflow participant.
     */
    public function sectionsForWorkflow(
        string $module,
        string $transactionId
    ): array {
        $provider = $this->provider($module);

        if (!$provider instanceof AbstractTransactionDetailProvider) {
            return [];
        }

        $transaction = $provider->resolveForWorkflow($transactionId);

        return $transaction
            ? $provider->sections($transaction)
            : [];
    }

    public function sections(string $module, string $transactionId): array
    {
        $provider = $this->provider($module);

        if (!$provider) {
            return [];
        }

        $transaction = $provider->resolve($transactionId);

        return $transaction ? $provider->sections($transaction) : [];
    }
}
