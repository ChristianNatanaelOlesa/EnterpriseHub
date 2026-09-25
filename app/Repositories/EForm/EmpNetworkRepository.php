<?php

namespace App\Repositories\EForm;

use App\Models\EForm\TrEmpNetwork;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EmpNetworkRepository
{
    public function __construct(protected TrEmpNetwork $model)
    {
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
            ->when(
                $search !== null && trim($search) !== '',
                function ($query) use ($search) {
                    $keyword = '%' . trim($search) . '%';

                    $query->where(function ($q) use ($keyword) {
                        $q->where(
                            'EmpNetworkID',
                            'like',
                            $keyword
                        )
                            ->orWhere(
                                'EmpFormID',
                                'like',
                                $keyword
                            )
                            ->orWhere(
                                'ReqDivID',
                                'like',
                                $keyword
                            )
                            ->orWhere(
                                'ReqUser',
                                'like',
                                $keyword
                            )
                            ->orWhere(
                                'ReqType',
                                'like',
                                $keyword
                            )
                            ->orWhere(
                                'Purpose',
                                'like',
                                $keyword
                            )
                            ->orWhere(
                                'Notes',
                                'like',
                                $keyword
                            )
                            ->orWhere(
                                'CocID',
                                'like',
                                $keyword
                            )
                            ->orWhere(
                                'Status',
                                'like',
                                $keyword
                            )
                            ->orWhereRaw(
                                "DATE_FORMAT(ReqDate, '%Y-%m-%d') LIKE ?",
                                [$keyword]
                            )
                            ->orWhereRaw(
                                "DATE_FORMAT(DateFrom, '%Y-%m-%d') LIKE ?",
                                [$keyword]
                            )
                            ->orWhereRaw(
                                "DATE_FORMAT(DateUntil, '%Y-%m-%d') LIKE ?",
                                [$keyword]
                            )
                            ->orWhereHas(
                                'empForm',
                                function ($employee) use ($keyword) {
                                    $employee
                                        ->where(
                                            'FirstName',
                                            'like',
                                            $keyword
                                        )
                                        ->orWhere(
                                            'LastName',
                                            'like',
                                            $keyword
                                        )
                                        ->orWhere(
                                            'NIP',
                                            'like',
                                            $keyword
                                        );
                                }
                            )
                            ->orWhereHas(
                                'division',
                                function ($division) use ($keyword) {
                                    $division
                                        ->where(
                                            'DivisionName',
                                            'like',
                                            $keyword
                                        )
                                        ->orWhere(
                                            'DivisionCode',
                                            'like',
                                            $keyword
                                        );
                                }
                            );
                    });
                }
            )
            ->orderByDesc('InputDate')
            ->orderByDesc('EmpNetworkID')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function find(string $id): ?TrEmpNetwork
    {
        return $this->model
            ->newQuery()
            ->with([
                'empForm',
                'division',
            ])
            ->find($id);
    }

    public function create(array $data): TrEmpNetwork
    {
        return $this->model
            ->newQuery()
            ->create($data);
    }

    public function update(
        string $id,
        array $data
    ): bool {
        $model = $this->model
            ->newQuery()
            ->find($id);

        return $model
            ? $model->update($data)
            : false;
    }

    public function delete(string $id): bool
    {
        $model = $this->model
            ->newQuery()
            ->find($id);

        return $model
            ? $model->delete()
            : false;
    }
}
