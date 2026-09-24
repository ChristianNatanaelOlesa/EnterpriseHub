<?php
namespace App\Repositories\EForm;
use App\Models\EForm\TrEmpEquip;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
class EmpEquipRepository
{
    public function __construct(protected TrEmpEquip $model) {}
    public function getAll(?string $search=null,int $perPage=10):LengthAwarePaginator
    {
        return $this->model->newQuery()->with(['empForm','asset.assetType'])
            ->when($search,function($query)use($search){$like="%{$search}%";$query->where(function($q)use($like){
                $q->where('EmpEquipID','like',$like)->orWhere('EmpFormID','like',$like)->orWhere('ReqDivID','like',$like)->orWhere('ReqUser','like',$like)->orWhere('ReqType','like',$like)->orWhere('Purpose','like',$like)->orWhere('AssetID','like',$like)->orWhere('Status','like',$like)
                ->orWhereHas('asset',function($a)use($like){$a->where('AssetDesc','like',$like)->orWhere('Brand','like',$like)->orWhere('Model','like',$like)->orWhere('SerialNo','like',$like)->orWhereHas('assetType',fn($t)=>$t->where('AssetType','like',$like));})
                ->orWhereHas('empForm',function($e)use($like){$e->where('FirstName','like',$like)->orWhere('LastName','like',$like)->orWhere('NIP','like',$like);})
                ->orWhereRaw("DATE_FORMAT(ReqDate,'%Y-%m-%d') LIKE ?",[$like])->orWhereRaw("DATE_FORMAT(DateFrom,'%Y-%m-%d') LIKE ?",[$like])->orWhereRaw("DATE_FORMAT(DateUntil,'%Y-%m-%d') LIKE ?",[$like]);
            });})->orderByDesc('InputDate')->orderByDesc('EmpEquipID')->paginate($perPage)->withQueryString();
    }
    public function find(string $id):?TrEmpEquip{return $this->model->newQuery()->with(['empForm','asset.assetType'])->find($id);}
    public function create(array $data):TrEmpEquip{return $this->model->newQuery()->create($data);}
    public function update(string $id,array $data):bool{$m=$this->model->newQuery()->find($id);return $m?$m->update($data):false;}
    public function delete(string $id):bool{$m=$this->model->newQuery()->find($id);return $m?$m->delete():false;}
}
