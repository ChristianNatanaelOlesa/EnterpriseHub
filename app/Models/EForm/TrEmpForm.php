<?php

namespace App\Models\EForm;

use App\Models\BaseModel;
use App\Models\Master\MsReligion;
use App\Models\Master\MsVillage;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TrEmpForm extends BaseModel
{
    protected $table = 'Tr_EmpForm';

    protected $primaryKey = 'EmpFormID';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'EmpFormID',
        'FirstName',
        'LastName',
        'MobileNo',
        'BirthDate',
        'NIP',
        'MaritalStatus',
        'ReligionID',
        'JoinDate',
        'VillageID',
        'Address',
        'Email',
        'InputUser',
        'InputDate',
        'ModifUser',
        'ModifDate',
    ];

    protected $casts = [
        'BirthDate' => 'date',
        'JoinDate' => 'date',
        'VillageID' => 'integer',
        'InputDate' => 'datetime',
        'ModifDate' => 'datetime',
    ];

    public function histories(): HasMany
    {
        return $this->hasMany(
            TrEmpFormHist::class,
            'EmpFormID',
            'EmpFormID'
        );
    }

    public function religion(): BelongsTo
    {
        return $this->belongsTo(
            MsReligion::class,
            'ReligionID',
            'ReligionID'
        );
    }

    public function village(): BelongsTo
    {
        return $this->belongsTo(
            MsVillage::class,
            'VillageID',
            'VillageID'
        );
    }
}
