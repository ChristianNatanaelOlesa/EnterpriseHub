<?php

namespace App\Services\EForm;

use App\Models\EForm\TrEmpEmail;
use App\Models\EForm\TrEmpForm;
use App\Models\EForm\TrEmpFormHist;
use App\Models\Security\ScUser;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use RuntimeException;

class EmpEmailService
{
    public function __construct(
        protected \App\Repositories\EForm\EmpEmailRepository $repository
    ) {
    }

    /**
     * Get Employee Email list.
     */
    public function getAll(?string $search = null): LengthAwarePaginator
    {
        return $this->repository->getAll($search, 10);
    }

    /**
     * Find Employee Email by ID.
     */
    public function find(string $id): TrEmpEmail
    {
        return $this->repository->find($id) ?? abort(404);
    }

    /**
     * Get Employee Form of currently logged-in user.
     */
    public function currentEmployeeForm(): ?TrEmpForm
    {
        $user = Auth::user();

        $empFormId = $user?->EmpFormID;

        return $empFormId
            ? TrEmpForm::query()
                ->where('EmpFormID', $empFormId)
                ->first()
            : null;
    }

    /**
     * Get Corporate Email based on Division
     * of the currently logged-in Employee Form.
     */
    public function getCorporateEmailGroups(): Collection
    {
        $user = Auth::user();

        $empFormId = session('EmpFormID');

        if (!$empFormId) {
            return collect();
        }

        /*
         * Division user diambil dari Employee Form History.
         *
         * EmpFormID
         *      ↓
         * Tr_EmpFormHist
         *      ↓
         * DivID
         *      ↓
         * ms_email_group.DivisionID
         */
        $divisionIds = TrEmpFormHist::query()
            ->where('EmpFormID', $empFormId)
            ->where('IsActive', true)
            ->whereNotNull('DivID')
            ->pluck('DivID')
            ->map(fn ($id) => (int) $id)
            ->filter(fn ($id) => $id > 0)
            ->unique()
            ->values();

        if ($divisionIds->isEmpty()) {
            return collect();
        }

        return DB::table('ms_email_group as eg')
            ->whereIn('eg.DivisionID', $divisionIds->all())
            ->where('eg.IsActive', true)
            ->whereNull('eg.DeletedDate')
            ->select([
                'eg.EmailGroupID',
                'eg.Email',
                'eg.Description',
                'eg.DivisionID',
            ])
            ->orderBy('eg.Email')
            ->distinct()
            ->get();
    }

    /**
     * Create Employee Email request.
     *
     * Semua data Employee Email disimpan langsung
     * ke Tr_EmpEmail.
     */
    public function createStandalone(
        array $data,
        ScUser $user
    ): TrEmpEmail {
        return DB::transaction(function () use ($data, $user) {

            $empFormId = session('EmpFormID');

            /*
             * User harus memiliki EmpFormID.
             */
            if (!$empFormId) {
                throw new RuntimeException(
                    'User login belum terhubung ke Employee Form (EmpFormID).'
                );
            }

            /*
             * Pastikan Employee Form benar-benar ada.
             */
            if (!TrEmpForm::query()
                ->where('EmpFormID', $empFormId)
                ->exists()
            ) {
                throw new RuntimeException(
                    'EmpFormID user login tidak ditemukan pada Employee Form.'
                );
            }

            /*
             * Personal:
             *
             * Email belum ditentukan oleh user.
             * Email akan diisi oleh IT Infra pada proses approval.
             */
            $email = $data['EmailType'] === 'Personal'
                ? 'Fill by IT Infra'
                : trim($data['Email']);

            /*
             * Corporate:
             * Pastikan email yang dipilih memang tersedia
             * untuk Division user.
             */
            $this->validateCorporateEmail(
                $data['EmailType'],
                $email
            );

            $reqDivId = $this->getCurrentRequestDivisionId($empFormId);

            $now = now();

            /*
             * Generate EmpEmailID.
             */
            $id = $this->generateId();

            /*
             * Username yang melakukan request/input.
             */
            $inputUser = $user->Username;

            /*
             * Simpan seluruh data request langsung
             * ke Tr_EmpEmail.
             */
            $model = TrEmpEmail::create([
                'EmpEmailID' => $id,
                'EmpFormID' => $empFormId,
                'ReqDivID' => $reqDivId,

                // Request information.
                'ReqUser' => $inputUser,
                'ReqDate' => $now,
                'ReqType' => $data['ReqType'],

                'EmailType' => $data['EmailType'],
                'Email' => $email,

                'Purpose' => $data['Purpose'],
                'DateFrom' => $data['DateFrom'],
                'DateUntil' => $data['DateUntil'],
                'Notes' => $this->defaultText($data['Notes'] ?? null),

                // Employee request workflow defaults.
                'CocID' => 'COC003',
                'IsConfirm' => false,
                'QRAppCoc' => '-',
                'IsGiven' => false,
                'GivenDate' => '1900-01-01',
                'GivenNote' => '-',
                'IsTakeOut' => false,
                'TakeOutDate' => '1900-01-01',
                'TakeOutNote' => '-',
                'Status' => 'DRAFT',

                // Audit.
                'InputUser' => $inputUser,
                'InputDate' => $now,
                'ModifUser' => $inputUser,
                'ModifDate' => $now,
            ]);

            /*
             * Tidak ada Tr_EmpEmailDetail.
             */
            return $model->fresh([
                'empForm',
            ]);
        });
    }

