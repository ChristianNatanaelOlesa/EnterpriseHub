<?php

namespace App\Models\Master;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MsDirectorate extends BaseModel
{
    protected $table = 'ms_directorate';

    public function company(): BelongsTo
    {
        return $this->belongsTo(MsCompany::class, 'CompanyID', 'ID');
    }

    public function divisions(): HasMany
    {
        return $this->hasMany(MsDivision::class, 'DirectorateID', 'ID');
    }
}
