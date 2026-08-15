<?php

namespace App\Repositories\Master;

use App\Models\Master\MsDirectorate;
use App\Repositories\BaseRepository;

class DirectorateRepository extends BaseRepository
{
    public function __construct(MsDirectorate $model)
    {
        $this->model = $model;
    }

    public function getPaginated(int $perPage = 10)
    {
        return $this->model
            ->with('company')
            ->whereNull('DeletedDate')
            ->orderBy('DirectorateID')
            ->paginate($perPage);
    }

    public function findById(int $id)
    {
        return $this->model
            ->where('DirectorateID', $id)
            ->whereNull('DeletedDate')
            ->firstOrFail();
    }

    public function search(?string $search, int $perPage = 10)
    {
        return $this->model
            ->with('company')
            ->whereNull('DeletedDate')
            ->when($search, function ($query) use ($search) {

                $query->where(function ($query) use ($search) {

                    $query
                        ->where(
                            'DirectorateCode',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhere(
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

                });

            })
            ->orderBy('DirectorateID')
            ->paginate($perPage)
            ->withQueryString();
    }
}
