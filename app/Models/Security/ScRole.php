<?php

namespace App\Models\Security;

use Illuminate\Database\Eloquent\Model;

class ScRole extends Model
{
    protected $table = 'sc_role';

    protected $primaryKey = 'RoleID';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'RoleID',
        'Role',
        'Description',
        'IsActive',
        'InputUser',
        'InputDate',
        'ModifUser',
        'ModifDate',
        'DeletedBy',
        'DeletedDate',
    ];

    public function menuPermissions()
    {
        return $this->hasMany(ScRolePermission::class, 'RoleID', 'RoleID');
    }

    public function users()
    {
        return $this->belongsToMany(
            ScUser::class,
            'sc_user_role',
            'RoleID',
            'UserID'
        )->withPivot('IsActive');
    }
}
