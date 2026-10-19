<?php

namespace Database\Seeders\Security;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class MenuPermissionSeeder extends Seeder
{
    /** Default menu configuration. New mappings are never inferred from the permission master. */
    private const MENU_PERMISSIONS = [
        'dashboard' => ['View'],
        'master.company.index' => ['View', 'Create', 'Update', 'Delete'],
        'master.email-group.index' => ['View', 'Create', 'Update', 'Delete'],
        'master.coc.index' => ['View', 'Create', 'Update', 'Delete'],
        'master.country.index' => ['View', 'Create', 'Update', 'Delete'],
        'master.province.index' => ['View', 'Create', 'Update', 'Delete'],
        'master.city.index' => ['View', 'Create', 'Update', 'Delete'],
        'master.district.index' => ['View', 'Create', 'Update', 'Delete'],
        'master.village.index' => ['View', 'Create', 'Update', 'Delete'],
        'master.directorate.index' => ['View', 'Create', 'Update', 'Delete'],
        'master.division.index' => ['View', 'Create', 'Update', 'Delete'],
        'master.department.index' => ['View', 'Create', 'Update', 'Delete'],
        'master.religion.index' => ['View', 'Create', 'Update', 'Delete'],
        'master.job-level.index' => ['View', 'Create', 'Update', 'Delete'],
        'master.job-title.index' => ['View', 'Create', 'Update', 'Delete'],
        'master.asset-group.index' => ['View', 'Create', 'Update', 'Delete'],
        'master.asset-type.index' => ['View', 'Create', 'Update', 'Delete'],
        'master.currency.index' => ['View', 'Create', 'Update', 'Delete'],
        'master.asset.index' => ['View', 'Create', 'Update', 'Delete'],
        'master.folder-path.index' => ['View', 'Create', 'Update', 'Delete'],
        'master.parent-folder.index' => ['View', 'Create', 'Update', 'Delete'],
        'security.users.index' => ['View', 'Create', 'Update', 'Delete'],
        'security.roles.index' => ['View', 'Create', 'Update', 'Delete'],
        'security.menus.index' => ['View', 'Create', 'Update', 'Delete'],
        'security.permissions.index' => ['View', 'Create', 'Update', 'Delete'],
        'workflow.index' => ['View', 'Approve'],
        'employee-form.index' => ['View', 'Create', 'Update', 'Delete'],
        'employee-app.index' => ['View', 'Create', 'Update', 'Delete'],
        'employee-email.index' => ['View', 'Create', 'Update', 'Delete', 'IT Fulfillment'],
        'employee-equipment.index' => ['View', 'Create', 'Update', 'Delete', 'IT Fulfillment'],
        'employee-network.index' => ['View', 'Create', 'Update', 'Delete', 'IT Fulfillment'],
        'employee-infra.index' => ['View', 'Create', 'Update', 'Delete', 'IT Fulfillment'],
        'employee-it-area.index' => ['View', 'Create', 'Update', 'Delete', 'IT Fulfillment'],
        'employee-sharing-folder.index' => ['View', 'Create', 'Update', 'Delete', 'IT Fulfillment'],
        'employee-software.index' => ['View', 'Create', 'Update', 'Delete', 'IT Fulfillment'],
    ];

    public function run(): void
    {
        $now = now();
        $permissions = DB::table('sc_permission')->where('IsActive', true)->whereNull('DeletedDate')->pluck('PermissionID', 'Name');
        $menus = DB::table('sc_menu')->where('IsActive', true)->where('IsMenu', true)->whereNull('DeletedDate')->get()->keyBy('Route');
        $allowedPairs = [];

        foreach (self::MENU_PERMISSIONS as $menuRoute => $permissionCodes) {
            $menu = $menus->get($menuRoute);
            if (! $menu || ! $menu->Route || ! Route::has($menu->Route)) {
                continue;
            }

            foreach ($permissionCodes as $permissionName) {
                $permissionId = $permissions->get($permissionName);
                if ($permissionId === null) {
                    continue;
                }

                $allowedPairs[$menu->MenuID . ':' . $permissionId] = true;
                $existing = DB::table('sc_menu_permission')->where('MenuID', $menu->MenuID)
                    ->where('PermissionID', $permissionId)->first();
                if ($existing) {
                    if ((! $existing->IsActive || $existing->DeletedDate !== null)
                        && $existing->DeletedBy === 'Security seeder'
                        && $existing->ModifUser === 'Security seeder') {
                        DB::table('sc_menu_permission')->where('MenuPermissionID', $existing->MenuPermissionID)->update([
                            'IsActive' => true, 'DeletedBy' => null, 'DeletedDate' => null,
                            'ModifUser' => 'Security seeder', 'ModifDate' => $now,
                        ]);
                    }
                } else {
                    DB::table('sc_menu_permission')->insert([
                        'MenuID' => $menu->MenuID,
                        'PermissionID' => $permissionId,
                        'IsActive' => true,
                        'InputUser' => 'Security seeder', 'InputDate' => $now,
                        'ModifUser' => 'Security seeder', 'ModifDate' => $now,
                    ]);
                }
            }
        }

        // Retire only mappings created by the former blanket seeder; preserve administrator-managed mappings.
        $legacySeeded = DB::table('sc_menu_permission as mp')
            ->join('sc_permission as p', 'p.PermissionID', '=', 'mp.PermissionID')
            ->where('mp.InputUser', 'Security seeder')->where('mp.ModifUser', 'Security seeder')->where('mp.IsActive', true)
            ->select(['mp.MenuPermissionID', 'mp.MenuID', 'mp.PermissionID'])->get();

        foreach ($legacySeeded as $mapping) {
            if (isset($allowedPairs[$mapping->MenuID . ':' . $mapping->PermissionID])) {
                continue;
            }

            $manualActiveGrantExists = DB::table('sc_role_permission')
                ->where('MenuPermissionID', $mapping->MenuPermissionID)->where('IsActive', true)
                ->whereNull('DeletedDate')->where('InputUser', '<>', 'Security seeder')->exists();
            if ($manualActiveGrantExists) {
                continue;
            }

            DB::table('sc_role_permission')->where('MenuPermissionID', $mapping->MenuPermissionID)
                ->where('IsActive', true)->where('InputUser', 'Security seeder')->update([
                    'IsActive' => false, 'DeletedBy' => 'Security seeder', 'DeletedDate' => $now,
                    'ModifUser' => 'Security seeder', 'ModifDate' => $now,
                ]);
            DB::table('sc_menu_permission')->where('MenuPermissionID', $mapping->MenuPermissionID)->update([
                'IsActive' => false, 'DeletedBy' => 'Security seeder', 'DeletedDate' => $now,
                'ModifUser' => 'Security seeder', 'ModifDate' => $now,
            ]);
        }
    }
}
