<?php

namespace App\Models\Security;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class ScUser extends Authenticatable
{
    use Notifiable;

    protected $table = 'sc_user';

    protected $primaryKey = 'ID';

    public $timestamps = false;

    protected $guarded = [];

    protected $hidden = [
        'Password',
    ];

    /**
     * Password Column
     */
    public function getAuthPassword()
    {
        return $this->Password;
    }

    /**
     * Username Column
     */
    public function getAuthIdentifierName()
    {
        return 'Username';
    }
}
