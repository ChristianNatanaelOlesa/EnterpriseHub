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
            ->orderBy('DirID')
            ->paginate($perPage);
    }

    public function findById(string $id)
    {
        return $this->model
            ->where('DirID', $id)
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
                            'DirID',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhere(
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

                });

            })
            ->orderBy('DirID')
            ->paginate($perPage)
            ->withQueryString();
    }
}
