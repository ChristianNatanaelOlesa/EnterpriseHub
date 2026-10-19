<?php

namespace App\Models\Master;

use App\Models\BaseModel;

class MsDepartment extends BaseModel
{
    protected $table = 'ms_department';

    protected $primaryKey = 'DeptID';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'DeptID',
        'DivID',
        'Department',
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

    public function division()
    {
        return $this->belongsTo(
            MsDivision::class,
            'DivID',
            'DivID'
        );
    }
}
