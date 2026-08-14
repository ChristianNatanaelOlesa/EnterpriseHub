<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\AuditTrail;

class BaseModel extends Model
{
    use AuditTrail;

    public $timestamps = false;

    protected $guarded = [];

    protected $auditColumns = true;
}
