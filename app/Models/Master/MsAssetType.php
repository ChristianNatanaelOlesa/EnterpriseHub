<?php
namespace App\Models\Master;
use App\Models\BaseModel;
class MsAssetType extends BaseModel
{
    protected $table = 'ms_asset_type';
    protected $primaryKey = 'AssTypeID';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['AssTypeID','AssetGroupID','AssetType','TypeDesc','IsActive','InputUser','InputDate','ModifUser','ModifDate','DeletedBy','DeletedDate'];
    protected $casts = ['IsActive'=>'boolean','InputDate'=>'datetime','ModifDate'=>'datetime','DeletedDate'=>'datetime'];
    public function assetGroup(){ return $this->belongsTo(MsAssetGroup::class,'AssetGroupID','AssGroupID'); }
}
