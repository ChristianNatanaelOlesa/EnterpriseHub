<?php

namespace App\Models\Master;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MsCompany extends BaseModel
{
    protected $table = 'ms_company';

    public function directorates(): HasMany
    {
        return $this->hasMany(MsDirectorate::class, 'CompanyID', 'ID');
    }
}
