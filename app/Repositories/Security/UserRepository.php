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
        return $this->model
            ->with('roles')
            ->whereNull('DeletedDate')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('Username', 'like', "%{$search}%")
                        ->orWhere('FullName', 'like', "%{$search}%")
                        ->orWhere('Email', 'like', "%{$search}%")
                        ->orWhereHas('roles', function ($roleQuery) use ($search) {
                            $roleQuery->where('Name', 'like', "%{$search}%")
                                ->orWhere('Code', 'like', "%{$search}%");
                        });
                });
            })
            ->orderBy('UserID')
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
        int $roleId,
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
