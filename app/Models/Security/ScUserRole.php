<?php

namespace App\Models\Security;

use App\Models\BaseModel;

class ScUserRole extends BaseModel
{
    protected $table = 'sc_user_role';

    protected $primaryKey = 'UserRoleID';

    protected $fillable = [
        'UserID',
        'RoleID',
        'IsActive',

        'CreatedBy',
        'CreatedDate',

        'UpdatedBy',
        'UpdatedDate',

        'DeletedBy',
        'DeletedDate',
    ];

    protected $casts = [
        'IsActive' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(
            ScUser::class,
            'UserID',
            'UserID'
        );
    }

    public function role()
    {
        return $this->belongsTo(
            ScRole::class,
            'RoleID',
            'RoleID'
        );
    }
}
