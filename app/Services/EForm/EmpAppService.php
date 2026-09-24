<?php

namespace App\Services\EForm;

use App\Models\EForm\TrEmpApp;
use App\Models\EForm\TrEmpFormHist;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class EmpAppService
{
    public function getAll(?string $search = null, int $perPage = 10): LengthAwarePaginator
    {
        $query = TrEmpApp::query();

        if ($search !== null && trim($search) !== '') {
            $keyword = '%' . trim($search) . '%';

            $query->where(function ($q) use ($keyword) {
                $q->where('EmpAppID', 'like', $keyword)
                    ->orWhere('EmpFormID', 'like', $keyword)
                    ->orWhere('ReqDivID', 'like', $keyword)
                    ->orWhere('ReqUser', 'like', $keyword)
                    ->orWhere('ReqType', 'like', $keyword)
                    ->orWhere('Purpose', 'like', $keyword)
                    ->orWhere('UserLogin', 'like', $keyword)
                    ->orWhere('AccessType', 'like', $keyword)
                    ->orWhere('AppType', 'like', $keyword)
                    ->orWhere('AppName', 'like', $keyword)
                    ->orWhere('URL', 'like', $keyword)
                    ->orWhere('Notes', 'like', $keyword)
                    ->orWhere('Status', 'like', $keyword)
                    ->orWhere('CocID', 'like', $keyword)
                    ->orWhereRaw("DATE_FORMAT(ReqDate, '%Y-%m-%d') LIKE ?", [$keyword])
                    ->orWhereRaw("DATE_FORMAT(DateFrom, '%Y-%m-%d') LIKE ?", [$keyword])
                    ->orWhereRaw("DATE_FORMAT(DateUntil, '%Y-%m-%d') LIKE ?", [$keyword]);
            });
        }

        return $query
            ->with('empForm')
            ->orderByDesc('InputDate')
            ->orderByDesc('EmpAppID')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function find(string $id): ?TrEmpApp
    {
        return TrEmpApp::query()
            ->with('empForm')
            ->find($id);
    }

    public function currentEmployeeForm(): ?object
    {
        $empFormId = session('EmpFormID');

        if (!$empFormId) {
            return null;
        }

        return \App\Models\EForm\TrEmpForm::query()
            ->where('EmpFormID', $empFormId)
            ->first();
    }

    public function create(array $data): TrEmpApp
    {
        return DB::transaction(function () use ($data) {
            $empFormId = session('EmpFormID');

            if (!$empFormId) {
                throw ValidationException::withMessages([
                    'EmpFormID' => 'Session EmpFormID belum tersedia. Silakan login kembali.',
                ]);
            }

            $reqDivId = $this->getCurrentRequestDivisionId($empFormId);
            $username = $this->username();
            $now = now();
            $dateFrom = $data['DateFrom'];

            $data['EmpAppID'] = $this->generateId($dateFrom);
            $data['EmpFormID'] = $empFormId;
            $data['ReqDivID'] = $reqDivId;
            $data['ReqUser'] = $username;
            $data['ReqDate'] = $now->toDateString();

            $data['UserLogin'] = $this->defaultText($data['UserLogin'] ?? null);
            $data['UserPassword'] = $this->defaultText($data['UserPassword'] ?? null);
            $data['URL'] = $data['AppType'] === 'Website'
                ? $this->defaultText($data['URL'] ?? null)
                : '-';
            $data['Notes'] = $this->defaultText($data['Notes'] ?? null);

            $data['CocID'] = 'COC006';
            $data['IsConfirm'] = false;
            $data['QRAppCoc'] = '-';
            $data['IsGiven'] = false;
            $data['GivenDate'] = '1900-01-01';
            $data['GivenNote'] = '-';
            $data['IsTakeOut'] = false;
            $data['TakeOutDate'] = '1900-01-01';
            $data['TakeOutNote'] = '-';
            $data['Status'] = 'DRAFT';

            $data['InputDate'] = $now;
            $data['InputUser'] = $username;
            $data['ModifDate'] = $now;
            $data['ModifUser'] = $username;

            return TrEmpApp::query()->create($data);
        });
    }

    public function update(string $id, array $data): TrEmpApp
    {
        return DB::transaction(function () use ($id, $data) {
            $app = TrEmpApp::query()
                ->where('EmpAppID', $id)
                ->lockForUpdate()
                ->first();

            if (!$app) {
                throw ValidationException::withMessages([
                    'EmpAppID' => 'Employee Application data not found.',
                ]);
            }

            $username = $this->username();

            $data['ReqDivID'] = $this->getCurrentRequestDivisionId($app->EmpFormID);
            $data['UserLogin'] = $this->defaultText($data['UserLogin'] ?? null);
            $data['UserPassword'] = $this->defaultText($data['UserPassword'] ?? null);
            $data['URL'] = $data['AppType'] === 'Website'
                ? $this->defaultText($data['URL'] ?? null)
                : '-';
            $data['Notes'] = $this->defaultText($data['Notes'] ?? null);

            $data['ModifDate'] = now();
            $data['ModifUser'] = $username;

            // System fields are never taken from the form.
            unset(
                $data['EmpAppID'],
                $data['EmpFormID'],
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
                $data['InputDate'],
                $data['InputUser']
            );

            $app->update($data);

            return $app->fresh(['empForm']);
        });
    }

    public function delete(string $id): void
    {
        DB::transaction(function () use ($id) {
            $app = TrEmpApp::query()->find($id);

            if (!$app) {
                throw ValidationException::withMessages([
                    'EmpAppID' => 'Employee Application data not found.',
                ]);
            }

            $app->delete();
        });
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

    private function defaultText(?string $value): string
    {
        $value = trim((string) $value);

        return $value === '' ? '-' : $value;
    }

    private function generateId(string $dateFrom): string
    {
        $date = \Carbon\Carbon::parse($dateFrom);
        $prefix = 'EAP' . $date->format('Ym') . '-';

        $ids = TrEmpApp::query()
            ->where('EmpAppID', 'like', $prefix . '%')
            ->lockForUpdate()
            ->pluck('EmpAppID');

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
