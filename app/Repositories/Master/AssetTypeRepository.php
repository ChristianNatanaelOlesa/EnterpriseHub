<?php
namespace App\Repositories\Master;
use App\Models\Master\MsAssetType;
use App\Repositories\BaseRepository;
class AssetTypeRepository extends BaseRepository
{
 public function __construct(MsAssetType $model){$this->model=$model;}
 public function search(?string $keyword=null,int $perPage=10){return $this->model->with('assetGroup')->when($keyword,function($q)use($keyword){$q->where(function($x)use($keyword){$x->where('AssTypeID','like',"%{$keyword}%")->orWhere('AssetGroupID','like',"%{$keyword}%")->orWhere('AssetType','like',"%{$keyword}%")->orWhere('TypeDesc','like',"%{$keyword}%");});})->whereNull('DeletedDate')->orderBy('AssTypeID')->paginate($perPage)->withQueryString();}
 public function findById(string $id){return $this->model->with('assetGroup')->where('AssTypeID',$id)->whereNull('DeletedDate')->firstOrFail();}
}
