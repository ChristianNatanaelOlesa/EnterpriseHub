<?php

namespace App\Repositories\Security;

use App\Models\Security\ScRole;
use App\Models\Security\ScUserRole;

class UserRoleRepository
{
    public function getActiveRoles()
    {
        return ScRole::query()
            ->where('IsActive', true)
            ->whereNull('DeletedDate')
            ->orderBy('Name')
            ->get();
    }

    public function getUserRoleIds(int $userId)
    {
        return ScUserRole::query()
            ->where('UserID', $userId)
            ->where('IsActive', true)
            ->pluck('RoleID')
            ->toArray();
    }

    public function sync(
        int $userId,
        array $roleIds,
        int $actorId
    ): void {
        $now = now();

        $roleIds = array_map(
            'intval',
            $roleIds
        );

        $existing = ScUserRole::query()
            ->where('UserID', $userId)
            ->get()
            ->keyBy('RoleID');

        foreach ($roleIds as $roleId) {

            $record = $existing->get($roleId);

            if ($record) {

                $record->update([
                    'IsActive' => true,
                    'UpdatedBy' => $actorId,
                    'UpdatedDate' => $now,
                    'DeletedBy' => null,
                    'DeletedDate' => null,
                ]);

            } else {

                ScUserRole::create([
                    'UserID' => $userId,
                    'RoleID' => $roleId,
                    'IsActive' => true,
                    'CreatedBy' => $actorId,
                    'CreatedDate' => $now,
                ]);

            }
        }

        ScUserRole::query()
            ->where('UserID', $userId)
            ->whereNotIn('RoleID', $roleIds ?: [0])
            ->update([
                'IsActive' => false,
                'UpdatedBy' => $actorId,
                'UpdatedDate' => $now,
                'DeletedBy' => $actorId,
                'DeletedDate' => $now,
            ]);
    }
}
