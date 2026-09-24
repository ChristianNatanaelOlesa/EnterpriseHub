<?php
namespace App\Models\Master;
use App\Models\BaseModel;
class MsAssetGroup extends BaseModel
{
    protected $table = 'ms_asset_group';
    protected $primaryKey = 'AssGroupID';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['AssGroupID','AssetGroup','ComLifetime','FiscalLifetime','Description','IsActive','InputUser','InputDate','ModifUser','ModifDate','DeletedBy','DeletedDate'];
    protected $casts = ['ComLifetime'=>'decimal:2','FiscalLifetime'=>'decimal:2','IsActive'=>'boolean','InputDate'=>'datetime','ModifDate'=>'datetime','DeletedDate'=>'datetime'];
    public function assetTypes(){ return $this->hasMany(MsAssetType::class,'AssetGroupID','AssGroupID'); }
}
