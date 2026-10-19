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

    public function getUserRoleIds(int $userId): array
    {
        return ScUserRole::query()
            ->where('UserID', $userId)
            ->where('IsActive', true)
            ->whereNull('DeletedDate')
            ->whereHas('role', fn ($query) => $query->where('IsActive', true)->whereNull('DeletedDate'))
            ->pluck('RoleID')
            ->toArray();
    }

    public function sync(
        int $userId,
        array $roleIds,
        string $username
    ): void {
        $now = now();

        $roleIds = array_values(array_unique(array_map('strval', $roleIds)));

        $existing = ScUserRole::query()
            ->where('UserID', $userId)
            ->get()
            ->keyBy('RoleID');

        foreach ($roleIds as $roleId) {

            $record = $existing->get($roleId);

            if ($record) {

                $record->update([
                    'IsActive' => true,
                    'ModifUser' => $username,
                    'ModifDate' => $now,
                    'DeletedBy' => null,
                    'DeletedDate' => null,
                ]);

            } else {

                ScUserRole::create([
                    'UserID' => $userId,
                    'RoleID' => $roleId,
                    'IsActive' => true,
                    'InputUser' => $username,
                    'InputDate' => $now,
                ]);

            }
        }

        ScUserRole::query()
            ->where('UserID', $userId)
            ->whereNotIn('RoleID', $roleIds ?: [''])
            ->update([
                'IsActive' => false,
                'ModifUser' => $username,
                'ModifDate' => $now,
                'DeletedBy' => $username,
                'DeletedDate' => $now,
            ]);
    }
}
