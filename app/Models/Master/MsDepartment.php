<?php

namespace App\Models\Master;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MsDepartment extends BaseModel
{
    protected $table = 'ms_department';

    public function division(): BelongsTo
    {
        return $this->belongsTo(MsDivision::class, 'DivisionID', 'ID');
    }
}
