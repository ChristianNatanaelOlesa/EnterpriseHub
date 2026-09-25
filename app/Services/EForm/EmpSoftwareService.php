<?php

namespace App\Services\EForm;

use App\Models\EForm\TrEmpFormHist;
use App\Models\EForm\TrEmpSoftware;
use App\Repositories\EForm\EmpSoftwareRepository;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class EmpSoftwareService
{
    public function __construct(
        protected EmpSoftwareRepository $repository
    ) {
    }

    public function getAll(
        ?string $search = null,
        int $perPage = 10
    ): LengthAwarePaginator {
        return $this->repository->getAll($search, $perPage);
    }

    public function find(string $id): ?TrEmpSoftware
    {
        return $this->repository->find($id);
    }

    private function user(): string
    {
        return Auth::user()?->Username
            ?? Auth::user()?->username
            ?? Auth::user()?->email
            ?? 'Admin';
    }

    private function employeeContext(): array
    {
        $user = Auth::user();
        $empFormID = $user?->EmpFormID;

        if (!$empFormID) {
            throw ValidationException::withMessages([
                'EmpFormID' => 'Employee Form ID for the logged-in user was not found.',
            ]);
        }

        $history = TrEmpFormHist::query()
            ->where('EmpFormID', $empFormID)
            ->orderByDesc('InputDate')
            ->first();

        if (!$history?->DivID) {
            throw ValidationException::withMessages([
                'ReqDivID' => 'Division for the logged-in user was not found.',
            ]);
        }

        return [
            'EmpFormID' => $empFormID,
            'ReqDivID' => $history->DivID,
            'ReqUser' => $this->user(),
        ];
    }

    public function createForUser(array $data): TrEmpSoftware
    {
        return DB::transaction(function () use ($data) {
            $context = $this->employeeContext();
            $now = now();
            $dateFrom = Carbon::createFromFormat(
                'Y-m-d',
                $data['DateFrom']
            );

            $data = array_merge($data, $context);
            $data['EmpSoftwareID'] = $this->generateId($dateFrom);
            $data['ReqDate'] = $now->toDateString();
            $data['DateUntil'] = $data['ReqType'] === 'Permanent'
                ? '1900-01-01'
                : $data['DateUntil'];
            $data['Notes'] = trim((string) ($data['Notes'] ?? '')) ?: '-';
            $data['CocID'] = 'COC004';
            $data['IsConfirm'] = false;
            $data['QRAppCoc'] = '-';
            $data['IsGiven'] = false;
            $data['GivenDate'] = '1900-01-01';
            $data['GivenNote'] = '-';
            $data['IsTakeOut'] = false;
            $data['TakeOutDate'] = '1900-01-01';
            $data['TakeOutNote'] = '-';
            $data['Status'] = 'DRAFT';
            $data['InputUser'] = $this->user();
            $data['InputDate'] = $now;
            $data['ModifUser'] = $this->user();
            $data['ModifDate'] = $now;

            return $this->repository->create($data);
        });
    }

    public function update(string $id, array $data): TrEmpSoftware
    {
        return DB::transaction(function () use ($id, $data) {
            $existing = $this->repository->find($id);

            if (!$existing) {
                throw ValidationException::withMessages([
                    'EmpSoftwareID' => 'Employee Software data not found.',
                ]);
            }

            $data['DateUntil'] = $data['ReqType'] === 'Permanent'
                ? '1900-01-01'
                : $data['DateUntil'];
            $data['Notes'] = trim((string) ($data['Notes'] ?? '')) ?: '-';
            $data['ModifDate'] = now();
            $data['ModifUser'] = $this->user();

            if (!$this->repository->update($id, $data)) {
                throw ValidationException::withMessages([
                    'EmpSoftwareID' => 'Failed to update Employee Software.',
                ]);
            }

            $updated = $this->repository->find($id);

            if (!$updated) {
                throw ValidationException::withMessages([
                    'EmpSoftwareID' => 'Updated data could not be retrieved.',
                ]);
            }

            return $updated;
        });
    }

    public function delete(string $id): void
    {
        DB::transaction(function () use ($id) {
            if (!$this->repository->find($id)) {
                throw ValidationException::withMessages([
                    'EmpSoftwareID' => 'Employee Software data not found.',
                ]);
            }

            $this->repository->delete($id);
        });
    }

    public function generateId(Carbon $dateFrom): string
    {
        $prefix = 'ESO' . $dateFrom->format('Ym') . '-';

        $ids = TrEmpSoftware::query()
            ->where('EmpSoftwareID', 'like', $prefix . '%')
            ->lockForUpdate()
            ->pluck('EmpSoftwareID');

        $last = 0;

        foreach ($ids as $existing) {
            if (
                preg_match(
                    '/^' . preg_quote($prefix, '/') . '([0-9]{3})$/',
                    $existing,
                    $matches
                )
            ) {
                $last = max(
                    $last,
                    (int) $matches[1]
                );
            }
        }

        return $prefix . str_pad(
            (string) ($last + 1),
            3,
            '0',
            STR_PAD_LEFT
        );
    }
}
