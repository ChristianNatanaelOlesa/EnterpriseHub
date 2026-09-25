<?php

namespace App\Services\EForm;

use App\Models\EForm\TrEmpInfra;
use App\Repositories\EForm\EmpInfraRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class EmpInfraService
{
    public function __construct(
        protected EmpInfraRepository $repository
    ) {
    }

    public function getAll(
        ?string $search = null,
        int $perPage = 10
    ): LengthAwarePaginator {
        return $this->repository->getAll(
            $search,
            $perPage
        );
    }

    public function find(string $id): ?TrEmpInfra
    {
        return $this->repository->find($id);
    }

    public function create(array $data): TrEmpInfra
    {
        return DB::transaction(function () use ($data) {
            $now = now();
            $user = $this->user();

            $data['EmpInfraID'] = $this->generateId(
                $data['DateFrom']
            );

            $data['ReqType'] = $data['ReqType'] ?? 'Permanent';
            $data['DateUntil'] = $data['DateUntil']
                ?? '1900-01-01';
            $data['AccessArea'] = 'Akun Windows';
            $data['Notes'] = filled($data['Notes'] ?? null)
                ? $data['Notes']
                : '-';
            $data['CocID'] = 'COC005';
            $data['IsConfirm'] = false;
            $data['QRAppCoc'] = '-';
            $data['IsGiven'] = false;
            $data['GivenDate'] = '1900-01-01';
            $data['GivenNote'] = '-';
            $data['IsTakeOut'] = false;
            $data['TakeOutDate'] = '1900-01-01';
            $data['TakeOutNote'] = '-';
            $data['Status'] = 'DRAFT';
            $data['InputUser'] = $user;
            $data['InputDate'] = $now;
            $data['ModifUser'] = $user;
            $data['ModifDate'] = $now;

            return $this->repository->create($data);
        });
    }

    public function update(
        string $id,
        array $data
    ): TrEmpInfra {
        return DB::transaction(function () use ($id, $data) {
            $existing = $this->repository->find($id);

            if (!$existing) {
                throw ValidationException::withMessages([
                    'EmpInfraID' =>
                        'Employee Infrastructure data not found.',
                ]);
            }

            $data['AccessArea'] = 'Akun Windows';
            $data['Notes'] = filled($data['Notes'] ?? null)
                ? $data['Notes']
                : '-';

            if ($data['ReqType'] === 'Permanent') {
                $data['DateUntil'] = '1900-01-01';
            }

            $data['ModifUser'] = $this->user();
            $data['ModifDate'] = now();

            unset(
                $data['EmpInfraID'],
                $data['EmpFormID'],
                $data['ReqDivID'],
                $data['ReqUser'],
                $data['ReqDate'],
                $data['CocID'],
                $data['IsConfirm'],
                $data['QRAppCoc'],
                $data['IsGiven'],
                $data['GivenDate'],
                $data['GivenNote'],
                $data['IsTakeOut'],
                $data['TakeOutDate'],
                $data['TakeOutNote'],
                $data['Status'],
                $data['InputUser'],
                $data['InputDate']
            );

            if (!$this->repository->update($id, $data)) {
                throw ValidationException::withMessages([
                    'EmpInfraID' =>
                        'Failed to update Employee Infrastructure.',
                ]);
            }

            $updated = $this->repository->find($id);

            if (!$updated) {
                throw ValidationException::withMessages([
                    'EmpInfraID' =>
                        'Updated data could not be retrieved.',
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
                    'EmpInfraID' =>
                        'Employee Infrastructure data not found.',
                ]);
            }

            $this->repository->delete($id);
        });
    }

    public function generateId(string $dateFrom): string
    {
        $prefix = 'EIN' . date('Ym', strtotime($dateFrom)) . '-';

        $ids = TrEmpInfra::query()
            ->where('EmpInfraID', 'like', $prefix . '%')
            ->lockForUpdate()
            ->pluck('EmpInfraID');

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

    private function user(): string
    {
        return Auth::user()?->Username
            ?? Auth::user()?->username
            ?? Auth::user()?->email
            ?? 'Admin';
    }
}
