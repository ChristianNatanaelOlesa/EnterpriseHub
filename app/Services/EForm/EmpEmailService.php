<?php

namespace App\Services\EForm;

use App\Models\EForm\TrEmpEmail;
use App\Models\EForm\TrEmpForm;
use App\Models\EForm\TrEmpFormHist;
use App\Models\Security\ScUser;
use App\Models\Scopes\EmployeeVisibilityScope;
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
    public function getAll(?string $search = null, ?string $empFormId = null): LengthAwarePaginator
    {
        return $this->repository->getAll($search, 10, $empFormId);
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
         * ms_email_group.DivID
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
            ->whereIn('eg.DivID', $divisionIds->all())
            ->where('eg.IsActive', true)
            ->whereNull('eg.DeletedDate')
            ->select([
                'eg.EmailGroupID',
                'eg.Email',
                'eg.Description',
                'eg.DivID',
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

                // Request information.
                'ReqDate' => $now,
                'ReqType' => $data['ReqType'],

                'EmailType' => $data['EmailType'],
                'Email' => $email,

                'Purpose' => $data['Purpose'],
                'DateFrom' => $data['DateFrom'],
                'DateUntil' => $data['DateUntil'] ?? '1900-01-01',
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
     * Request yang sudah dikirim ke approval tidak boleh diedit.
     */

    private function assertEditable(TrEmpEmail $email): void
    {
        $status = strtoupper(trim((string) $email->Status));

        if ($status === 'CANCELLED') {
            throw new RuntimeException(
                'Transaksi Employee Email yang sudah dibatalkan tidak dapat diubah atau dihapus.'
            );
        }

        if (!in_array($status, ['DRAFT', 'REJECTED', 'REVISION_REQUIRED'], true)) {
            throw new RuntimeException(
                'Employee Email tidak dapat diubah karena statusnya sudah masuk proses workflow.'
            );
        }
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
            $this->assertEditable($email);

            $this->validateCorporateEmail(
                $data['EmailType'],
                $emailAddress,
                $id
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
        string $email,
        ?string $excludeId = null
    ): void {
        // Personal Email tidak perlu dicek ke Email Group
        // dan tidak dibatasi oleh riwayat Personal sebelumnya.
        if (strcasecmp(trim($emailType), 'Corporate') !== 0) {
            return;
        }

        $email = trim($email);

        // Pastikan email tersedia untuk Division user.
        $isAvailableForDivision = $this->getCorporateEmailGroups()
            ->contains(
                fn ($group) =>
                    strcasecmp(trim((string) $group->Email), $email) === 0
            );

        if (!$isAvailableForDivision) {
            throw ValidationException::withMessages([
                'Email' =>
                    'Corporate Email tidak tersedia untuk Division user yang sedang login.',
            ]);
        }

        // Cek apakah email Corporate yang sama masih aktif digunakan.
        $activeEmailExists = TrEmpEmail::query()
            ->whereRaw('LOWER(TRIM(Email)) = ?', [strtolower($email)])
            ->whereRaw('LOWER(TRIM(EmailType)) = ?', ['corporate'])
            ->where('IsGiven', true)
            ->where('IsTakeOut', false)
            ->when(
                $excludeId !== null,
                fn ($query) => $query->where('EmpEmailID', '<>', $excludeId)
            )
            ->exists();

        if ($activeEmailExists) {
            throw ValidationException::withMessages([
                'Email' =>
                    'Corporate Email ini masih aktif digunakan. Email hanya dapat diajukan kembali setelah akses sebelumnya di-take out.',
            ]);
        }
    }


    /**
     * Determine whether a user may fulfill this Employee Email request.
     * Job level/title are read from the active Employee Form History, not ScUser.RoleID.
     */
    public function canFulfill(ScUser $user, TrEmpEmail $email): bool
    {
        $userHistory = $this->activeHistoryForEmpForm((string) $user->EmpFormID);
        if (! $userHistory || ! $this->isItInfraDepartment($userHistory)) {
            return false;
        }

        $isKabag = $this->isKabagItInfra($userHistory);
        $isStaff = $this->isStaffItInfra($userHistory);
        if (! $isKabag && ! $isStaff) {
            return false;
        }

        $requesterHistory = $this->activeHistoryForEmpForm((string) $email->EmpFormID);
        $requesterIsStaffItInfra = $requesterHistory
            && $this->isItInfraDepartment($requesterHistory)
            && $this->isStaffItInfra($requesterHistory);

        // Staff IT Infra tidak boleh memproses fulfillment request miliknya sendiri.
        if ($requesterIsStaffItInfra) {
            return $isKabag;
        }

        return $isKabag || $isStaff;
    }

    /** Update fulfillment fields only; transaction/workflow Status is intentionally untouched. */
    public function updateFulfillment(string $id, array $data, ScUser $user): TrEmpEmail
    {
        return DB::transaction(function () use ($id, $data, $user) {
            $email = TrEmpEmail::query()->where('EmpEmailID', $id)->lockForUpdate()->firstOrFail();
            $status = strtoupper(trim((string) $email->Status));
            if (! in_array($status, ['APPROVED', 'COMPLETED'], true)) {
                throw new RuntimeException('IT Fulfillment hanya dapat dilakukan pada transaksi yang sudah Approved.');
            }
            if (! $this->canFulfill($user, $email)) {
                throw new RuntimeException('Anda tidak memiliki akses untuk melakukan IT Fulfillment pada transaksi ini.');
            }

            $wasGiven = (bool) $email->IsGiven;
            $wasTakenOut = (bool) $email->IsTakeOut;
            $isGiven = filter_var($data['IsGiven'] ?? false, FILTER_VALIDATE_BOOLEAN);
            $isTakeOut = filter_var($data['IsTakeOut'] ?? false, FILTER_VALIDATE_BOOLEAN);

            if ($wasTakenOut && (! $isGiven || ! $isTakeOut)) {
                throw new RuntimeException('Status fulfillment yang sudah Taken Out tidak dapat dibatalkan.');
            }
            if ($wasGiven && ! $isGiven) {
                throw new RuntimeException('Status Given tidak dapat dibatalkan setelah email diberikan.');
            }
            if ($isTakeOut && ! $isGiven) {
                throw new RuntimeException('Email harus berstatus Given sebelum dapat di-Take Out.');
            }

            $emailAddress = trim((string) ($data['Email'] ?? $email->Email));
            if (strcasecmp(trim((string) $email->EmailType), 'Personal') === 0) {
                if ($isGiven && ($emailAddress === '' || strcasecmp($emailAddress, 'Fill by IT Infra') === 0 || ! filter_var($emailAddress, FILTER_VALIDATE_EMAIL))) {
                    throw ValidationException::withMessages([
                        'Email' => 'Isi Personal Email dengan alamat email yang valid sebelum mengubah status menjadi Given.',
                    ]);
                }
                if (! $isGiven && $emailAddress === '') {
                    $emailAddress = (string) $email->Email;
                }
            } else {
                // Email Corporate berasal dari master/group yang dipilih saat request.
                $emailAddress = (string) $email->Email;
            }

            $updates = [
                'Email' => $emailAddress,
                'IsGiven' => $isGiven,
                'ModifUser' => $user->Username,
                'ModifDate' => now(),
            ];

            // Given fields remain editable until Take Out; when already taken out, freeze them.
            if (! $wasTakenOut) {
                $updates['GivenDate'] = $isGiven
                    ? ($data['GivenDate'] ?? ($email->GivenDate ?: now()->toDateString()))
                    : '1900-01-01';
                $updates['GivenNote'] = $this->defaultText($data['GivenNote'] ?? null);
            }

            // Take Out fields are editable only after Given; once taken out they remain editable for notes/date correction.
            if ($isGiven) {
                $updates['IsTakeOut'] = $isTakeOut;
                if ($isTakeOut) {
                    $updates['TakeOutDate'] = $data['TakeOutDate'] ?? (($email->TakeOutDate && (string) $email->TakeOutDate !== '1900-01-01') ? $email->TakeOutDate : now()->toDateString());
                    $updates['TakeOutNote'] = $this->defaultText($data['TakeOutNote'] ?? null);
                } elseif (! $wasTakenOut) {
                    $updates['TakeOutDate'] = '1900-01-01';
                    $updates['TakeOutNote'] = $this->defaultText($data['TakeOutNote'] ?? null);
                }
            } else {
                $updates['IsTakeOut'] = false;
            }

            $email->update($updates);
            return $email->fresh();
        });
    }

    private function activeHistoryForEmpForm(string $empFormId): ?TrEmpFormHist
    {
        if (trim($empFormId) === '') {
            return null;
        }
        return TrEmpFormHist::query()
            ->with(['department', 'jobLevel', 'jobTitle'])
            ->where('EmpFormID', $empFormId)
            ->where('IsActive', true)
            ->orderByDesc('EffectiveDate')
            ->orderByDesc('ReqDate')
            ->first();
    }

    private function isItInfraDepartment(TrEmpFormHist $history): bool
    {
        return strtoupper(trim((string) $history->department?->DeptID)) === 'ITI';
    }

    private function isStaffItInfra(TrEmpFormHist $history): bool
    {
        return strcasecmp(trim((string) $history->jobLevel?->JobLevel), 'Staff') === 0;
    }

    private function isKabagItInfra(TrEmpFormHist $history): bool
    {
        $title = strtolower(trim((string) $history->jobTitle?->JobTitle));
        return str_starts_with($title, 'head of ') && str_contains($title, 'infrastructure');
    }

    /**
     * Delete Employee Email.
     */
    public function delete(string $id, ScUser $user): void
    {
        DB::transaction(function () use ($id, $user) {
            $email = TrEmpEmail::query()
                ->where('EmpEmailID', $id)
                ->lockForUpdate()
                ->firstOrFail();

            // Pastikan hanya requester yang memiliki data ini yang bisa menghapus.
            if (
                (string) $email->EmpFormID !== (string) $user->EmpFormID
            ) {
                throw new RuntimeException(
                    'Anda tidak memiliki akses untuk menghapus Employee Email ini.'
                );
            }

            // Validasi harus dilakukan sebelum penghapusan.
            $this->assertEditable($email);

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

        // Tanpa global scope EmployeeVisibilityScope agar generateId()
        // melihat SEMUA record yang sudah ada, tidak hanya milik user login.
        $ids = TrEmpEmail::withoutGlobalScope(EmployeeVisibilityScope::class)
            ->where('EmpEmailID', 'like', $prefix . '%')
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
