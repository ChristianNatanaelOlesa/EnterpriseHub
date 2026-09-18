<?php

namespace App\Models\Security;

use App\Models\BaseModel;

class ScMenu extends BaseModel
{
    protected $table = 'sc_menu';

    protected $primaryKey = 'MenuID';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'Code',
        'Name',
        'ParentID',
        'SortOrder',
        'Route',
        'URL',
        'Icon',
        'IsActive',
        'IsMenu',

        'CreatedBy',
        'CreatedDate',
        'UpdatedBy',
        'UpdatedDate',
        'DeletedBy',
        'DeletedDate',
    ];

    protected $casts = [
        'MenuID' => 'integer',
        'ParentID' => 'integer',
        'SortOrder' => 'integer',
        'IsActive' => 'boolean',
        'IsMenu' => 'boolean',

        'CreatedDate' => 'datetime',
        'UpdatedDate' => 'datetime',
        'DeletedDate' => 'datetime',
    ];

    public function parent()
    {
        return $this->belongsTo(
            self::class,
            'ParentID',
            'MenuID'
        );
    }

    public function children()
    {
        return $this->hasMany(
            self::class,
            'ParentID',
            'MenuID'
        );
    }
}
