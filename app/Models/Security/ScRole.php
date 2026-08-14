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
        'CreatedBy',
        'CreatedDate',
        'UpdatedBy',
        'UpdatedDate',
        'DeletedBy',
        'DeletedDate',
    ];
}
