<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MsCity extends Model
{
    protected $table = 'ms_city';

    protected $primaryKey = 'CityID';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'CityID',
        'ProvinceID',
        'City',
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

    public function province(): BelongsTo
    {
        return $this->belongsTo(
            MsProvince::class,
            'ProvinceID',
            'ProvinceID'
        );
    }

    public function districts(): HasMany
    {
        return $this->hasMany(
            MsDistrict::class,
            'CityID',
            'CityID'
        );
    }
}
