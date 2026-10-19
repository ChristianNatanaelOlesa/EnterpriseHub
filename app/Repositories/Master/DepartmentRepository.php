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
                            'DeptID',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhere(
                            'Department',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhereHas(
                            'division',
                            function ($query) use ($search) {

                                $query
                                    ->where(
                                        'Division',
                                        'like',
                                        "%{$search}%"
                                    )
                                    ->orWhereHas(
                                        'directorate',
                                        function ($query) use ($search) {

                                            $query
                                                ->where(
                                                    'Directorate',
                                                    'like',
                                                    "%{$search}%"
                                                )
                                                ->orWhereHas(
                                                    'company',
                                                    function ($query) use ($search) {

                                                        $query->where(
                                                            'Company',
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
            ->orderBy('DeptID')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function findById(string $id)
    {
        return $this->model
            ->with([
                'division.directorate.company',
            ])
            ->where(
                'DeptID',
                $id
            )
            ->whereNull('DeletedDate')
            ->firstOrFail();
    }
}
