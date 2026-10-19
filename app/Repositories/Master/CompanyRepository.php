<?php

namespace App\Repositories\Master;

use App\Models\Master\MsCompany;
use App\Repositories\BaseRepository;

class CompanyRepository extends BaseRepository
{
    public function __construct(MsCompany $model)
    {
        $this->model = $model;
    }

    public function search(?string $keyword = null, int $perPage = 10)
    {
        return $this->model
            ->when($keyword, function ($query) use ($keyword) {

                $query->where(function ($q) use ($keyword) {

                    $q->where('CompID', 'like', "%{$keyword}%")
                        ->orWhere('Company', 'like', "%{$keyword}%");

                });

            })
            ->whereNull('DeletedDate')
            ->orderBy('CompID')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function findById(string $id)
    {
        return $this->model
            ->where('CompID', $id)
            ->whereNull('DeletedDate')
            ->firstOrFail();
    }
}
