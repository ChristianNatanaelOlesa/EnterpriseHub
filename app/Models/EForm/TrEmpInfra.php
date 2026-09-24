<?php

namespace App\Models\EForm;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrEmpInfra extends BaseModel
{
    protected $table = 'Tr_EmpInfra';
    protected $primaryKey = 'EmpInfraID';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['EmpInfraID', 'EmpFormID', 'SourceType', 'InfrastructureType', 'Description', 'Status', 'InputUser', 'InputDate', 'ModifUser', 'ModifDate'];

    protected $casts = [
        'InputDate' => 'datetime',
        'ModifDate' => 'datetime',
    ];

    public function empForm(): BelongsTo
    {
        return $this->belongsTo(TrEmpForm::class, 'EmpFormID', 'EmpFormID');
    }
}
