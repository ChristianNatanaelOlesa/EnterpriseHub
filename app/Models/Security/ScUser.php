<?php

namespace App\Models\Security;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class ScUser extends Authenticatable
{
    use Notifiable;

    protected $table = 'sc_user';

    protected $primaryKey = 'UserID';

    public $timestamps = false;

    protected $fillable = [
        'EmpFormID',
        'Username',
        'FullName',
        'Password',
        'RoleID',
        'Email',
        'PhoneNumber',
        'Photo',
        'LastLogin',
        'IsActive',
        'InputUser',
        'InputDate',
        'ModifUser',
        'ModifDate',
        'DeletedBy',
        'DeletedDate',
    ];

    protected $hidden = [
        'Password',
    ];

    public function getAuthPassword()
    {
        return $this->Password;
    }

    public function getAuthIdentifierName()
    {
        return 'Username';
    }

    public function employeeForm()
    {
        return $this->belongsTo(\App\Models\EForm\TrEmpForm::class, 'EmpFormID', 'EmpFormID');
    }

    public function roles()
    {
        return $this->belongsToMany(
            ScRole::class,
            'sc_user_role',
            'UserID',
            'RoleID'
        )->withPivot('IsActive');
    }

    public function activeRoles()
    {
        return $this->roles()
            ->wherePivot('IsActive', true)
            ->where('sc_role.IsActive', true)
            ->whereNull('sc_role.DeletedDate');
    }
}
