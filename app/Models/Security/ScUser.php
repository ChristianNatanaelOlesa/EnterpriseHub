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
        'Username',
        'FullName',
        'Password',
        'RoleID',
        'Email',
        'PhoneNumber',
        'Photo',
        'LastLogin',
        'IsActive',
        'CreatedBy',
        'CreatedDate',
        'UpdatedBy',
        'UpdatedDate',
        'DeletedBy',
        'DeletedDate',
    ];

    protected $hidden = [
        'Password',
    ];

    /**
     * Laravel akan mengambil password dari kolom Password
     */
    public function getAuthPassword()
    {
        return $this->Password;
    }

    /**
     * Username login menggunakan kolom Username
     */
    public function getAuthIdentifierName()
    {
        return 'Username';
    }

    // Relationship di bawah tetap seperti yang sudah Anda buat
}
