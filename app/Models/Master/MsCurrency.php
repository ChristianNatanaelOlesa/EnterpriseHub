<?php
namespace App\Models\Master;
use App\Models\BaseModel;
class MsCurrency extends BaseModel
{
    protected $table = 'ms_currency';
    protected $primaryKey = 'CcyID';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['CcyID','Currency','Priority','IsActive','InputUser','InputDate','ModifUser','ModifDate','DeletedBy','DeletedDate'];
    protected $casts = ['Priority'=>'integer','IsActive'=>'boolean','InputDate'=>'datetime','ModifDate'=>'datetime','DeletedDate'=>'datetime'];
}
