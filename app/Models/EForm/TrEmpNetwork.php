<?php

namespace App\Models\EForm;

use App\Models\BaseModel;
use App\Models\Master\MsDivision;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrEmpNetwork extends BaseModel
{
    protected $table = 'Tr_EmpNetwork';

    protected $primaryKey = 'EmpNetworkID';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'EmpNetworkID',
        'EmpFormID',
        'ReqDivID',
        'ReqUser',
        'ReqDate',
        'ReqType',
        'DateFrom',
        'DateUntil',
        'InternetAccess',
        'WLANAccess',
        'VPNAccess',
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

        'InternetAccess' => 'boolean',
        'WLANAccess' => 'boolean',
        'VPNAccess' => 'boolean',

        'IsConfirm' => 'boolean',
        'IsGiven' => 'boolean',
        'IsTakeOut' => 'boolean',

        'GivenDate' => 'date',
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
