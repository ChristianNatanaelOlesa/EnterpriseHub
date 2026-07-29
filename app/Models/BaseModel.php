<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model
{
    /**
     * Primary Key
     */
    protected $primaryKey = 'ID';

    /**
     * Laravel Timestamp
     */
    public $timestamps = false;

    /**
     * Guarded
     */
    protected $guarded = [];

    /**
     * Incrementing
     */
    public $incrementing = true;

    /**
     * Key Type
     */
    protected $keyType = 'int';
}
