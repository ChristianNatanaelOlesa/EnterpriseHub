<?php

namespace App\Models\EForm;

use App\Models\BaseModel;
use App\Models\Concerns\HasEmployeeVisibility;

class TrEmpEmail extends BaseModel
{
    use HasEmployeeVisibility;

    protected $table = 'Tr_EmpEmail';
    protected $primaryKey = 'EmpEmailID';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'EmpEmailID','EmpFormID','ReqDate','ReqType',
        'EmailType','Email','Purpose','DateFrom','DateUntil','Notes','CocID',
        'IsConfirm','QRAppCoc','IsGiven','GivenDate','GivenNote','IsTakeOut',
        'TakeOutDate','TakeOutNote','Status','InputUser','InputDate',
        'ModifUser','ModifDate',
    ];

    protected $casts = [
        'ReqDate' => 'datetime','DateFrom' => 'date','DateUntil' => 'date',
        'InputDate' => 'datetime','ModifDate' => 'datetime',
    ];

    public function empForm()
    {
        return $this->belongsTo(
            TrEmpForm::class,
            'EmpFormID',
            'EmpFormID'
        );
    }
}
