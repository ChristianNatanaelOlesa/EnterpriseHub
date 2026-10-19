<?php

namespace Database\Seeders\Security;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $menus = [
            // =========================================================
            // TOP MENU
            // =========================================================
            ['DASHBOARD', 'Dashboard', 'TOP', 'dashboard', 'bi bi-speedometer2', 1],
            ['SYSTEM', 'System', 'TOP', null, 'bi bi-gear', 2],
            ['MASTER', 'Master', 'TOP', null, 'bi bi-database', 1],
            ['MASTER_CORPORATE', 'Corporate', 'TOP', null, 'bi bi-building', 1],
            ['MASTER_GEOGRAPHY', 'Geography', 'TOP', null, 'bi bi-globe2', 2],
            ['MASTER_ORGANIZATION', 'Organization', 'TOP', null, 'bi bi-diagram-3', 3],
            ['MASTER_EMPLOYEE_HR', 'Employee & HR', 'TOP', null, 'bi bi-person-badge', 4],

            ['MASTER_COMPANY', 'Company', 'TOP', 'master.company.index', 'bi bi-building', 1],
            ['MASTER_EMAIL_GROUP', 'Email Group', 'TOP', 'master.email-group.index', 'bi bi-envelope-at', 2],
            ['MASTER_COC', 'Code of Conduct', 'TOP', 'master.coc.index', 'bi bi-file-earmark-text', 3],

            ['MASTER_COUNTRY', 'Country', 'TOP', 'master.country.index', 'bi bi-globe2', 1],
            ['MASTER_PROVINCE', 'Province', 'TOP', 'master.province.index', 'bi bi-map', 2],
            ['MASTER_CITY', 'City', 'TOP', 'master.city.index', 'bi bi-buildings', 3],
            ['MASTER_DISTRICT', 'District', 'TOP', 'master.district.index', 'bi bi-geo', 4],
            ['MASTER_VILLAGE', 'Village', 'TOP', 'master.village.index', 'bi bi-geo-alt', 5],

            ['MASTER_DIRECTORATE', 'Directorate', 'TOP', 'master.directorate.index', 'bi bi-diagram-3', 1],
            ['MASTER_DIVISION', 'Division', 'TOP', 'master.division.index', 'bi bi-diagram-2', 2],
            ['MASTER_DEPARTMENT', 'Department', 'TOP', 'master.department.index', 'bi bi-diagram-3-fill', 3],

            ['MASTER_RELIGION', 'Religion', 'TOP', 'master.religion.index', 'bi bi-person-heart', 1],
            ['MASTER_JOB_LEVEL', 'Job Level', 'TOP', 'master.job-level.index', 'bi bi-bar-chart-steps', 2],
            ['MASTER_JOB_TITLE', 'Job Title', 'TOP', 'master.job-title.index', 'bi bi-person-vcard', 3],

            // =========================================================
            // MASTER SIDEBAR
            // =========================================================
            ['MASTER_ASSET', 'Asset Management', 'SIDEBAR', null, 'bi bi-box-seam', 5],
            ['MASTER_ASSET_GROUP', 'Asset Group', 'SIDEBAR', 'master.asset-group.index', 'bi bi-collection', 1],
            ['MASTER_ASSET_TYPE', 'Asset Type', 'SIDEBAR', 'master.asset-type.index', 'bi bi-tags', 2],
            ['MASTER_CURRENCY', 'Currency', 'SIDEBAR', 'master.currency.index', 'bi bi-currency-exchange', 3],
            ['MASTER_ASSET_ITEM', 'Asset', 'SIDEBAR', 'master.asset.index', 'bi bi-box-seam-fill', 4],

            ['MASTER_FOLDER', 'Folder Management', 'SIDEBAR', null, 'bi bi-folder', 6],
            ['MASTER_FOLDER_PATH', 'Folder Path', 'SIDEBAR', 'master.folder-path.index', 'bi bi-folder2', 2],
            ['MASTER_PARENT_FOLDER', 'Parent Folder', 'SIDEBAR', 'master.parent-folder.index', 'bi bi-folder-fill', 1],

            // =========================================================
            // SECURITY / TOP
            // =========================================================
            ['ADMINISTRATION', 'Administration', 'TOP', null, 'bi bi-shield-lock', 3],
            ['SECURITY', 'Security', 'TOP', null, 'bi bi-shield-lock', 1],
            ['SECURITY_USERS', 'User Access', 'TOP', 'security.users.index', 'bi bi-people', 1],
            ['SECURITY_ROLES', 'Role Management', 'TOP', 'security.roles.index', 'bi bi-person-badge', 2],
            ['SECURITY_MENUS', 'Menu Management', 'TOP', 'security.menus.index', 'bi bi-list', 3],
            ['SECURITY_PERMISSIONS', 'Permission Management', 'TOP', 'security.permissions.index', 'bi bi-key', 4],
            ['WORKFLOW', 'Workflow', 'TOP', null, 'bi bi-diagram-3', 4],
            ['WORKFLOW_APPROVALS', 'My Approval', 'TOP', 'workflow.index', 'bi bi-check2-square', 1],

            // =========================================================
            // TRANSACTION / SIDEBAR
            // =========================================================
            ['MY_WORKSPACE', 'My Workspace', 'SIDEBAR', null, 'bi bi-grid', 1],
            ['EMPLOYEE_FORM', 'Employee Form Request', 'SIDEBAR', 'employee-form.index', 'bi bi-file-earmark-person', 1],
            ['EMPLOYEE_APP', 'Employee Application', 'SIDEBAR', 'employee-app.index', 'bi bi-file-earmark-text', 1],
            ['EMPLOYEE_EMAIL', 'Employee Email', 'SIDEBAR', 'employee-email.index', 'bi bi-envelope', 2],
            ['EMPLOYEE_EQUIPMENT', 'Employee Equipment', 'SIDEBAR', 'employee-equipment.index', 'bi bi-pc-display', 3],
            ['EMPLOYEE_NETWORK', 'Employee Network', 'SIDEBAR', 'employee-network.index', 'bi bi-router', 4],
            ['EMPLOYEE_INFRA', 'Employee Infrastructure', 'SIDEBAR', 'employee-infra.index', 'bi bi-hdd-rack', 5],
            ['EMPLOYEE_IT_AREA', 'Employee IT Area', 'SIDEBAR', 'employee-it-area.index', 'bi bi-shield-check', 6],
            ['EMPLOYEE_SHARING_FOLDER', 'Employee Sharing Folder', 'SIDEBAR', 'employee-sharing-folder.index', 'bi bi-folder2-open', 7],
            ['EMPLOYEE_SOFTWARE', 'Employee Software', 'SIDEBAR', 'employee-software.index', 'bi bi-box-seam', 8],
        ];

        $parentMap = [
            // Keep the master navigation within the three-level ID hierarchy.
            'MASTER' => null,
            'MASTER_CORPORATE' => 'MASTER',
            'MASTER_GEOGRAPHY' => 'MASTER',
            'MASTER_ORGANIZATION' => 'MASTER',
            'MASTER_EMPLOYEE_HR' => 'MASTER',

            'MASTER_COMPANY' => 'MASTER',
            'MASTER_EMAIL_GROUP' => 'MASTER',
            'MASTER_COC' => 'MASTER',

            'MASTER_COUNTRY' => 'MASTER_GEOGRAPHY',
            'MASTER_PROVINCE' => 'MASTER_GEOGRAPHY',
            'MASTER_CITY' => 'MASTER_GEOGRAPHY',
            'MASTER_DISTRICT' => 'MASTER_GEOGRAPHY',
            'MASTER_VILLAGE' => 'MASTER_GEOGRAPHY',

            'MASTER_DIRECTORATE' => 'MASTER_ORGANIZATION',
            'MASTER_DIVISION' => 'MASTER_ORGANIZATION',
            'MASTER_DEPARTMENT' => 'MASTER_ORGANIZATION',

            'MASTER_RELIGION' => 'MASTER_EMPLOYEE_HR',
            'MASTER_JOB_LEVEL' => 'MASTER_EMPLOYEE_HR',
            'MASTER_JOB_TITLE' => 'MASTER_EMPLOYEE_HR',

            'MASTER_ASSET' => null,
            'MASTER_ASSET_GROUP' => 'MASTER_ASSET',
            'MASTER_ASSET_TYPE' => 'MASTER_ASSET',
            'MASTER_CURRENCY' => 'MASTER_ASSET',
            'MASTER_ASSET_ITEM' => 'MASTER_ASSET',

            'MASTER_FOLDER' => null,
            'MASTER_PARENT_FOLDER' => 'MASTER_FOLDER',
            'MASTER_FOLDER_PATH' => 'MASTER_FOLDER',

            'ADMINISTRATION' => null,
            'SECURITY' => 'ADMINISTRATION',
            'SECURITY_USERS' => 'SECURITY',
            'SECURITY_ROLES' => 'SECURITY',
            'SECURITY_MENUS' => 'SECURITY',
            'SECURITY_PERMISSIONS' => 'SECURITY',
            'WORKFLOW' => null,
            'WORKFLOW_APPROVALS' => 'WORKFLOW',

            'MY_WORKSPACE' => null,
            'EMPLOYEE_FORM' => 'MY_WORKSPACE',
            'EMPLOYEE_APP' => 'MY_WORKSPACE',
            'EMPLOYEE_EMAIL' => 'MY_WORKSPACE',
            'EMPLOYEE_EQUIPMENT' => 'MY_WORKSPACE',
            'EMPLOYEE_NETWORK' => 'MY_WORKSPACE',
            'EMPLOYEE_INFRA' => 'MY_WORKSPACE',
            'EMPLOYEE_IT_AREA' => 'MY_WORKSPACE',
            'EMPLOYEE_SHARING_FOLDER' => 'MY_WORKSPACE',
            'EMPLOYEE_SOFTWARE' => 'MY_WORKSPACE',
        ];

        $childrenByParent = [];
        foreach ($menus as [$menuKey]) {
            $parentCode = $parentMap[$menuKey] ?? null;
            $childrenByParent[$parentCode ?? 'ROOT'][] = $menuKey;
        }

        $menuLevels = [];
        $assignLevels = function (?string $parentCode, int $level) use (&$assignLevels, &$menuLevels, $childrenByParent): void {
            $siblings = $childrenByParent[$parentCode ?? 'ROOT'] ?? [];
            foreach ($siblings as $index => $menuKey) {
                if ($index >= 99) {
                    throw new \RuntimeException('Menu seeder melampaui kapasitas 99 item per parent.');
                }
                $menuLevels[$menuKey] = $level;
                if ($level < 3) {
                    $assignLevels($menuKey, $level + 1);
                }
            }
        };
        $assignLevels(null, 1);

        $menuIds = [];
        foreach ($menus as [$menuKey, $name, $area, $route, $icon, $sort]) {
            $parentCode = $parentMap[$menuKey] ?? null;
            $parentId = $parentCode === null ? null : ($menuIds[$parentCode] ?? null);
            if ($parentCode !== null && $parentId === null) {
                throw new \RuntimeException("Parent menu {$parentCode} harus dibuat sebelum {$menuKey}.");
            }

            $existingMenuQuery = DB::table('sc_menu')->where('Menu', $name);
            $existingMenu = $parentId === null
                ? $existingMenuQuery->whereNull('ParentID')->first()
                : $existingMenuQuery->where('ParentID', $parentId)->first();
            if ($existingMenu) {
                $menuIds[$menuKey] = $existingMenu->MenuID;
                continue;
            }

            $now = now();
            $row = [
                'MenuID' => \App\Services\Security\SecurityIdGenerator::nextMenuId($parentId),
                'Menu' => $name,
                'Description' => $name,
                'MenuArea' => $area,
                'ParentID' => $parentId,
                'Lvl' => $menuLevels[$menuKey],
                'Route' => $route,
                'Icon' => $icon,
                'SortOrder' => $sort,
                'IsMenu' => true,
                'IsActive' => true,
                'InputUser' => 'Admin',
                'InputDate' => $now,
                'ModifUser' => 'Admin',
                'ModifDate' => $now,
                'DeletedBy' => null,
                'DeletedDate' => null,
            ];
            DB::table('sc_menu')->insert($row);
            $menuIds[$menuKey] = $row['MenuID'];
        }
    }
}
