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
    protected $table = 'Tr_EmpFormHist';

    protected $primaryKey = 'EmpFormHistID';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'EmpFormHistID',
        'EmpFormID',

        'DirID',
        'DivID',
        'DeptID',

        'JobLvlID',
        'JobTitleID',

        'ReportTo',
        'EmpStatus',

        'EffectiveDate',
        'Remarks',

        'ReqUser',
        'ReqDate',

        'IsActive',

        'QRApp',
        'Status',
        'UserID',
        'ProcessID',
        'CurrentStateID',

        'InputUser',
        'InputDate',
        'ModifUser',
        'ModifDate',
    ];

    protected $casts = [
        'DirID' => 'integer',
        'DivID' => 'integer',
        'DeptID' => 'integer',

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
            'DirectorateID'
        );
    }

    public function division(): BelongsTo
    {
        return $this->belongsTo(
            MsDivision::class,
            'DivID',
            'DivisionID'
        );
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(
            MsDepartment::class,
            'DeptID',
            'DepartmentID'
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
