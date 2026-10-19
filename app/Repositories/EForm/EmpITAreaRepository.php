<?php

namespace App\Repositories\EForm;

use App\Models\EForm\TrEmpITArea;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EmpITAreaRepository
{
    public function __construct(
        protected TrEmpITArea $model
    ) {
    }

    public function getAll(
        ?string $search = null,
        int $perPage = 10,
        ?string $empFormId = null
    ): LengthAwarePaginator {
        $query = $this->model
            ->newQuery()
            ->with(['empForm', 'division'])
            ->when($search, function ($query) use ($search) {
                $like = "%{$search}%";

                $query->where(function ($q) use ($like) {
                    $q->where('EmpITAreaID', 'like', $like)
                        ->orWhere('EmpFormID', 'like', $like)
                        ->orWhere('ReqType', 'like', $like)
                        ->orWhere('DateFrom', 'like', $like)
                        ->orWhere('DateUntil', 'like', $like)
                        ->orWhere('Purpose', 'like', $like)
                        ->orWhere('Notes', 'like', $like)
                        ->orWhere('Status', 'like', $like)
                        ->orWhereHas('division', function ($dq) use ($like) {
                            $dq->where('Division', 'like', $like)
                                ->orWhere('DivID', 'like', $like);
                        })
                        ->orWhereHas('empForm', function ($eq) use ($like) {
                            $eq->where('FirstName', 'like', $like)
                                ->orWhere('LastName', 'like', $like)
                                ->orWhere('NIP', 'like', $like);
                        });
                });
            });

        if ($empFormId !== null) {
            $query->orderByRaw(
                "CASE WHEN Status = 'DRAFT' AND EmpFormID = ? THEN 1 " .
                "WHEN Status = 'WAITING_APPROVAL' THEN 2 " .
                "WHEN Status IN ('APPROVED', 'COMPLETED') THEN 3 " .
                "WHEN Status IN ('REJECTED', 'CANCELLED') THEN 4 " .
                "ELSE 5 END",
                [$empFormId]
            );
        }

        return $query->orderByDesc('InputDate')->orderByDesc('EmpITAreaID')->paginate($perPage)->withQueryString();
    }

    public function find(string $id): ?TrEmpITArea
    {
        return $this->model
            ->newQuery()
            ->with(['empForm', 'division'])
            ->find($id);
    }

    public function create(array $data): TrEmpITArea
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
