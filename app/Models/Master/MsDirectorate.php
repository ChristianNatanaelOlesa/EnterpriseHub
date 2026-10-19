<?php

namespace App\Models\Master;

use App\Models\BaseModel;

class MsDirectorate extends BaseModel
{
    protected $table = 'ms_directorate';

    protected $primaryKey = 'DirID';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'DirID',
        'CompID',
        'Directorate',
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

    public function company()
    {
        return $this->belongsTo(
            MsCompany::class,
            'CompID',
            'CompID'
        );
    }

    public function divisions()
    {
        return $this->hasMany(
            MsDivision::class,
            'DirID',
            'DirID'
        );
    }
}