    /**
     * Update Employee Email request.
     *
     * Semua data diupdate langsung ke Tr_EmpEmail.
     */
    public function updateStandalone(
        string $id,
        array $data,
        ScUser $user
    ): TrEmpEmail {
        return DB::transaction(function () use ($id, $data, $user) {

            $email = TrEmpEmail::query()
                ->where('EmpEmailID', $id)
                ->lockForUpdate()
                ->firstOrFail();

            /*
             * Personal:
             * User tidak boleh mengganti email.
             * Tetap Fill by IT Infra sampai proses approval
             * nanti dikerjakan.
             */
            $emailAddress = $data['EmailType'] === 'Personal'
                ? 'Fill by IT Infra'
                : trim($data['Email']);

            /*
             * Validasi Corporate Email.
             */
            $this->validateCorporateEmail(
                $data['EmailType'],
                $emailAddress
            );

            $empFormId = session('EmpFormID');

            if (!$empFormId) {
                throw new RuntimeException(
                    'Session EmpFormID belum tersedia. Silakan login kembali.'
                );
            }

            $reqDivId = $this->getCurrentRequestDivisionId($empFormId);

            $now = now();

            /*
             * Update seluruh field request langsung
             * pada Tr_EmpEmail.
             */
            $email->update([
                'ReqDivID' => $reqDivId,
                'ReqType' => $data['ReqType'],
                'EmailType' => $data['EmailType'],
                'Email' => $emailAddress,

                'Purpose' => $data['Purpose'],
                'DateFrom' => $data['DateFrom'],
                'DateUntil' => $data['DateUntil'],
                'Notes' => $this->defaultText($data['Notes'] ?? null),

                'CocID' => $email->CocID ?: 'COC003',
                'QRAppCoc' => $this->defaultText($email->QRAppCoc),
                'GivenNote' => $this->defaultText($email->GivenNote),
                'TakeOutNote' => $this->defaultText($email->TakeOutNote),
                'Status' => $email->Status === '-' || empty($email->Status) ? 'DRAFT' : $email->Status,

                // Audit.
                'ModifUser' => $user->Username,
                'ModifDate' => $now,
            ]);

            return $email->fresh([
                'empForm',
            ]);
        });
    }

    /**
     * Get the current Division from the Employee Form History.
     */
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
            throw new RuntimeException(
                'Division aktif untuk EmpFormID user login tidak ditemukan pada Tr_EmpFormHist.'
            );
        }

        return (string) $divisionId;
    }

    private function defaultText(?string $value): string
    {
        $value = trim((string) $value);

        return $value === '' ? '-' : $value;
    }

    /**
     * Validate Corporate Email.
     */
    private function validateCorporateEmail(
        string $emailType,
        string $email
    ): void {
        /*
         * Personal tidak perlu dicek ke Email Group.
         */
        if ($emailType !== 'Corporate') {
            return;
        }

        $exists = $this->getCorporateEmailGroups()
            ->contains(
                fn ($group) => (string) $group->Email === $email
            );

        if (!$exists) {
            throw ValidationException::withMessages([
                'Email' =>
                    'Corporate Email tidak tersedia untuk Division user yang sedang login.',
            ]);
        }
    }

    /**
     * Delete Employee Email.
     */
    public function delete(string $id): void
    {
        DB::transaction(function () use ($id) {

            $email = TrEmpEmail::query()
                ->where('EmpEmailID', $id)
                ->firstOrFail();

            $email->delete();
        });
    }

    /**
     * Generate Employee Email ID.
     *
     * Format:
     * EEMYYYYMM-001
     */
    private function generateId(): string
    {
        $prefix = 'EEM' . now()->format('Ym') . '-';

        $ids = TrEmpEmail::query()
            ->where(
                'EmpEmailID',
                'like',
                $prefix . '%'
            )
            ->lockForUpdate()
            ->pluck('EmpEmailID');

        $last = 0;

        foreach ($ids as $existing) {
            if (
                preg_match(
                    '/^' . preg_quote($prefix, '/') . '(\d{3})$/',
                    $existing,
                    $m
                )
            ) {
                $last = max(
                    $last,
                    (int) $m[1]
                );
            }
        }

        return $prefix .
            str_pad(
                (string) ($last + 1),
                3,
                '0',
                STR_PAD_LEFT
            );
    }
}
