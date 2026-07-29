<?php

namespace App\Models\Master;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MsDivision extends BaseModel
{
    protected $table = 'ms_division';

    public function directorate(): BelongsTo
    {
        return $this->belongsTo(MsDirectorate::class, 'DirectorateID', 'ID');
    }

    public function departments(): HasMany
    {
        return $this->hasMany(MsDepartment::class, 'DivisionID', 'ID');
    }
}
