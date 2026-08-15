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

    public function getPaginated(int $perPage = 10)
    {
        return $this->model
            ->whereNull('DeletedDate')
            ->orderBy('UserID')
            ->paginate($perPage);
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
        int $updatedBy
    ) {
        DB::table('sc_user_role')
            ->where('UserID', $userId)
            ->update([
                'IsActive' => false,
                'UpdatedBy' => $updatedBy,
                'UpdatedDate' => now(),
            ]);

        DB::table('sc_user_role')
            ->updateOrInsert(
                [
                    'UserID' => $userId,
                    'RoleID' => $roleId,
                ],
                [
                    'IsActive' => true,
                    'CreatedBy' => $updatedBy,
                    'CreatedDate' => now(),
                    'UpdatedBy' => $updatedBy,
                    'UpdatedDate' => now(),
                ]
            );
    }
}
