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

                    $q->where('CompanyCode', 'like', "%{$keyword}%")
                        ->orWhere('CompanyName', 'like', "%{$keyword}%");

                });

            })
            ->whereNull('DeletedDate')
            ->orderBy('CompanyID')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function findById(int $id)
    {
        return $this->model
            ->where('CompanyID', $id)
            ->whereNull('DeletedDate')
            ->firstOrFail();
    }
}
