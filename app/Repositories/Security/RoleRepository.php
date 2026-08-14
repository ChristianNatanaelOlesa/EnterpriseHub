<?php

namespace App\Repositories\Security;

use App\Models\Security\ScRole;
use App\Models\Security\ScMenu;
use App\Models\Security\ScRoleMenu;
use App\Repositories\BaseRepository;

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

    public function findById(int $id)
    {
        return $this->find($id);
    }

    public function getMenus()
    {
        return ScMenu::query()
            ->whereNull('DeletedDate')
            ->where('IsActive', true)
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

            $values = [
                'CanOpen'    => !empty($permission['CanOpen']),
                'CanAdd'     => !empty($permission['CanAdd']),
                'CanEdit'    => !empty($permission['CanEdit']),
                'CanDelete'  => !empty($permission['CanDelete']),
                'CanPrint'   => !empty($permission['CanPrint']),
                'CanExport'  => !empty($permission['CanExport']),
                'CanApprove' => !empty($permission['CanApprove']),
                'IsActive'   => true,
                'UpdatedBy'  => $userId,
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

        /*
         * Menu yang tidak dikirim berarti
         * permission-nya harus dinonaktifkan.
         */
        $query = ScRoleMenu::query()
    ->where('RoleID', $roleId);

        if (!empty($permissions)) {

            $query->whereNotIn(
                'MenuID',
                array_keys($permissions)
            );

        }

        $query->update([

            'CanOpen'    => false,
            'CanAdd'     => false,
            'CanEdit'    => false,
            'CanDelete'  => false,
            'CanPrint'   => false,
            'CanExport'  => false,
            'CanApprove' => false,

            'IsActive'   => false,

            'UpdatedBy'  => $userId,
            'UpdatedDate' => $now,

        ]);
    }
}
