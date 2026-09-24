<?php

namespace App\Models\Security;

use Illuminate\Database\Eloquent\Model;

class ScRole extends Model
{
    protected $table = 'sc_role';

    protected $primaryKey = 'RoleID';

    public $timestamps = false;

    protected $fillable = [
        'Code',
        'Name',
        'Description',
        'IsActive',
        'InputUser',
        'InputDate',
        'ModifUser',
        'ModifDate',
        'DeletedBy',
        'DeletedDate',
    ];

    public function menus()
    {
        return $this->hasMany(
            ScRoleMenu::class,
            'RoleID',
            'RoleID'
        );
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
