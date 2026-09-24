<?php

namespace App\Models\Master;

use App\Models\BaseModel;
use App\Models\Master\MsDivision;

class MsEmailGroup extends BaseModel
{
    protected $table = 'ms_email_group';

    protected $primaryKey = 'EmailGroupID';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'EmailGroupID',
        'DivisionID',
        'Email',
        'Description',
        'IsGroup',
        'IsActive',
        'InputUser',
        'InputDate',
        'ModifUser',
        'ModifDate',
        'DeletedBy',
        'DeletedDate',
    ];

    public function division()
    {
        return $this->belongsTo(MsDivision::class, 'DivisionID', 'DivisionID');
    }

    protected $casts = [
        'IsGroup' => 'boolean',
        'IsActive' => 'boolean',
        'InputDate' => 'datetime',
        'ModifDate' => 'datetime',
        'DeletedDate' => 'datetime',
        'DivisionID' => 'integer',
    ];
}
