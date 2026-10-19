<?php

namespace App\Repositories\Security;

use App\Models\Security\ScUser;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

class UserRepository extends BaseRepository
{
    public function __construct(ScUser $model)
    {
        $this->model = $model;
    }

    public function getPaginated(int $perPage = 10, ?string $search = null)
    {
        return $this->model->newQuery()
            ->select([
                'sc_user.*',
                'e.JoinDate',
                'jt.JobTitle as JobTitleName',
            ])
            ->join('Tr_EmpForm as e', 'sc_user.EmpFormID', '=', 'e.EmpFormID', 'left')
            ->join('Tr_EmpFormHist as h', function ($join) {
                $join->on('h.EmpFormID', '=', 'sc_user.EmpFormID')
                    ->where('h.EffectiveDate', '=', function ($sub) {
                        $sub->select(DB::raw('MAX(EffectiveDate)'))
                            ->from('Tr_EmpFormHist')
                            ->whereColumn('EmpFormID', 'sc_user.EmpFormID');
                    });
            })
            ->join('ms_job_title as jt', 'h.JobTitleID', '=', 'jt.JobTitleID', 'left')
            ->with(['roles' => fn ($query) => $query
                ->wherePivot('IsActive', true)
                ->wherePivotNull('DeletedDate')
                ->where('sc_role.IsActive', true)
                ->whereNull('sc_role.DeletedDate')])
            ->whereNull('sc_user.DeletedDate')
            ->where('sc_user.IsActive', true)
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('sc_user.Username', 'like', "%{$search}%")
                        ->orWhere('sc_user.FullName', 'like', "%{$search}%")
                        ->orWhere('sc_user.Email', 'like', "%{$search}%")
                        ->orWhereHas('roles', function ($roleQuery) use ($search) {
                            $roleQuery->where('Role', 'like', "%{$search}%");
                        });
                });
            })
            ->orderBy('e.JoinDate', 'desc')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function findById(int $id)
    {
        return $this->find($id);
    }

    public function store(array $data)
    {
        return $this->model->create($data);
    }

    public function syncRole(
        int $userId,
        string $roleId,
        string $username
    ) {
        DB::table('sc_user_role')
            ->where('UserID', $userId)
            ->update([
                'IsActive' => false,
                'ModifUser' => $username,
                'ModifDate' => now(),
            ]);

        DB::table('sc_user_role')
            ->updateOrInsert(
                [
                    'UserID' => $userId,
                    'RoleID' => $roleId,
                ],
                [
                    'IsActive' => true,
                    'InputUser' => $username,
                    'InputDate' => now(),
                    'ModifUser' => $username,
                    'ModifDate' => now(),
                ]
            );
    }
}
