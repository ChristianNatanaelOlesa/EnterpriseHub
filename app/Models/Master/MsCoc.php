<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class MsCoc extends Model
{
    protected $table = 'Ms_Coc';
    protected $primaryKey = 'CocID';
    public $incrementing = false;
    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'CocID',
        'Name',
        'Description',
        'Contents',
        'StartDate',
        'EndDate',
        'FileLoc',
        'InputDate',
        'InputUser',
        'ModifDate',
        'ModifUser',
    ];

    protected $casts = [
        'StartDate' => 'date',
        'EndDate' => 'date',
        'InputDate' => 'datetime',
        'ModifDate' => 'datetime',
    ];
}
