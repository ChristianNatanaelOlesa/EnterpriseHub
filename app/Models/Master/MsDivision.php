<?php

namespace App\Models\Master;

use App\Models\BaseModel;

class MsDivision extends BaseModel
{
    protected $table = 'ms_division';

    protected $primaryKey = 'DivisionID';

    protected $fillable = [
        'DirectorateID',
        'DivisionCode',
        'DivisionName',
        'IsActive',
        'InputUser',
        'InputDate',
        'ModifUser',
        'ModifDate',
        'DeletedBy',
        'DeletedDate',
    ];

    protected $casts = [
        'DirectorateID' => 'integer',
        'IsActive' => 'boolean',
    ];

    public function directorate()
    {
        return $this->belongsTo(
            MsDirectorate::class,
            'DirectorateID',
            'DirectorateID'
        );
    }
}
