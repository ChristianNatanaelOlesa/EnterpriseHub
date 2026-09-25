<?php

namespace App\Models\EForm;

use App\Models\BaseModel;
use App\Models\Master\MsDivision;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrEmpInfra extends BaseModel
{
    protected $table = 'Tr_EmpInfra';

    protected $primaryKey = 'EmpInfraID';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'EmpInfraID',
        'EmpFormID',
        'ReqDivID',
        'ReqUser',
        'ReqDate',
        'ReqType',
        'DateFrom',
        'DateUntil',
        'AccessType',
        'AccessArea',
        'UserLogin',
        'Purpose',
        'Notes',
        'CocID',
        'IsConfirm',
        'QRAppCoc',
        'IsGiven',
        'GivenDate',
        'GivenNote',
        'IsTakeOut',
        'TakeOutDate',
        'TakeOutNote',
        'Status',
        'InputUser',
        'InputDate',
        'ModifUser',
        'ModifDate',
    ];

    protected $casts = [
        'ReqDate' => 'date',
        'DateFrom' => 'date',
        'DateUntil' => 'date',
        'IsConfirm' => 'boolean',
        'GivenDate' => 'date',
        'IsGiven' => 'boolean',
        'TakeOutDate' => 'date',
        'IsTakeOut' => 'boolean',
        'InputDate' => 'datetime',
        'ModifDate' => 'datetime',
    ];

    public function empForm(): BelongsTo
    {
        return $this->belongsTo(
            TrEmpForm::class,
            'EmpFormID',
            'EmpFormID'
        );
    }

    public function division(): BelongsTo
    {
        return $this->belongsTo(
            MsDivision::class,
            'ReqDivID',
            'DivisionID'
        );
    }
}
