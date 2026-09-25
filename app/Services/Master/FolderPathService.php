<?php

namespace App\Services\Master;

use App\Models\Master\MsFolderPath;
use App\Repositories\Master\FolderPathRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class FolderPathService
{
    public function __construct(protected FolderPathRepository $repository)
    {
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

    public function find(string $id): ?MsFolderPath
    {
        return $this->repository->find($id);
    }

    public function activeList()
    {
        return $this->repository->activeList();
    }

    public function generateId(): string
    {
        $last = MsFolderPath::query()
            ->where('FolderPathID', 'like', 'FP%')
            ->orderByDesc('FolderPathID')
            ->lockForUpdate()
            ->value('FolderPathID');

        $number = 0;

        if ($last && preg_match('/^FP(\d+)$/', $last, $matches)) {
            $number = (int) $matches[1];
        }

        return 'FP' . str_pad((string) ($number + 1), 4, '0', STR_PAD_LEFT);
    }

    public function create(array $data): MsFolderPath
    {
        return DB::transaction(function () use ($data) {
            $now = now();
            $user = $this->user();

            $data['FolderPathID'] = $this->generateId();
            $data['IsActive'] = (bool) ($data['IsActive'] ?? true);
            $data['InputDate'] = $now;
            $data['InputUser'] = $user;
            $data['ModifDate'] = $now;
            $data['ModifUser'] = $user;

            return $this->repository->create($data);
        });
    }

    public function update(string $id, array $data): MsFolderPath
    {
        return DB::transaction(function () use ($id, $data) {
            $model = $this->repository->find($id);

            if (!$model) {
                throw ValidationException::withMessages([
                    'FolderPathID' => 'Folder Path not found.',
                ]);
            }

            $data['IsActive'] = (bool) ($data['IsActive'] ?? false);
            $data['ModifDate'] = now();
            $data['ModifUser'] = $this->user();

            $this->repository->update($id, $data);

            return $this->repository->find($id);
        });
    }

    public function delete(string $id): void
    {
        DB::transaction(function () use ($id) {
            $model = $this->repository->find($id);

            if (!$model) {
                throw ValidationException::withMessages([
                    'FolderPathID' => 'Folder Path not found.',
                ]);
            }

            $user = $this->user();

            $model->DeletedBy = $user;
            $model->DeletedDate = now();
            $model->IsActive = false;
            $model->ModifUser = $user;
            $model->ModifDate = now();
            $model->save();
        });
    }
}
