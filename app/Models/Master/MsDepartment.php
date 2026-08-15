<?php

namespace App\Models\Master;

use App\Models\BaseModel;

class MsDepartment extends BaseModel
{
    protected $table = 'ms_department';

    protected $primaryKey = 'DepartmentID';

    protected $fillable = [
        'DivisionID',
        'DepartmentCode',
        'DepartmentName',
        'IsActive',
        'CreatedBy',
        'CreatedDate',
        'UpdatedBy',
        'UpdatedDate',
        'DeletedBy',
        'DeletedDate',
    ];

    protected $casts = [
        'DivisionID' => 'integer',
        'IsActive' => 'boolean',
    ];

    public function division()
    {
        return $this->belongsTo(
            MsDivision::class,
            'DivisionID',
            'DivisionID'
        );
    }
}
