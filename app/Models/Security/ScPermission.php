<?php

namespace App\Models\Security;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ScPermission extends BaseModel
{
    protected $table = 'sc_permission';
    protected $primaryKey = 'PermissionID';

    protected $fillable = [
        'Name', 'IsActive', 'InputUser', 'InputDate',
        'ModifUser', 'ModifDate', 'DeletedBy', 'DeletedDate',
    ];

    protected $casts = ['IsActive' => 'boolean'];

    public function menuPermissions(): HasMany
    {
        return $this->hasMany(ScMenuPermission::class, 'PermissionID', 'PermissionID');
    }
}
