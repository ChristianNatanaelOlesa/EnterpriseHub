<?php
namespace App\Models\EForm;
use App\Models\BaseModel;
use App\Models\Master\MsAsset;
class TrEmpEquip extends BaseModel
{
    protected $table='Tr_EmpEquip';
    protected $primaryKey='EmpEquipID';
    public $incrementing=false;
    protected $keyType='string';
    protected $fillable=['EmpEquipID','EmpFormID','ReqDivID','ReqUser','ReqDate','ReqType','Purpose','AssetID','DateFrom','DateUntil','IsGiven','GivenDate','GivenNote','IsReturn','ReturnDate','ReturnNote','CocID','IsConfirm','QRAppCoc','Status','InputUser','InputDate','ModifUser','ModifDate'];
    protected $casts=['ReqDate'=>'date','DateFrom'=>'date','DateUntil'=>'date','IsGiven'=>'boolean','GivenDate'=>'date','IsReturn'=>'boolean','ReturnDate'=>'date','IsConfirm'=>'boolean','InputDate'=>'datetime','ModifDate'=>'datetime'];
    public function empForm(){return $this->belongsTo(TrEmpForm::class,'EmpFormID','EmpFormID');}
    public function asset(){return $this->belongsTo(MsAsset::class,'AssetID','AssetID');}
}
