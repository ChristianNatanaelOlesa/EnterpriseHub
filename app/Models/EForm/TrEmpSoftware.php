<?php

namespace App\Models\EForm;

use App\Models\BaseModel;
use App\Models\Concerns\HasEmployeeVisibility;
use App\Models\Master\MsDivision;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class TrEmpSoftware extends BaseModel
{
    use HasEmployeeVisibility;

    protected $table = 'Tr_EmpSoftware';
    protected $primaryKey = 'EmpSoftwareID';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'EmpSoftwareID','EmpFormID','ReqDate','ReqType',
        'DateFrom','DateUntil','SoftType','SoftTool','Purpose','Notes','CocID',
        'IsConfirm','QRAppCoc','IsGiven','GivenDate','GivenNote','IsTakeOut',
        'TakeOutDate','TakeOutNote','Status','InputUser','InputDate','ModifUser',
        'ModifDate',
    ];

    protected $casts = [
        'ReqDate' => 'date','DateFrom' => 'date','DateUntil' => 'date',
        'IsConfirm' => 'boolean','GivenDate' => 'date','IsGiven' => 'boolean',
        'IsTakeOut' => 'boolean','TakeOutDate' => 'date',
        'InputDate' => 'datetime','ModifDate' => 'datetime',
    ];

    public function empForm(): BelongsTo
    {
        return $this->belongsTo(
            TrEmpForm::class,
            'EmpFormID',
            'EmpFormID'
        );
    }

    public function division(): HasOneThrough
    {
        return $this->hasOneThrough(MsDivision::class, TrEmpFormHist::class, 'EmpFormID', 'DivID', 'EmpFormID', 'DivID')
            ->where('Tr_EmpFormHist.IsActive', true)->orderByDesc('Tr_EmpFormHist.EffectiveDate');
    }

}
