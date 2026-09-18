<?php

namespace App\Repositories\Master;

use App\Models\Master\MsProvince;
use App\Repositories\BaseRepository;

class ProvinceRepository extends BaseRepository
{
    public function __construct(MsProvince $model)
    {
        $this->model = $model;
    }

    public function search(?string $keyword = null, int $perPage = 10)
    {
        return $this->model
            ->with('country')
            ->when($keyword, function ($query) use ($keyword) {

                $query->where(function ($q) use ($keyword) {

                    $q->where('ProvinceID', 'like', "%{$keyword}%")
                        ->orWhere('Province', 'like', "%{$keyword}%");

                });

            })
            ->whereNull('DeletedDate')
            ->orderBy('ProvinceID')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function findById(string $id)
    {
        return $this->model
            ->with('country')
            ->where('ProvinceID', $id)
            ->whereNull('DeletedDate')
            ->firstOrFail();
    }
}
