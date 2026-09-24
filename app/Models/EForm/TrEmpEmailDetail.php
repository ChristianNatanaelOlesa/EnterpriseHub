<?php

namespace App\Models\EForm;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrEmpEmailDetail extends BaseModel
{
    protected $table = 'Tr_EmpEmailDetail';
    protected $primaryKey = 'EmpEmailDetailID';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'EmpEmailDetailID', 'EmpEmailID', 'EmailCategory',
        'EmailAddress', 'RequestType', 'DateFrom', 'DateUntil',
        'Purpose', 'Notes', 'InputUser', 'InputDate', 'ModifUser', 'ModifDate',
    ];

    protected $casts = [
        'DateFrom' => 'date',
        'DateUntil' => 'date',
        'InputDate' => 'datetime',
        'ModifDate' => 'datetime',
    ];

    public function empEmail(): BelongsTo
    {
        return $this->belongsTo(
            TrEmpEmail::class,
            'EmpEmailID',
            'EmpEmailID'
        );
    }
}
