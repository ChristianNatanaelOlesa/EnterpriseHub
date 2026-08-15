<?php

namespace App\Repositories\Security;

use App\Models\Security\ScRole;
use App\Models\Security\ScRoleMenu;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

class RoleRepository extends BaseRepository
{
    public function __construct(ScRole $model)
    {
        $this->model = $model;
    }

    public function getPaginated(int $perPage = 10)
    {
        return $this->model
            ->whereNull('DeletedDate')
            ->orderBy('RoleID')
            ->paginate($perPage);
    }

    public function getActiveRoles()
    {
        return $this->model
            ->where('IsActive', true)
            ->whereNull('DeletedDate')
            ->orderBy('Name')
            ->get();
    }

    public function findById(int $id)
    {
        return $this->find($id);
    }

    public function getMenus()
    {
        return DB::table('sc_menu')
            ->where('IsActive', true)
            ->whereNull('DeletedDate')
            ->orderBy('SortOrder')
            ->orderBy('MenuID')
            ->get();
    }

    public function getRolePermissions(int $roleId)
    {
        return ScRoleMenu::query()
            ->where('RoleID', $roleId)
            ->where('IsActive', true)
            ->get()
            ->keyBy('MenuID');
    }

    public function syncPermissions(
        int $roleId,
        array $permissions,
        int $userId
    ): void {
        $now = now();

        foreach ($permissions as $menuId => $permission) {

            $canOpen = ! empty($permission['CanOpen']);

            $values = [
                'CanOpen' => $canOpen,
                'CanAdd' => $canOpen && ! empty($permission['CanAdd']),
                'CanEdit' => $canOpen && ! empty($permission['CanEdit']),
                'CanDelete' => $canOpen && ! empty($permission['CanDelete']),
                'CanPrint' => $canOpen && ! empty($permission['CanPrint']),
                'CanExport' => $canOpen && ! empty($permission['CanExport']),
                'CanApprove' => $canOpen && ! empty($permission['CanApprove']),
                'IsActive' => true,
                'UpdatedBy' => $userId,
                'UpdatedDate' => $now,
            ];

            $existing = ScRoleMenu::query()
                ->where('RoleID', $roleId)
                ->where('MenuID', $menuId)
                ->first();

            if ($existing) {

                $existing->update($values);

            } else {

                ScRoleMenu::create(array_merge(
                    [
                        'RoleID' => $roleId,
                        'MenuID' => $menuId,
                        'CreatedBy' => $userId,
                        'CreatedDate' => $now,
                    ],
                    $values
                ));
            }
        }

        $query = ScRoleMenu::query()
            ->where('RoleID', $roleId);

        if (! empty($permissions)) {

            $query->whereNotIn(
                'MenuID',
                array_keys($permissions)
            );
        }

        $query->update([
            'CanOpen' => false,
            'CanAdd' => false,
            'CanEdit' => false,
            'CanDelete' => false,
            'CanPrint' => false,
            'CanExport' => false,
            'CanApprove' => false,
            'IsActive' => false,
            'UpdatedBy' => $userId,
            'UpdatedDate' => $now,
        ]);
    }
}
