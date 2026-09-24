<?php
namespace App\Models\Master;
use App\Models\BaseModel;
class MsAsset extends BaseModel
{
    protected $table = 'ms_asset';
    protected $primaryKey = 'AssetID';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['AssetID','AssTypeID','QRCode','AssetDesc','Brand','Model','SerialNo','Color','Specification','Notes','VendorID','PurchaseDate','CcyID','ExchRate','AcqCost','AcqCostIDR','IsWarranty','WarrantyDate','IsISO','IsActive','InputUser','InputDate','ModifUser','ModifDate','DeletedBy','DeletedDate'];
    protected $casts = ['PurchaseDate'=>'date','ExchRate'=>'decimal:4','AcqCost'=>'decimal:2','AcqCostIDR'=>'decimal:2','IsWarranty'=>'boolean','WarrantyDate'=>'date','IsISO'=>'boolean','IsActive'=>'boolean','InputDate'=>'datetime','ModifDate'=>'datetime','DeletedDate'=>'datetime'];
    public function assetType(){ return $this->belongsTo(MsAssetType::class,'AssTypeID','AssTypeID'); }
    public function currency(){ return $this->belongsTo(MsCurrency::class,'CcyID','CcyID'); }
}
