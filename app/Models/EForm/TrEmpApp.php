<?php

namespace App\Models\EForm;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrEmpApp extends BaseModel
{
    protected $table = 'Tr_EmpApp';

    protected $primaryKey = 'EmpAppID';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'EmpAppID',
        'EmpFormID',
        'ReqDivID',
        'ReqUser',
        'ReqDate',
        'ReqType',
        'Purpose',
        'DateFrom',
        'DateUntil',
        'UserLogin',
        'UserPassword',
        'AccessType',
        'AppType',
        'AppName',
        'URL',
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
        'InputDate',
        'InputUser',
        'ModifDate',
        'ModifUser',
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
}
