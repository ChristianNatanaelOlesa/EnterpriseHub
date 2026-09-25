<?php

namespace App\Repositories\EForm;

use App\Models\EForm\TrEmpInfra;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EmpInfraRepository
{
    public function __construct(
        protected TrEmpInfra $model
    ) {
    }

    public function getAll(
        ?string $search = null,
        int $perPage = 10
    ): LengthAwarePaginator {
        return $this->model
            ->newQuery()
            ->with([
                'empForm',
                'division',
            ])
            ->when($search, function ($query) use ($search) {
                $like = "%{$search}%";

                $query->where(function ($q) use ($like) {
                    $q->where('EmpInfraID', 'like', $like)
                        ->orWhere('EmpFormID', 'like', $like)
                        ->orWhere('ReqDivID', 'like', $like)
                        ->orWhere('ReqUser', 'like', $like)
                        ->orWhere('ReqType', 'like', $like)
                        ->orWhere('DateFrom', 'like', $like)
                        ->orWhere('DateUntil', 'like', $like)
                        ->orWhere('AccessType', 'like', $like)
                        ->orWhere('AccessArea', 'like', $like)
                        ->orWhere('UserLogin', 'like', $like)
                        ->orWhere('Purpose', 'like', $like)
                        ->orWhere('Notes', 'like', $like)
                        ->orWhere('CocID', 'like', $like)
                        ->orWhere('Status', 'like', $like)
                        ->orWhereHas('empForm', function ($eq) use ($like) {
                            $eq->where('FirstName', 'like', $like)
                                ->orWhere('LastName', 'like', $like)
                                ->orWhere('NIP', 'like', $like);
                        })
                        ->orWhereHas('division', function ($dq) use ($like) {
                            $dq->where('DivisionName', 'like', $like)
                                ->orWhere('DivisionCode', 'like', $like);
                        });
                });
            })
            ->orderByDesc('InputDate')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function find(string $id): ?TrEmpInfra
    {
        return $this->model
            ->newQuery()
            ->with([
                'empForm',
                'division',
            ])
            ->find($id);
    }

    public function create(array $data): TrEmpInfra
    {
        return $this->model
            ->newQuery()
            ->create($data);
    }

    public function update(string $id, array $data): bool
    {
        $model = $this->find($id);

        return $model
            ? $model->update($data)
            : false;
    }

    public function delete(string $id): bool
    {
        $model = $this->find($id);

        return $model
            ? $model->delete()
            : false;
    }
}
