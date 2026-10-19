<?php

namespace Database\Seeders\Security;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Seed reusable application roles.
     *
     * Existing roles are not deleted. Only these managed role codes are upserted.
     * Users can have multiple roles through sc_user_role.
     */
    public function run(): void
    {
        $now = now();
        $username = 'Admin';

        $roles = [
            ['Role' => 'Super Administrator', 'Description' => 'Full access to all active application menus and actions.'],
            ['Role' => 'Standard User', 'Description' => 'Basic dashboard and assigned transaction-module access.'],
            ['Role' => 'Transaction Viewer', 'Description' => 'View transaction modules; no create, edit, delete, or approval rights by default.'],
            ['Role' => 'Transaction Creator', 'Description' => 'Create and view assigned transaction modules.'],
            ['Role' => 'Transaction Approver', 'Description' => 'Open assigned transaction modules and use approval actions where supported.'],
            ['Role' => 'Master Data Viewer', 'Description' => 'Read-only access to explicitly assigned master-data menus.'],
            ['Role' => 'Department Master Manager', 'Description' => 'Manage Department master only. Grant additional master menus through other roles as needed.'],
            ['Role' => 'Division Master Manager', 'Description' => 'Manage Division master only. Grant additional master menus through other roles as needed.'],
            ['Role' => 'Directorate Master Manager', 'Description' => 'Manage Directorate master only. Grant additional master menus through other roles as needed.'],
        ];

        foreach ($roles as $role) {
            $existing = DB::table('sc_role')->where('Role', $role['Role'])->first();
            if ($existing) {
                continue;
            }

            $row = [
                'RoleID' => \App\Services\Security\SecurityIdGenerator::nextRoleId(),
                'Role' => $role['Role'],
                'Description' => $role['Description'],
                'IsActive' => true,
                'InputUser' => $username,
                'InputDate' => $now,
                'ModifUser' => $username,
                'ModifDate' => $now,
                'DeletedBy' => null,
                'DeletedDate' => null,
            ];
            DB::table('sc_role')->insert($row);
        }
    }
}
