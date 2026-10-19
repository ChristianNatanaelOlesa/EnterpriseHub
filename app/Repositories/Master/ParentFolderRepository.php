<?php
namespace App\Repositories\Master;
use App\Models\Master\MsParentFolder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
class ParentFolderRepository
{
    public function __construct(protected MsParentFolder $model) {}
    public function getAll(?string $search=null,int $perPage=10): LengthAwarePaginator {
        return $this->model->newQuery()->withCount('folderPaths')
            ->when($search,function($q)use($search){$like="%{$search}%";$q->where(fn($x)=>$x->where('ParentFolderID','like',$like)->orWhere('ParentFolderName','like',$like)->orWhere('ParentFolderPath','like',$like));})
            ->orderBy('ParentFolderName')->paginate($perPage)->withQueryString();
    }
    public function find(string $id): ?MsParentFolder { return $this->model->newQuery()->find($id); }
    public function create(array $data): MsParentFolder { return $this->model->newQuery()->create($data); }
    public function update(string $id,array $data): bool { $m=$this->find($id); return $m ? $m->update($data):false; }
    public function activeList() { return $this->model->newQuery()->where('IsActive',true)->orderBy('ParentFolderName')->get(); }
}
