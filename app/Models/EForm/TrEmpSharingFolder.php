<?php

namespace App\Models\EForm;

use App\Models\BaseModel;
use App\Models\Master\MsDivision;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TrEmpSharingFolder extends BaseModel
{
    protected $table = 'Tr_EmpSharingFolder';
    protected $primaryKey = 'EmpSharingFolderID';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'EmpSharingFolderID',
        'EmpFormID',
        'ReqDivID',
        'ReqUser',
        'ReqDate',
        'ReqType',
        'DateFrom',
        'DateUntil',
        'FolderRequestType',
        'Purpose',
        'Notes',
        'CocID',
        'IsConfirm',
        'QRAppCoc',
        'IsGiven',
        'GivenDate',
        'GivenNote',
        'IsTakeOut',
        'TakeOutDate',
        'TakeOutNote',
        'Status',
        'InputUser',
        'InputDate',
        'ModifUser',
        'ModifDate',
    ];

    protected $casts = [
        'ReqDate' => 'date',
        'DateFrom' => 'date',
        'DateUntil' => 'date',
        'GivenDate' => 'date',
        'TakeOutDate' => 'date',
        'IsConfirm' => 'boolean',
        'IsGiven' => 'boolean',
        'IsTakeOut' => 'boolean',
        'InputDate' => 'datetime',
        'ModifDate' => 'datetime',
    ];

    public function empForm(): BelongsTo
    {
        return $this->belongsTo(TrEmpForm::class, 'EmpFormID', 'EmpFormID');
    }

    public function division(): BelongsTo
    {
        return $this->belongsTo(
            MsDivision::class,
            'ReqDivID',
            'DivisionID'
        );
    }

    public function details(): HasMany
    {
        return $this->hasMany(
            TrEmpSharingFolderDetail::class,
            'EmpSharingFolderID',
            'EmpSharingFolderID'
        );
    }
}
