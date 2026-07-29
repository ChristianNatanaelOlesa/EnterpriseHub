<?php

namespace App\Models\Models\Security;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;
use App\Models\Security\ScUser;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ScRole extends BaseModel
{
    protected $table = 'sc_role';

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(
            ScUser::class,
            'sc_user_role',
            'RoleID',
            'UserID'
        );
    }
}
