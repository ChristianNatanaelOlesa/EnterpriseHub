<?php

namespace App\Models\EForm;

use App\Models\BaseModel;
use App\Models\Concerns\HasEmployeeVisibility;
use App\Models\Master\MsDivision;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class TrEmpNetwork extends BaseModel
{
    use HasEmployeeVisibility;

    protected $table = 'Tr_EmpNetwork';
    protected $primaryKey = 'EmpNetworkID';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'EmpNetworkID','EmpFormID','ReqDate','ReqType',
        'DateFrom','DateUntil','InternetAccess','WLANAccess','VPNAccess',
        'Purpose','Notes','CocID','IsConfirm','QRAppCoc','IsGiven','GivenDate',
        'GivenNote','IsTakeOut','TakeOutDate','TakeOutNote','Status',
        'InputUser','InputDate','ModifUser','ModifDate',
    ];

    protected $casts = [
        'ReqDate' => 'date','DateFrom' => 'date','DateUntil' => 'date',
        'InternetAccess' => 'boolean','WLANAccess' => 'boolean',
        'VPNAccess' => 'boolean','IsConfirm' => 'boolean',
        'IsGiven' => 'boolean','IsTakeOut' => 'boolean',
        'GivenDate' => 'date','TakeOutDate' => 'date',
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
