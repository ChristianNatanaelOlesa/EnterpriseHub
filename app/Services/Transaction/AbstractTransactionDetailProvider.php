<?php

namespace App\Services\Transaction;

use App\Contracts\Transaction\TransactionDetailProvider;
use App\Models\Scopes\EmployeeVisibilityScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

abstract class AbstractTransactionDetailProvider implements TransactionDetailProvider
{
    /**
     * Eloquent model class used by the provider.
     */
    protected string $modelClass;

    /**
     * Relationships to eager load when resolving a transaction.
     * Providers can override this when the detail needs related data.
     */
    protected array $with = [];

    /**
     * Attributes that must never be exposed through the generic detail view.
     */
    protected array $hiddenFields = [
        'InputDate',
        'InputUser',
        'ModifDate',
        'ModifUser',
        'DeletedDate',
        'DeletedBy',
        'UserPassword',
        'Password',
        'QRAppCoc',
    ];

    public function resolve(string $transactionId): ?Model
    {
        /** @var class-string<Model> $modelClass */
        $modelClass = $this->modelClass;

        return $modelClass::query()
            ->when($this->with !== [], fn ($query) => $query->with($this->with))
            ->find($transactionId);
    }

    /**
     * Resolve a transaction specifically for an already-authorized workflow
     * participant. Only the main transaction query bypasses employee visibility.
     */
    public function resolveForWorkflow(string $transactionId): ?Model
    {
        /** @var class-string<Model> $modelClass */
        $modelClass = $this->modelClass;

        return $modelClass::query()
            ->withoutGlobalScope(EmployeeVisibilityScope::class)
            ->when($this->with !== [], fn ($query) => $query->with($this->with))
            ->find($transactionId);
    }

    public function sections(Model $transaction): array
    {
        $fields = [];

        foreach ($transaction->getAttributes() as $key => $value) {
            if (in_array($key, $this->hiddenFields, true)) {
                continue;
            }

            $fields[] = [
                'label' => Str::headline($key),
                'value' => $this->formatValue($transaction, $key, $value),
            ];
        }

        return [
            [
                'title' => 'Transaction Details',
                'fields' => $fields,
            ],
        ];
    }

    protected function formatValue(Model $transaction, string $key, mixed $value): mixed
    {
        if ($value === null || $value === '') {
            return '-';
        }

        if ($value instanceof \DateTimeInterface) {
            return $value->format('d M Y H:i');
        }

        if (is_bool($value)) {
            return $value ? 'Yes' : 'No';
        }

        if (is_scalar($value)) {
            return $value;
        }

        return json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?: '-';
    }
}
