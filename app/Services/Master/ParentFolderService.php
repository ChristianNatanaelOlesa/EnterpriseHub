<?php
namespace App\Services\Master;
use App\Models\Master\MsParentFolder;
use App\Repositories\Master\ParentFolderRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
class ParentFolderService
{
    public function __construct(protected ParentFolderRepository $repository) {}
    private function user(): string { return Auth::user()?->Username ?? Auth::user()?->username ?? Auth::user()?->email ?? 'Admin'; }
    public function getAll(?string $search,int $perPage){return $this->repository->getAll($search,$perPage);}
    public function find(string $id):?MsParentFolder{return $this->repository->find($id);}
    public function activeList(){return $this->repository->activeList();}
    private function generateId():string { $last=MsParentFolder::query()->where('ParentFolderID','like','PF%')->orderByDesc('ParentFolderID')->lockForUpdate()->value('ParentFolderID'); $n=0;if($last&&preg_match('/^PF(\d+)$/',$last,$m))$n=(int)$m[1];return 'PF'.str_pad((string)($n+1),4,'0',STR_PAD_LEFT); }
    public function create(array $data):MsParentFolder{return DB::transaction(function()use($data){$now=now();$u=$this->user();$data['ParentFolderID']=$this->generateId();$data['IsActive']=(bool)($data['IsActive']??true);$data['InputDate']=$now;$data['InputUser']=$u;$data['ModifDate']=$now;$data['ModifUser']=$u;return $this->repository->create($data);});}
    public function update(string $id,array $data):MsParentFolder{return DB::transaction(function()use($id,$data){if(!$this->repository->find($id))throw ValidationException::withMessages(['ParentFolderID'=>'Parent Folder not found.']);$data['IsActive']=(bool)($data['IsActive']??false);$data['ModifDate']=now();$data['ModifUser']=$this->user();$this->repository->update($id,$data);return $this->repository->find($id);});}
    public function delete(string $id):void{DB::transaction(function()use($id){$m=$this->repository->find($id);if(!$m)throw ValidationException::withMessages(['ParentFolderID'=>'Parent Folder not found.']);if($m->folderPaths()->exists())throw ValidationException::withMessages(['ParentFolderID'=>'Parent Folder masih digunakan oleh Folder Path.']);$u=$this->user();$m->DeletedBy=$u;$m->DeletedDate=now();$m->IsActive=false;$m->ModifUser=$u;$m->ModifDate=now();$m->save();});}
}
