<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MsCountry extends Model
{
    protected $table = 'ms_country';

    protected $primaryKey = 'CountryID';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'CountryID',
        'Country',
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

    public function provinces(): HasMany
    {
        return $this->hasMany(
            MsProvince::class,
            'CountryID',
            'CountryID'
        );
    }
}
