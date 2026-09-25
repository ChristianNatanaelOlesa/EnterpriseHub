<?php

namespace App\Models\EForm;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Master\MsDivision;

class TrEmpSoftware extends BaseModel
{
    protected $table = 'Tr_EmpSoftware';
    protected $primaryKey = 'EmpSoftwareID';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'EmpSoftwareID',
        'EmpFormID',
        'ReqDivID',
        'ReqUser',
        'ReqDate',
        'ReqType',
        'DateFrom',
        'DateUntil',
        'SoftType',
        'SoftTool',
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
        'IsGiven' => 'boolean',
        'GivenDate' => 'date',
        'IsTakeOut' => 'boolean',
        'TakeOutDate' => 'date',
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
