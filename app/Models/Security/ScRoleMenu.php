<?php

namespace App\Models\Security;

use App\Models\BaseModel;

class ScRoleMenu extends BaseModel
{
    protected $table = 'sc_role_menu';

    protected $primaryKey = 'RoleMenuID';

    protected $fillable = [

        'RoleID',
        'MenuID',

        'CanOpen',
        'CanAdd',
        'CanEdit',
        'CanDelete',
        'CanPrint',
        'CanExport',
        'CanApprove',

        'IsActive',

        'InputUser',
        'InputDate',

        'ModifUser',
        'ModifDate',

        'DeletedBy',
        'DeletedDate',

    ];

    protected $casts = [

        'CanOpen'    => 'boolean',
        'CanAdd'     => 'boolean',
        'CanEdit'    => 'boolean',
        'CanDelete'  => 'boolean',
        'CanPrint'   => 'boolean',
        'CanExport'  => 'boolean',
        'CanApprove' => 'boolean',
        'IsActive'   => 'boolean',

    ];

    public function role()
    {
        return $this->belongsTo(
            ScRole::class,
            'RoleID',
            'RoleID'
        );
    }

    public function menu()
    {
        return $this->belongsTo(
            ScMenu::class,
            'MenuID',
            'MenuID'
        );
    }
}
