<?php

namespace App\Models\Security;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ScMenu extends BaseModel
{
    protected $table = 'sc_menu';

    protected $primaryKey = 'MenuID';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'Code',
        'Name',
        'MenuArea',
        'ParentID',
        'SortOrder',
        'Route',
        'URL',
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
        'MenuID' => 'integer',
        'ParentID' => 'integer',
        'SortOrder' => 'integer',
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
