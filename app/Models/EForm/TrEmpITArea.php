<?php

namespace App\Models\EForm;

use App\Models\BaseModel;
use App\Models\Master\MsDivision;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrEmpITArea extends BaseModel
{
    protected $table = 'Tr_EmpITArea';

    protected $primaryKey = 'EmpITAreaID';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'EmpITAreaID',
        'EmpFormID',
        'ReqDivID',
        'ReqUser',
        'ReqDate',
        'ReqType',
        'DateFrom',
        'DateUntil',
        'DataCenter',
        'FingerPrint',
        'Firewall',
        'CCTV',
        'ExtDrive',
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
        'DataCenter' => 'boolean',
        'FingerPrint' => 'boolean',
        'Firewall' => 'boolean',
        'CCTV' => 'boolean',
        'ExtDrive' => 'boolean',
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
