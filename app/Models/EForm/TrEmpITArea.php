<?php

namespace App\Models\EForm;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrEmpITArea extends BaseModel
{
    protected $table = 'Tr_EmpITArea';
    protected $primaryKey = 'EmpITAreaID';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['EmpITAreaID', 'EmpFormID', 'SourceType', 'EmailOnTablet', 'EmailOnPhone', 'Fingerprint', 'CCTV', 'Firewall', 'ExternalDrive', 'DataCenter', 'Status', 'InputUser', 'InputDate', 'ModifUser', 'ModifDate'];

    protected $casts = [
        'EmailOnTablet' => 'boolean',
        'EmailOnPhone' => 'boolean',
        'Fingerprint' => 'boolean',
        'CCTV' => 'boolean',
        'Firewall' => 'boolean',
        'ExternalDrive' => 'boolean',
        'DataCenter' => 'boolean',
        'InputDate' => 'datetime',
        'ModifDate' => 'datetime',
    ];

    public function empForm(): BelongsTo
    {
        return $this->belongsTo(TrEmpForm::class, 'EmpFormID', 'EmpFormID');
    }
}
