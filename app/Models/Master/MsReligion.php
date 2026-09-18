<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class MsReligion extends Model
{
    protected $table = 'ms_religion';

    protected $primaryKey = 'ReligionID';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'ReligionID',
        'Religion',
        'IsActive',
        'InputDate',
        'InputUser',
        'ModifDate',
        'ModifUser',
    ];

    protected $casts = [
        'IsActive' => 'boolean',
        'InputDate' => 'datetime',
        'ModifDate' => 'datetime',
    ];
}
