<?php

namespace App\Models\Security;

use App\Models\BaseModel;
use App\Models\Security\ScUser;
use App\Models\Master\MsCompany;

class ScUserComp extends BaseModel
{
    protected $table = 'sc_user_comp';

    public function user()
    {
        return $this->belongsTo(ScUser::class, 'UserID', 'UserID');
    }

    public function company()
    {
        return $this->belongsTo(MsCompany::class, 'CompanyID', 'CompanyID');
    }
}
