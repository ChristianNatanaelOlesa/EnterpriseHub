<?php

namespace App\Models\EForm;

use App\Models\BaseModel;
use App\Models\Master\MsDepartment;
use App\Models\Master\MsDirectorate;
use App\Models\Master\MsDivision;
use App\Models\Master\MsJobLevel;
use App\Models\Master\MsJobTitle;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TrEmpFormHist extends BaseModel
{
    protected $table = 'tr_empformhist';

    protected $primaryKey = 'EmpFormHistID';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'EmpFormHistID',
        'EmpFormID',

        'CompID',
        'DirID',
        'DivID',
        'DeptID',

        'JobLvlID',
        'JobTitleID',

        'ReportTo',
        'EmpStatus',

        'EffectiveDate',
        'Remarks',

        'ReqDate',

        'IsActive',

        'QRApp',
        'Status',

        'InputUser',
        'InputDate',
        'ModifUser',
        'ModifDate',
    ];

    protected $casts = [
        'JobLvlID' => 'integer',
        'JobTitleID' => 'integer',

        'EffectiveDate' => 'date',
        'ReqDate' => 'date',

        'IsActive' => 'boolean',

        'InputDate' => 'datetime',
        'ModifDate' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Employee Form
    |--------------------------------------------------------------------------
    */

    public function empForm(): BelongsTo
    {
        return $this->belongsTo(
            TrEmpForm::class,
            'EmpFormID',
            'EmpFormID'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Organization
    |--------------------------------------------------------------------------
    */

    public function directorate(): BelongsTo
    {
        return $this->belongsTo(
            MsDirectorate::class,
            'DirID',
            'DirID'
        );
    }

    public function division(): BelongsTo
    {
        return $this->belongsTo(
            MsDivision::class,
            'DivID',
            'DivID'
        );
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(
            MsDepartment::class,
            'DeptID',
            'DeptID'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Job
    |--------------------------------------------------------------------------
    */

    public function jobLevel(): BelongsTo
    {
        return $this->belongsTo(
            MsJobLevel::class,
            'JobLvlID',
            'JobLevelID'
        );
    }

    public function jobTitle(): BelongsTo
    {
        return $this->belongsTo(
            MsJobTitle::class,
            'JobTitleID',
            'JobTitleID'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Workflow Action
    |--------------------------------------------------------------------------
    */

    public function actions(): HasMany
    {
        return $this->hasMany(
            TrEmpFormAction::class,
            'EmpFormHistID',
            'EmpFormHistID'
        );
    }
}
