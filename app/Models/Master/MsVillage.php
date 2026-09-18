<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MsVillage extends Model
{
    protected $table = 'ms_village';

    protected $primaryKey = 'VillageID';

    public $incrementing = false;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'VillageID',
        'DistrictID',
        'Village',
        'PostalCode',
        'IsActive',
        'InputDate',
        'InputUser',
        'ModifDate',
        'ModifUser',
        'DeletedBy',
        'DeletedDate',
    ];

    protected $casts = [
        'VillageID' => 'integer',
        'IsActive' => 'boolean',
        'InputDate' => 'datetime',
        'ModifDate' => 'datetime',
        'DeletedDate' => 'datetime',
    ];

    public function district(): BelongsTo
    {
        return $this->belongsTo(
            MsDistrict::class,
            'DistrictID',
            'DistrictID'
        );
    }
}
