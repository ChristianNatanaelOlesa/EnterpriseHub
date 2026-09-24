<?php

namespace App\Repositories\EForm;

use App\Models\EForm\TrEmpNetDrive;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EmpNetDriveRepository
{
    public function __construct(protected TrEmpNetDrive $model) {}

    public function getAll(?string $search = null, int $perPage = 10): LengthAwarePaginator
    {
        return $this->model->newQuery()->with('empForm')
            ->when($search, function ($query) use ($search) {
                $like = "%{$search}%";
                $query->where(function ($q) use ($like) {
                    $q->where('EmpNetDriveID', 'like', $like)
                      ->orWhere('EmpFormID', 'like', $like)
                      ->orWhereHas('empForm', function ($eq) use ($like) {
                          $eq->where('FirstName','like',$like)->orWhere('LastName','like',$like)->orWhere('NIP','like',$like);
                      });
                    $q->orWhere('SourceType', 'like', $like);
                    $q->orWhere('DriveName', 'like', $like);
                    $q->orWhere('DrivePath', 'like', $like);
                    $q->orWhere('AccessType', 'like', $like);
                    $q->orWhere('Notes', 'like', $like);
                    $q->orWhere('Status', 'like', $like);
                });
            })
            ->orderByDesc('InputDate')->paginate($perPage)->withQueryString();
    }

    public function find(string $id): ?TrEmpNetDrive
    { return $this->model->newQuery()->with('empForm')->find($id); }

    public function create(array $data): TrEmpNetDrive
    { return $this->model->newQuery()->create($data); }

    public function update(string $id, array $data): bool
    { $model=$this->find($id); return $model ? $model->update($data) : false; }

    public function delete(string $id): bool
    { $model=$this->find($id); return $model ? $model->delete() : false; }
}
