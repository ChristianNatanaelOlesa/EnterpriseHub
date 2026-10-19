<?php

namespace App\Models\Security;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ScMenu extends BaseModel
{
    protected $table = 'sc_menu';

    protected $primaryKey = 'MenuID';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'MenuID',
        'Menu',
        'Description',
        'MenuArea',
        'ParentID',
        'Lvl',
        'SortOrder',
        'Route',
        'Icon',
        'IsActive',
        'IsMenu',

        'InputUser',
        'InputDate',
        'ModifUser',
        'ModifDate',
        'DeletedBy',
        'DeletedDate',
    ];

    protected $casts = [
        'SortOrder' => 'integer',
        'Lvl' => 'integer',
        'IsActive' => 'boolean',
        'IsMenu' => 'boolean',

        'InputDate' => 'datetime',
        'ModifDate' => 'datetime',
        'DeletedDate' => 'datetime',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(
            self::class,
            'ParentID',
            'MenuID'
        );
    }

    public function children(): HasMany
    {
        return $this->hasMany(
            self::class,
            'ParentID',
            'MenuID'
        );
    }
}
