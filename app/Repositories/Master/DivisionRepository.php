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
            ->orderBy('DivID')
            ->paginate($perPage);
    }

    public function findById(string $id)
    {
        return $this->model
            ->with([
                'directorate.company',
            ])
            ->where(
                'DivID',
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
                            'DivID',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhere(
                            'Division',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhereHas(
                            'directorate',
                            function ($query) use ($search) {

                                $query->where(
                                    'Directorate',
                                    'like',
                                    "%{$search}%"
                                );

                                $query->orWhereHas(
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

                });

            })
            ->orderBy('DivID')
            ->paginate($perPage)
            ->withQueryString();
    }
}
