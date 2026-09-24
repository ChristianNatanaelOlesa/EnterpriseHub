<?php

namespace App\Services\EForm;

use App\Models\EForm\TrEmpInfra;
use App\Repositories\EForm\EmpInfraRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class EmpInfraService
{
    public function __construct(protected EmpInfraRepository $repository) {}
    public function getAll(?string $search=null,int $perPage=10): LengthAwarePaginator { return $this->repository->getAll($search,$perPage); }
    public function find(string $id): ?TrEmpInfra { return $this->repository->find($id); }
    private function user(): string { return Auth::user()?->Username ?? Auth::user()?->username ?? Auth::user()?->email ?? 'Admin'; }
    public function create(array $data): TrEmpInfra
    {
        return DB::transaction(function() use ($data) {
            $now=now(); $user=$this->user(); $data['InputDate']=$now; $data['InputUser']=$user; $data['ModifDate']=$now; $data['ModifUser']=$user;
            return $this->repository->create($data);
        });
    }
    public function update(string $id,array $data): TrEmpInfra
    {
        return DB::transaction(function() use ($id,$data) {
            if(!$this->repository->find($id)) throw ValidationException::withMessages(['EmpInfraID' => 'Employee Infrastructure data not found.']);
            $data['ModifDate']=now(); $data['ModifUser']=$this->user(); $newId=$data['EmpInfraID'] ?? $id;
            if(!$this->repository->update($id,$data)) throw ValidationException::withMessages(['EmpInfraID' => 'Failed to update Employee Infrastructure.']);
            $updated=$this->repository->find($newId);
            if(!$updated) throw ValidationException::withMessages(['EmpInfraID' => 'Updated data could not be retrieved.']);
            return $updated;
        });
    }
    public function delete(string $id): void
    {
        DB::transaction(function() use($id) {
            if(!$this->repository->find($id)) throw ValidationException::withMessages(['EmpInfraID' => 'Employee Infrastructure data not found.']);
            $this->repository->delete($id);
        });
    }
    public function generateId(): string
    {
        $prefix='EIN'.now()->format('Ym').'-'; $ids=TrEmpInfra::query()->where('EmpInfraID','like',$prefix.'%')->lockForUpdate()->pluck('EmpInfraID'); $last=0;
        foreach($ids as $existing) if(preg_match('/^'.preg_quote($prefix,'/').'([0-9]{3})$/',$existing,$m)) $last=max($last,(int)$m[1]);
        return $prefix.str_pad((string)($last+1),3,'0',STR_PAD_LEFT);
    }
}
