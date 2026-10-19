<?php

namespace App\Models\Master;

use App\Models\BaseModel;

class MsDivision extends BaseModel
{
    protected $table = 'ms_division';

    protected $primaryKey = 'DivID';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'DivID',
        'DirID',
        'Division',
        'Description',
        'IsActive',
        'InputUser',
        'InputDate',
        'ModifUser',
        'ModifDate',
        'DeletedBy',
        'DeletedDate',
    ];

    protected $casts = [
        'IsActive' => 'boolean',
    ];

    public function directorate()
    {
        return $this->belongsTo(
            MsDirectorate::class,
            'DirID',
            'DirID'
        );
    }
}
