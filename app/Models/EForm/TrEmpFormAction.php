<?php

namespace App\Models\EForm;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrEmpFormAction extends BaseModel
{
    protected $table = 'Tr_EmpFormAction';

    protected $primaryKey = 'EmpFormActionID';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'EmpFormActionID',
        'EmpFormHistID',
        'ActionID',
        'TransitionID',
        'Comments',
        'IsActive',
        'IsComplete',
        'CompletedBy',
        'DueDateOrg',
        'DueDate',
        'ApvDate',
        'QRCodeLoc',
        'Keys',
        'EncryptQRCode',
        'InputDate',
        'InputUser',
        'ModifDate',
        'ModifUser',
    ];

    protected $casts = [
        'IsActive' => 'boolean',
        'IsComplete' => 'boolean',
        'DueDateOrg' => 'date',
        'DueDate' => 'date',
        'ApvDate' => 'date',
        'InputDate' => 'datetime',
        'ModifDate' => 'datetime',
    ];

    public function empFormHist(): BelongsTo
    {
        return $this->belongsTo(
            TrEmpFormHist::class,
            'EmpFormHistID',
            'EmpFormHistID'
        );
    }
}
