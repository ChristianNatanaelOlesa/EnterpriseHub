<?php
namespace App\Repositories\Master;
use App\Models\Master\MsAsset;
use App\Repositories\BaseRepository;
class AssetRepository extends BaseRepository
{
 public function __construct(MsAsset $model){$this->model=$model;}
 public function search(?string $keyword=null,int $perPage=10){return $this->model->with(['assetType','currency'])->when($keyword,function($q)use($keyword){$q->where(function($x)use($keyword){foreach(['AssetID','AssTypeID','QRCode','AssetDesc','Brand','Model','SerialNo','Color','Specification','Notes','VendorID','CcyID'] as $c){$x->orWhere($c,'like',"%{$keyword}%");}});})->whereNull('DeletedDate')->orderBy('AssetID')->paginate($perPage)->withQueryString();}
 public function findById(string $id){return $this->model->with(['assetType','currency'])->where('AssetID',$id)->whereNull('DeletedDate')->firstOrFail();}
}
