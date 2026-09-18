<?php

namespace App\Repositories\Master;

use App\Models\Master\MsCountry;
use App\Repositories\BaseRepository;

class CountryRepository extends BaseRepository
{
    public function __construct(MsCountry $model)
    {
        $this->model = $model;
    }

    public function search(?string $keyword = null, int $perPage = 10)
    {
        return $this->model
            ->when($keyword, function ($query) use ($keyword) {

                $query->where(function ($q) use ($keyword) {

                    $q->where('CountryID', 'like', "%{$keyword}%")
                        ->orWhere('Country', 'like', "%{$keyword}%");

                });

            })
            ->orderBy('CountryID')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function findById(string $id)
    {
        return $this->model
            ->where('CountryID', $id)
            ->firstOrFail();
    }
}
