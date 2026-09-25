<?php

namespace App\Services\EForm;

use App\Models\EForm\TrEmpForm;
use App\Models\EForm\TrEmpFormHist;
use App\Models\EForm\TrEmpNetwork;
use App\Repositories\EForm\EmpNetworkRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class EmpNetworkService
{
    public function __construct(protected EmpNetworkRepository $repository) {}

    public function getAll(?string $search = null, int $perPage = 10): LengthAwarePaginator
    {
        return $this->repository->getAll($search, $perPage);
    }

    public function find(string $id): ?TrEmpNetwork
    {
        return $this->repository->find($id);
    }

    public function currentRequestContext(): array
    {
        $empFormId = $this->currentEmpFormId();

        if (!$empFormId) {
            return [
                'empForm' => null,
                'reqDivId' => null,
            ];
        }

        $empForm = TrEmpForm::query()
            ->where('EmpFormID', $empFormId)
            ->first();

        return [
            'empForm' => $empForm,
            'reqDivId' => $this->getCurrentRequestDivisionId($empFormId),
        ];
    }

    public function create(array $data): TrEmpNetwork
    {
        return DB::transaction(function () use ($data) {
            $empFormId = $this->currentEmpFormId();

            if (!$empFormId) {
                throw ValidationException::withMessages([
                    'EmpFormID' => 'User login belum memiliki EmpFormID pada Sc_User.',
                ]);
            }

            $reqDivId = $this->getCurrentRequestDivisionId($empFormId);
            $username = $this->username();
            $now = now();
            $dateFrom = $data['DateFrom'];
            $reqType = $data['ReqType'];

            $data['EmpNetworkID'] = $this->generateId($dateFrom);
            $data['EmpFormID'] = $empFormId;
            $data['ReqDivID'] = $reqDivId;
            $data['ReqUser'] = $username;
            $data['ReqDate'] = $now->toDateString();
            $data['DateUntil'] = $reqType === 'Permanent'
                ? '1900-01-01'
                : $data['DateUntil'];

            $data['InternetAccess'] = (bool) ($data['InternetAccess'] ?? false);
            $data['WLANAccess'] = (bool) ($data['WLANAccess'] ?? false);
            $data['VPNAccess'] = (bool) ($data['VPNAccess'] ?? false);
            $data['Purpose'] = trim((string) ($data['Purpose'] ?? '')) ?: 'Kebutuhan Pekerjaan';
            $data['Notes'] = trim((string) ($data['Notes'] ?? '')) ?: '-';

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

            $data['InputUser'] = $username;
            $data['InputDate'] = $now;
            $data['ModifUser'] = $username;
            $data['ModifDate'] = $now;

            return $this->repository->create($data);
        });
    }

    public function update(string $id, array $data): TrEmpNetwork
    {
        return DB::transaction(function () use ($id, $data) {
            $network = $this->repository->find($id);

            if (!$network) {
                throw ValidationException::withMessages([
                    'EmpNetworkID' => 'Employee Network data not found.',
                ]);
            }

            $username = $this->username();
            $reqType = $data['ReqType'];

            $data['DateUntil'] = $reqType === 'Permanent'
                ? '1900-01-01'
                : $data['DateUntil'];

            $data['InternetAccess'] = (bool) ($data['InternetAccess'] ?? false);
            $data['WLANAccess'] = (bool) ($data['WLANAccess'] ?? false);
            $data['VPNAccess'] = (bool) ($data['VPNAccess'] ?? false);
            $data['Purpose'] = trim((string) ($data['Purpose'] ?? '')) ?: 'Kebutuhan Pekerjaan';
            $data['Notes'] = trim((string) ($data['Notes'] ?? '')) ?: '-';
            $data['ModifUser'] = $username;
            $data['ModifDate'] = now();

            unset(
                $data['EmpNetworkID'],
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
                $data['InputDate'],
                $data['ModifUser'],
                $data['ModifDate']
            );

            $data['ModifUser'] = $username;
            $data['ModifDate'] = now();

            if (!$this->repository->update($id, $data)) {
                throw ValidationException::withMessages([
                    'EmpNetworkID' => 'Failed to update Employee Network.',
                ]);
            }

            return $this->repository->find($id);
        });
    }

    public function delete(string $id): void
    {
        DB::transaction(function () use ($id) {
            if (!$this->repository->find($id)) {
                throw ValidationException::withMessages([
                    'EmpNetworkID' => 'Employee Network data not found.',
                ]);
            }

            $this->repository->delete($id);
        });
    }

    private function currentEmpFormId(): ?string
    {
        return Auth::user()?->EmpFormID
            ?: session('EmpFormID');
    }

    private function getCurrentRequestDivisionId(string $empFormId): string
    {
        $divisionId = TrEmpFormHist::query()
            ->where('EmpFormID', $empFormId)
            ->where('IsActive', true)
            ->whereNotNull('DivID')
            ->orderByDesc('EffectiveDate')
            ->orderByDesc('ReqDate')
            ->value('DivID');

        if ($divisionId === null) {
            throw ValidationException::withMessages([
                'ReqDivID' => 'Division aktif untuk EmpFormID user login tidak ditemukan pada Tr_EmpFormHist.',
            ]);
        }

        return (string) $divisionId;
    }

    private function username(): string
    {
        return (string) (
            session('username')
            ?: session('Username')
            ?: Auth::user()?->Username
            ?: Auth::user()?->username
            ?: Auth::user()?->email
            ?: 'Admin'
        );
    }

    private function generateId(string $dateFrom): string
    {
        $date = \Carbon\Carbon::parse($dateFrom);
        $prefix = 'ENW' . $date->format('Ym') . '-';

        $ids = TrEmpNetwork::query()
            ->where('EmpNetworkID', 'like', $prefix . '%')
            ->lockForUpdate()
            ->pluck('EmpNetworkID');

        $last = 0;

        foreach ($ids as $existing) {
            if (
                preg_match(
                    '/^' . preg_quote($prefix, '/') . '(\d{3})$/',
                    $existing,
                    $match
                )
            ) {
                $last = max($last, (int) $match[1]);
            }
        }

        return $prefix . str_pad((string) ($last + 1), 3, '0', STR_PAD_LEFT);
    }
}
