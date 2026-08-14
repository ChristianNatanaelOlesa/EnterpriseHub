<?php

namespace App\Models\Security;

use App\Models\BaseModel;
use App\Models\Security\ScRoleMenu;

class ScMenu extends BaseModel
{
    protected $table = 'sc_menu';

    public function parent()
    {
        return $this->belongsTo(
            ScMenu::class,
            'ParentID',
            'MenuID'
        );
    }

    public function children()
    {
        return $this->hasMany(
            ScMenu::class,
            'ParentID',
            'MenuID'
        );
    }

    public function role()
    {
        return $this->hasMany(
            ScRoleMenu::class,
            'MenuID',
            'MenuID'
        );
    }
}
