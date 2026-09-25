<?php

namespace App\Services\EForm;

use App\Models\EForm\TrEmpSharingFolder;
use App\Models\EForm\TrEmpSharingFolderDetail;
use App\Repositories\EForm\EmpSharingFolderRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class EmpSharingFolderService
{
    public function __construct(
        protected EmpSharingFolderRepository $repository
    ) {
    }

    private function user(): string
    {
        return Auth::user()?->Username
            ?? Auth::user()?->username
            ?? Auth::user()?->email
            ?? 'Admin';
    }

    public function getAll(?string $search, int $perPage): LengthAwarePaginator
    {
        return $this->repository->getAll($search, $perPage);
    }

    public function find(string $id): ?TrEmpSharingFolder
    {
        return $this->repository->find($id);
    }

    public function generateId(string $dateFrom): string
    {
        $prefix = 'ESF' . date('Ym', strtotime($dateFrom)) . '-';

        $ids = TrEmpSharingFolder::query()
            ->where('EmpSharingFolderID', 'like', $prefix . '%')
            ->lockForUpdate()
            ->pluck('EmpSharingFolderID');

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

    public function create(array $data): TrEmpSharingFolder
    {
        return DB::transaction(function () use ($data) {

            $now = now();
            $user = $this->user();

            $header = [
                'EmpSharingFolderID' => $this->generateId($data['DateFrom']),
                'EmpFormID' => $data['EmpFormID'],
                'ReqDivID' => $data['ReqDivID'] ?? null,
                'ReqUser' => $data['ReqUser'] ?? $user,
                'ReqDate' => $data['ReqDate'] ?? now()->toDateString(),
                'ReqType' => $data['ReqType'],
                'DateFrom' => $data['DateFrom'],
                'DateUntil' => $data['DateUntil'],
                'FolderRequestType' => $data['FolderRequestType'],
                'Purpose' => $data['Purpose'],
                'Notes' => blank($data['Notes'] ?? null) ? '-' : $data['Notes'],
                'CocID' => 'COC006',
                'IsConfirm' => false,
                'QRAppCoc' => '-',
                'IsGiven' => false,
                'GivenDate' => '1900-01-01',
                'GivenNote' => '-',
                'IsTakeOut' => false,
                'TakeOutDate' => '1900-01-01',
                'TakeOutNote' => '-',
                'Status' => 'DRAFT',
                'InputUser' => $user,
                'InputDate' => $now,
                'ModifUser' => $user,
                'ModifDate' => $now,
            ];

            $model = $this->repository->create($header);

            $details = $this->buildDetails($data, $model->EmpSharingFolderID, $user, $now);

            foreach ($details as $detail) {
                TrEmpSharingFolderDetail::query()->create($detail);
            }

            return $this->repository->find($model->EmpSharingFolderID);
        });
    }

    public function update(string $id, array $data): TrEmpSharingFolder
    {
        return DB::transaction(function () use ($id, $data) {

            $model = $this->repository->find($id);

            if (!$model) {
                throw ValidationException::withMessages([
                    'EmpSharingFolderID' => 'Employee Sharing Folder data not found.',
                ]);
            }

            $user = $this->user();

            $this->repository->update($id, [
                'ReqType' => $data['ReqType'],
                'DateFrom' => $data['DateFrom'],
                'DateUntil' => $data['DateUntil'],
                'FolderRequestType' => $data['FolderRequestType'],
                'Purpose' => $data['Purpose'],
                'Notes' => blank($data['Notes'] ?? null) ? '-' : $data['Notes'],
                'ModifUser' => $user,
                'ModifDate' => now(),
            ]);

            TrEmpSharingFolderDetail::query()
                ->where('EmpSharingFolderID', $id)
                ->delete();

            foreach (
                $this->buildDetails(
                    $data,
                    $id,
                    $user,
                    now()
                ) as $detail
            ) {
                TrEmpSharingFolderDetail::query()->create($detail);
            }

            return $this->repository->find($id);
        });
    }

    private function buildDetails(
        array $data,
        string $headerId,
        string $user,
        $now
    ): array {
        $result = [];
        $accessType = $data['AccessType'];

        if ($data['FolderRequestType'] === 'Existing') {

            foreach ($data['FolderPathIDs'] as $folderPathId) {

                $result[] = [
                    'EmpSharingFolderID' => $headerId,
                    'FolderPathID' => $folderPathId,
                    'ParentFolderPathID' => null,
                    'FolderName' => null,
                    'RequestedPath' => null,
                    'AccessType' => $accessType,
                    'InputUser' => $user,
                    'InputDate' => $now,
                    'ModifUser' => $user,
                    'ModifDate' => $now,
                ];
            }

            return $result;
        }

        $parentId = $data['ParentFolderPathID'];
        $folderName = $data['NewFolderName'];

        $parent = \App\Models\Master\MsFolderPath::find($parentId);

        $requestedPath = $folderName;

        if ($parent) {
            $requestedPath = rtrim($parent->FolderPath, '\\') . '\\' . $folderName;
        }

        return [[
            'EmpSharingFolderID' => $headerId,
            'FolderPathID' => null,
            'ParentFolderPathID' => $parentId,
            'FolderName' => $folderName,
            'RequestedPath' => $requestedPath,
            'AccessType' => $accessType,
            'InputUser' => $user,
            'InputDate' => $now,
            'ModifUser' => $user,
            'ModifDate' => $now,
        ]];
    }

    public function delete(string $id): void
    {
        DB::transaction(function () use ($id) {

            $model = $this->repository->find($id);

            if (!$model) {
                throw ValidationException::withMessages([
                    'EmpSharingFolderID' => 'Employee Sharing Folder data not found.',
                ]);
            }

            $this->repository->delete($id);
        });
    }
}
