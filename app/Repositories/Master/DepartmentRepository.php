<?php

namespace App\Repositories\Master;

use App\Models\Master\MsDepartment;
use App\Repositories\BaseRepository;

class DepartmentRepository extends BaseRepository
{
    public function __construct(MsDepartment $model)
    {
        $this->model = $model;
    }

    public function search(?string $search, int $perPage = 10)
    {
        return $this->model
            ->with([
                'division.directorate.company',
            ])
            ->whereNull('DeletedDate')
            ->when($search, function ($query) use ($search) {

                $query->where(function ($query) use ($search) {

                    $query
                        ->where(
                            'DepartmentCode',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhere(
                            'DepartmentName',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhereHas(
                            'division',
                            function ($query) use ($search) {

                                $query
                                    ->where(
                                        'DivisionName',
                                        'like',
                                        "%{$search}%"
                                    )
                                    ->orWhereHas(
                                        'directorate',
                                        function ($query) use ($search) {

                                            $query
                                                ->where(
                                                    'DirectorateName',
                                                    'like',
                                                    "%{$search}%"
                                                )
                                                ->orWhereHas(
                                                    'company',
                                                    function ($query) use ($search) {

                                                        $query->where(
                                                            'CompanyName',
                                                            'like',
                                                            "%{$search}%"
                                                        );

                                                    }
                                                );

                                        }
                                    );

                            }
                        );

                });

            })
            ->orderBy('DepartmentID')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function findById(int $id)
    {
        return $this->model
            ->with([
                'division.directorate.company',
            ])
            ->where(
                'DepartmentID',
                $id
            )
            ->whereNull('DeletedDate')
            ->firstOrFail();
    }
}
