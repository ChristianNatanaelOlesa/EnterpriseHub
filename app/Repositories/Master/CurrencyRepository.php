<?php
namespace App\Repositories\Master;
use App\Models\Master\MsCurrency;
use App\Repositories\BaseRepository;
class CurrencyRepository extends BaseRepository
{
 public function __construct(MsCurrency $model){$this->model=$model;}
 public function search(?string $keyword=null,int $perPage=10){return $this->model->when($keyword,function($q)use($keyword){$q->where(function($x)use($keyword){$x->where('CcyID','like',"%{$keyword}%")->orWhere('Currency','like',"%{$keyword}%");});})->whereNull('DeletedDate')->orderBy('Priority')->orderBy('CcyID')->paginate($perPage)->withQueryString();}
 public function findById(string $id){return $this->model->where('CcyID',$id)->whereNull('DeletedDate')->firstOrFail();}
}
