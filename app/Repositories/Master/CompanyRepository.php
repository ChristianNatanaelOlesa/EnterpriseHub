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

    public function getPaginated(int $perPage = 10)
    {
        return $this->model
            ->whereNull('DeletedDate')
            ->orderBy('CompanyID')
            ->paginate($perPage);
    }

    public function findById(int $id)
    {
        return $this->model
            ->where('CompanyID', $id)
            ->whereNull('DeletedDate')
            ->firstOrFail();
    }

    public function search(?string $search, int $perPage = 10)
    {
        return $this->model
            ->whereNull('DeletedDate')
            ->when($search, function ($query) use ($search) {

                $query->where(function ($query) use ($search) {

                    $query
                        ->where(
                            'CompanyCode',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhere(
                            'CompanyName',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhere(
                            'Email',
                            'like',
                            "%{$search}%"
                        );

                });

            })
            ->orderBy('CompanyID')
            ->paginate($perPage)
            ->withQueryString();
    }
}
