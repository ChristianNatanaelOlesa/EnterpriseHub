<?php

namespace App\Models\Security;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScRolePermission extends BaseModel
{
    protected $table = 'sc_role_permission';
    protected $primaryKey = 'RolePermissionID';

    protected $fillable = [
        'RoleID', 'MenuPermissionID', 'IsActive', 'InputUser', 'InputDate',
        'ModifUser', 'ModifDate', 'DeletedBy', 'DeletedDate',
    ];

    protected $casts = ['MenuPermissionID' => 'integer', 'IsActive' => 'boolean'];

    public function role(): BelongsTo { return $this->belongsTo(ScRole::class, 'RoleID', 'RoleID'); }
    public function menuPermission(): BelongsTo { return $this->belongsTo(ScMenuPermission::class, 'MenuPermissionID', 'MenuPermissionID'); }
}
