<?php

namespace Database\Seeders\Security;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    /** Fixed initial grants. Newly configured mappings require an administrator role assignment. */
    private const SUPERADMIN_MENU_PERMISSIONS = [
        'dashboard' => ['View'],
        'master.company.index' => ['View', 'Create', 'Update', 'Delete'], 'master.email-group.index' => ['View', 'Create', 'Update', 'Delete'],
        'master.coc.index' => ['View', 'Create', 'Update', 'Delete'], 'master.country.index' => ['View', 'Create', 'Update', 'Delete'],
        'master.province.index' => ['View', 'Create', 'Update', 'Delete'], 'master.city.index' => ['View', 'Create', 'Update', 'Delete'],
        'master.district.index' => ['View', 'Create', 'Update', 'Delete'], 'master.village.index' => ['View', 'Create', 'Update', 'Delete'],
        'master.directorate.index' => ['View', 'Create', 'Update', 'Delete'], 'master.division.index' => ['View', 'Create', 'Update', 'Delete'],
        'master.department.index' => ['View', 'Create', 'Update', 'Delete'], 'master.religion.index' => ['View', 'Create', 'Update', 'Delete'],
        'master.job-level.index' => ['View', 'Create', 'Update', 'Delete'], 'master.job-title.index' => ['View', 'Create', 'Update', 'Delete'],
        'master.asset-group.index' => ['View', 'Create', 'Update', 'Delete'], 'master.asset-type.index' => ['View', 'Create', 'Update', 'Delete'],
        'master.currency.index' => ['View', 'Create', 'Update', 'Delete'], 'master.asset.index' => ['View', 'Create', 'Update', 'Delete'],
        'master.folder-path.index' => ['View', 'Create', 'Update', 'Delete'], 'master.parent-folder.index' => ['View', 'Create', 'Update', 'Delete'],
        'security.users.index' => ['View', 'Create', 'Update', 'Delete'], 'security.roles.index' => ['View', 'Create', 'Update', 'Delete'],
        'security.menus.index' => ['View', 'Create', 'Update', 'Delete'], 'security.permissions.index' => ['View', 'Create', 'Update', 'Delete'],
        'workflow.index' => ['View', 'Approve'],
        'employee-form.index' => ['View', 'Create', 'Update', 'Delete'], 'employee-app.index' => ['View', 'Create', 'Update', 'Delete'],
        'employee-email.index' => ['View', 'Create', 'Update', 'Delete'], 'employee-equipment.index' => ['View', 'Create', 'Update', 'Delete'],
        'employee-network.index' => ['View', 'Create', 'Update', 'Delete'], 'employee-infra.index' => ['View', 'Create', 'Update', 'Delete'],
        'employee-it-area.index' => ['View', 'Create', 'Update', 'Delete'], 'employee-sharing-folder.index' => ['View', 'Create', 'Update', 'Delete'],
        'employee-software.index' => ['View', 'Create', 'Update', 'Delete'],
    ];

    /** Explicit role-to-menu action policy. Keys are route names, matching MenuPermissionSeeder. */
    private const ROLE_MENU_PERMISSIONS = [
        'USER' => ['dashboard' => ['View'], 'my-workspace' => ['View'], 'employee-form.index' => ['View']],
        'TRANSACTION_VIEWER' => [
            'employee-form.index' => ['View', 'Print', 'Export'], 'employee-app.index' => ['View', 'Print', 'Export'],
            'employee-email.index' => ['View', 'Print', 'Export'], 'employee-equipment.index' => ['View', 'Print', 'Export'],
            'employee-network.index' => ['View', 'Print', 'Export'], 'employee-infra.index' => ['View', 'Print', 'Export'],
            'employee-it-area.index' => ['View', 'Print', 'Export'], 'employee-sharing-folder.index' => ['View', 'Print', 'Export'],
            'employee-software.index' => ['View', 'Print', 'Export'], 'workflow.index' => ['View'],
        ],
        'TRANSACTION_CREATOR' => [
            'employee-form.index' => ['View', 'Create', 'Update', 'Delete'], 'employee-app.index' => ['View', 'Create', 'Update', 'Delete'],
            'employee-email.index' => ['View', 'Create', 'Update', 'Delete'], 'employee-equipment.index' => ['View', 'Create', 'Update', 'Delete'],
            'employee-network.index' => ['View', 'Create', 'Update', 'Delete'], 'employee-infra.index' => ['View', 'Create', 'Update', 'Delete'],
            'employee-it-area.index' => ['View', 'Create', 'Update', 'Delete'], 'employee-sharing-folder.index' => ['View', 'Create', 'Update', 'Delete'],
            'employee-software.index' => ['View', 'Create', 'Update', 'Delete'],
        ],
        'TRANSACTION_APPROVER' => [
            'employee-form.index' => ['View', 'Approve'], 'employee-app.index' => ['View', 'Approve'],
            'employee-email.index' => ['View', 'Approve'], 'employee-equipment.index' => ['View', 'Approve'],
            'employee-network.index' => ['View', 'Approve'], 'employee-infra.index' => ['View', 'Approve'],
            'employee-it-area.index' => ['View', 'Approve'], 'employee-sharing-folder.index' => ['View', 'Approve'],
            'employee-software.index' => ['View', 'Approve'], 'workflow.index' => ['View', 'Approve'],
        ],
        'MASTER_DATA_VIEWER' => [
            'master.company.index' => ['View'], 'master.email-group.index' => ['View'], 'master.coc.index' => ['View'],
            'master.country.index' => ['View'], 'master.province.index' => ['View'], 'master.city.index' => ['View'],
            'master.district.index' => ['View'], 'master.village.index' => ['View'], 'master.directorate.index' => ['View'],
            'master.division.index' => ['View'], 'master.department.index' => ['View'], 'master.religion.index' => ['View'],
            'master.job-level.index' => ['View'], 'master.job-title.index' => ['View'], 'master.asset-group.index' => ['View'],
            'master.asset-type.index' => ['View'], 'master.currency.index' => ['View'], 'master.asset.index' => ['View'],
            'master.folder-path.index' => ['View'], 'master.parent-folder.index' => ['View'],
        ],
        'MASTER_DEPARTMENT_MANAGER' => ['master.department.index' => ['View', 'Create', 'Update', 'Delete']],
        'MASTER_DIVISION_MANAGER' => ['master.division.index' => ['View', 'Create', 'Update', 'Delete']],
        'MASTER_DIRECTORATE_MANAGER' => ['master.directorate.index' => ['View', 'Create', 'Update', 'Delete']],
    ];

    public function run(): void
    {
        $pairs = DB::table('sc_menu_permission as mp')->join('sc_menu as m', 'm.MenuID', '=', 'mp.MenuID')
            ->join('sc_permission as p', 'p.PermissionID', '=', 'mp.PermissionID')
            ->where('mp.IsActive', true)->whereNull('mp.DeletedDate')
            ->where('mp.InputUser', 'Security seeder')->where('mp.ModifUser', 'Security seeder')
            ->where('m.IsActive', true)->where('m.IsMenu', true)->whereNull('m.DeletedDate')
            ->whereNotNull('m.Route')->where('m.Route', '<>', '')
            ->where('p.IsActive', true)->whereNull('p.DeletedDate')
            ->select(['mp.MenuPermissionID', 'm.Route as MenuRoute', 'p.Name as PermissionName'])->get();
        $now = now();

        $roleNamesToCodes = [
            'Super Administrator' => 'SUPERADMIN', 'Standard User' => 'USER',
            'Transaction Viewer' => 'TRANSACTION_VIEWER', 'Transaction Creator' => 'TRANSACTION_CREATOR',
            'Transaction Approver' => 'TRANSACTION_APPROVER', 'Master Data Viewer' => 'MASTER_DATA_VIEWER',
            'Department Master Manager' => 'MASTER_DEPARTMENT_MANAGER', 'Division Master Manager' => 'MASTER_DIVISION_MANAGER',
            'Directorate Master Manager' => 'MASTER_DIRECTORATE_MANAGER',
        ];
        $roles = DB::table('sc_role')->where('IsActive', true)->whereNull('DeletedDate')->get(['RoleID', 'Role']);
        foreach ($roles as $role) {
            $roleId = $role->RoleID;
            $roleCode = $roleNamesToCodes[$role->Role] ?? null;
            if ($roleCode === null) continue;
            $selected = [];
            $roleMenuPermissions = $roleCode === 'SUPERADMIN'
                ? self::SUPERADMIN_MENU_PERMISSIONS
                : (self::ROLE_MENU_PERMISSIONS[$roleCode] ?? []);

            foreach ($pairs as $pair) {
                $codes = $roleMenuPermissions[$pair->MenuRoute] ?? [];
                if (in_array($pair->PermissionName, $codes, true)) $selected[] = (int) $pair->MenuPermissionID;
            }

            foreach ($selected as $id) {
                DB::table('sc_role_permission')->insertOrIgnore([
                    'RoleID' => $roleId, 'MenuPermissionID' => $id, 'IsActive' => true,
                    'InputUser' => 'Security seeder', 'InputDate' => $now,
                    'ModifUser' => 'Security seeder', 'ModifDate' => $now,
                ]);
            }
        }
    }
}
