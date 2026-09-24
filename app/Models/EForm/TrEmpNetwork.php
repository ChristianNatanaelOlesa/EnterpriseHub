<?php

namespace App\Models\EForm;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrEmpNetwork extends BaseModel
{
    protected $table = 'Tr_EmpNetwork';
    protected $primaryKey = 'EmpNetworkID';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['EmpNetworkID', 'EmpFormID', 'SourceType', 'WLAN', 'Internet', 'VPN', 'Status', 'InputUser', 'InputDate', 'ModifUser', 'ModifDate'];

    protected $casts = [
        'WLAN' => 'boolean',
        'Internet' => 'boolean',
        'VPN' => 'boolean',
        'InputDate' => 'datetime',
        'ModifDate' => 'datetime',
    ];

    public function empForm(): BelongsTo
    {
        return $this->belongsTo(TrEmpForm::class, 'EmpFormID', 'EmpFormID');
    }
}
