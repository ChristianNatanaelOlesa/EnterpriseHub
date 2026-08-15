<?php

namespace App\Repositories\Master;

use App\Models\Master\MsDivision;
use App\Repositories\BaseRepository;

class DivisionRepository extends BaseRepository
{
    public function __construct(MsDivision $model)
    {
        $this->model = $model;
    }

    public function getPaginated(int $perPage = 10)
    {
        return $this->model
            ->with([
                'company',
                'directorate',
            ])
            ->whereNull('DeletedDate')
            ->orderBy('DivisionID')
            ->paginate($perPage);
    }

    public function findById(int $id)
    {
        return $this->model
            ->with([
                'directorate.company',
            ])
            ->where(
                'DivisionID',
                $id
            )
            ->whereNull('DeletedDate')
            ->firstOrFail();
    }

    public function search(?string $search, int $perPage = 10)
    {
        return $this->model
            ->with([
                'directorate.company',
            ])
            ->whereNull('DeletedDate')
            ->when($search, function ($query) use ($search) {

                $query->where(function ($query) use ($search) {

                    $query
                        ->where(
                            'DivisionCode',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhere(
                            'DivisionName',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhereHas(
                            'directorate',
                            function ($query) use ($search) {

                                $query->where(
                                    'DirectorateName',
                                    'like',
                                    "%{$search}%"
                                );

                                $query->orWhereHas(
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

                });

            })
            ->orderBy('DivisionID')
            ->paginate($perPage)
            ->withQueryString();
    }
}
