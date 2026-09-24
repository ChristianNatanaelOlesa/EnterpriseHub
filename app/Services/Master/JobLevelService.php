<?php

namespace App\Services\Master;

use App\Models\Master\MsJobLevel;
use App\Repositories\Master\JobLevelRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class JobLevelService
{
    public function __construct(protected JobLevelRepository $repository) {}
    public function getAll(?string $search = null, int $perPage = 10): LengthAwarePaginator { return $this->repository->getAll($search, $perPage); }
    public function find(string $id): ?MsJobLevel { return $this->repository->find($id); }
    public function create(array $data): MsJobLevel
    {
        return DB::transaction(function () use ($data) {
            $data['InputDate'] = now();
            $data['InputUser'] = Auth::user()?->username ?? Auth::user()?->email ?? 'Admin';
            $data['ModifDate'] = now();
            $data['ModifUser'] = Auth::user()?->username ?? Auth::user()?->email ?? 'Admin';
            return $this->repository->create($data);
        });
    }
    public function update(string $id, array $data): MsJobLevel
    {
        return DB::transaction(function () use ($id, $data) {
            if (!$this->repository->find($id)) throw ValidationException::withMessages(['JobLevelID' => 'Job Level data not found.']);
            $data['ModifDate'] = now();
            $data['ModifUser'] = Auth::user()?->username ?? Auth::user()?->email ?? 'Admin';
            $this->repository->update($id, $data);
            return $this->repository->find($id);
        });
    }
    public function delete(string $id): void
    {
        DB::transaction(function () use ($id) {
            if (!$this->repository->find($id)) throw ValidationException::withMessages(['JobLevelID' => 'Job Level data not found.']);
            $this->repository->delete($id);
        });
    }
}
