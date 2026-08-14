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

    public function search(?string $keyword = null)
    {
        return $this->model
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('CompanyCode', 'like', "%{$keyword}%")
                      ->orWhere('CompanyName', 'like', "%{$keyword}%");
            })
            ->orderBy('CompanyCode')
            ->paginate(10);
    }
}
