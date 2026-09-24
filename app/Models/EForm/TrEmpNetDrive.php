<?php

namespace App\Models\EForm;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrEmpNetDrive extends BaseModel
{
    protected $table = 'Tr_EmpNetDrive';
    protected $primaryKey = 'EmpNetDriveID';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['EmpNetDriveID', 'EmpFormID', 'SourceType', 'DriveName', 'DrivePath', 'AccessType', 'Notes', 'Status', 'InputUser', 'InputDate', 'ModifUser', 'ModifDate'];

    protected $casts = [
        'InputDate' => 'datetime',
        'ModifDate' => 'datetime',
    ];

    public function empForm(): BelongsTo
    {
        return $this->belongsTo(TrEmpForm::class, 'EmpFormID', 'EmpFormID');
    }
}
