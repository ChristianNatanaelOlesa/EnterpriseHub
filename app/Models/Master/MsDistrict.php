<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MsDistrict extends Model
{
    protected $table = 'ms_district';

    protected $primaryKey = 'DistrictID';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'DistrictID',
        'CityID',
        'District',
        'IsActive',
        'InputDate',
        'InputUser',
        'ModifDate',
        'ModifUser',
        'DeletedBy',
        'DeletedDate',
    ];

    protected $casts = [
        'IsActive' => 'boolean',
        'InputDate' => 'datetime',
        'ModifDate' => 'datetime',
        'DeletedDate' => 'datetime',
    ];

    public function city(): BelongsTo
    {
        return $this->belongsTo(
            MsCity::class,
            'CityID',
            'CityID'
        );
    }

    public function villages(): HasMany
    {
        return $this->hasMany(
            MsVillage::class,
            'DistrictID',
            'DistrictID'
        );
    }
}
