<?php

namespace App\Services\EForm;

use App\Models\EForm\TrEmpNetwork;
use App\Repositories\EForm\EmpNetworkRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class EmpNetworkService
{
    public function __construct(protected EmpNetworkRepository $repository) {}
    public function getAll(?string $search=null,int $perPage=10): LengthAwarePaginator { return $this->repository->getAll($search,$perPage); }
    public function find(string $id): ?TrEmpNetwork { return $this->repository->find($id); }
    private function user(): string { return Auth::user()?->Username ?? Auth::user()?->username ?? Auth::user()?->email ?? 'Admin'; }
    public function create(array $data): TrEmpNetwork
    {
        return DB::transaction(function() use ($data) {
            $now=now(); $user=$this->user(); $data['InputDate']=$now; $data['InputUser']=$user; $data['ModifDate']=$now; $data['ModifUser']=$user;
            return $this->repository->create($data);
        });
    }
    public function update(string $id,array $data): TrEmpNetwork
    {
        return DB::transaction(function() use ($id,$data) {
            if(!$this->repository->find($id)) throw ValidationException::withMessages(['EmpNetworkID' => 'Employee Network data not found.']);
            $data['ModifDate']=now(); $data['ModifUser']=$this->user(); $newId=$data['EmpNetworkID'] ?? $id;
            if(!$this->repository->update($id,$data)) throw ValidationException::withMessages(['EmpNetworkID' => 'Failed to update Employee Network.']);
            $updated=$this->repository->find($newId);
            if(!$updated) throw ValidationException::withMessages(['EmpNetworkID' => 'Updated data could not be retrieved.']);
            return $updated;
        });
    }
    public function delete(string $id): void
    {
        DB::transaction(function() use($id) {
            if(!$this->repository->find($id)) throw ValidationException::withMessages(['EmpNetworkID' => 'Employee Network data not found.']);
            $this->repository->delete($id);
        });
    }
    public function generateId(): string
    {
        $prefix='ENW'.now()->format('Ym').'-'; $ids=TrEmpNetwork::query()->where('EmpNetworkID','like',$prefix.'%')->lockForUpdate()->pluck('EmpNetworkID'); $last=0;
        foreach($ids as $existing) if(preg_match('/^'.preg_quote($prefix,'/').'([0-9]{3})$/',$existing,$m)) $last=max($last,(int)$m[1]);
        return $prefix.str_pad((string)($last+1),3,'0',STR_PAD_LEFT);
    }
}
