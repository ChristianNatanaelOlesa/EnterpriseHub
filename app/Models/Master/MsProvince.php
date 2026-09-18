<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MsProvince extends Model
{
    protected $table = 'ms_province';

    protected $primaryKey = 'ProvinceID';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'ProvinceID',
        'CountryID',
        'Province',
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

    public function country(): BelongsTo
    {
        return $this->belongsTo(
            MsCountry::class,
            'CountryID',
            'CountryID'
        );
    }

    public function cities(): HasMany
    {
        return $this->hasMany(
            MsCity::class,
            'ProvinceID',
            'ProvinceID'
        );
    }
}
