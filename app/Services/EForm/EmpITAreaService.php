<?php

namespace App\Services\EForm;

use App\Models\EForm\TrEmpITArea;
use App\Repositories\EForm\EmpITAreaRepository;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class EmpITAreaService
{
    public function __construct(
        protected EmpITAreaRepository $repository
    ) {
    }

    public function getAll(
        ?string $search = null,
        int $perPage = 10
    ): LengthAwarePaginator {
        return $this->repository->getAll($search, $perPage);
    }

    public function find(string $id): ?TrEmpITArea
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

    public function create(array $data): TrEmpITArea
    {
        return DB::transaction(function () use ($data) {
            $now = now();
            $user = $this->user();

            $dateFrom = Carbon::parse($data['DateFrom']);

            $data['EmpITAreaID'] = $this->generateId(
                $dateFrom
            );

            $data['ReqDate'] = $data['ReqDate'] ?? $now->toDateString();
            $data['ReqType'] = $data['ReqType'] ?? 'Permanent';
            $data['DateUntil'] = $data['DateUntil'] ?? '1900-01-01';

            $data['DataCenter'] = (bool) ($data['DataCenter'] ?? false);
            $data['FingerPrint'] = (bool) ($data['FingerPrint'] ?? false);
            $data['Firewall'] = (bool) ($data['Firewall'] ?? false);
            $data['CCTV'] = (bool) ($data['CCTV'] ?? false);
            $data['ExtDrive'] = (bool) ($data['ExtDrive'] ?? false);

            $data['Purpose'] = $data['Purpose'] ?? 'Kebutuhan Pekerjaan';
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
    ): TrEmpITArea {
        return DB::transaction(function () use ($id, $data) {
            $existing = $this->repository->find($id);

            if (!$existing) {
                throw ValidationException::withMessages([
                    'EmpITAreaID' => 'Employee IT Area data not found.',
                ]);
            }

            $data['DataCenter'] = (bool) ($data['DataCenter'] ?? false);
            $data['FingerPrint'] = (bool) ($data['FingerPrint'] ?? false);
            $data['Firewall'] = (bool) ($data['Firewall'] ?? false);
            $data['CCTV'] = (bool) ($data['CCTV'] ?? false);
            $data['ExtDrive'] = (bool) ($data['ExtDrive'] ?? false);

            $data['Notes'] = trim((string) ($data['Notes'] ?? '')) ?: '-';
            $data['CocID'] = 'COC005';
            $data['IsConfirm'] = $existing->IsConfirm ?? false;
            $data['QRAppCoc'] = $existing->QRAppCoc ?? '-';
            $data['IsGiven'] = $existing->IsGiven ?? false;
            $data['GivenDate'] = $existing->GivenDate ?? '1900-01-01';
            $data['GivenNote'] = $existing->GivenNote ?? '-';
            $data['IsTakeOut'] = $existing->IsTakeOut ?? false;
            $data['TakeOutDate'] = $existing->TakeOutDate ?? '1900-01-01';
            $data['TakeOutNote'] = $existing->TakeOutNote ?? '-';

            $data['ModifDate'] = now();
            $data['ModifUser'] = $this->user();

            if (!$this->repository->update($id, $data)) {
                throw ValidationException::withMessages([
                    'EmpITAreaID' => 'Failed to update Employee IT Area.',
                ]);
            }

            $updated = $this->repository->find($id);

            if (!$updated) {
                throw ValidationException::withMessages([
                    'EmpITAreaID' => 'Updated data could not be retrieved.',
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
                    'EmpITAreaID' => 'Employee IT Area data not found.',
                ]);
            }

            $this->repository->delete($id);
        });
    }

    public function generateId(Carbon $dateFrom): string
    {
        $prefix = 'EIT' . $dateFrom->format('Ym') . '-';

        $ids = TrEmpITArea::query()
            ->where('EmpITAreaID', 'like', $prefix . '%')
            ->lockForUpdate()
            ->pluck('EmpITAreaID');

        $last = 0;

        foreach ($ids as $existing) {
            if (preg_match(
                '/^' . preg_quote($prefix, '/') . '([0-9]{3})$/',
                $existing,
                $matches
            )) {
                $last = max($last, (int) $matches[1]);
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
