<?php

namespace App\Models\EForm;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrEmpSoftware extends BaseModel
{
    protected $table = 'Tr_EmpSoftware';
    protected $primaryKey = 'EmpSoftwareID';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['EmpSoftwareID', 'EmpFormID', 'SourceType', 'SoftwareName', 'Version', 'LicenseType', 'Quantity', 'Notes', 'Status', 'InputUser', 'InputDate', 'ModifUser', 'ModifDate'];

    protected $casts = [
        'InputDate' => 'datetime',
        'ModifDate' => 'datetime',
    ];

    public function empForm(): BelongsTo
    {
        return $this->belongsTo(TrEmpForm::class, 'EmpFormID', 'EmpFormID');
    }
}
