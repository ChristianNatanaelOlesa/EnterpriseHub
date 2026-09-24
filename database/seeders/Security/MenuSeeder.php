<?php



namespace Database\Seeders\Security;



use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;



class MenuSeeder extends Seeder

{

    public function run(): void

    {

        $menus = [

            /*

             * =========================================================

             * TOPSIDE

             * =========================================================

             */



            [

                'Code' => 'DASHBOARD',

                'Name' => 'Dashboard',

                'MenuArea' => 'TOP',

                'ParentID' => null,

                'Route' => 'dashboard',

                'URL' => null,

                'Icon' => 'bi bi-speedometer2',

                'SortOrder' => 1,

                'IsMenu' => true,

                'IsActive' => true,

            ],



            [

                'Code' => 'SYSTEM',

                'Name' => 'System',

                'MenuArea' => 'TOP',

                'ParentID' => null,

                'Route' => null,

                'URL' => null,

                'Icon' => 'bi bi-gear',

                'SortOrder' => 2,

                'IsMenu' => true,

                'IsActive' => true,

            ],



            [

                'Code' => 'MASTER',

                'Name' => 'Master',

                'MenuArea' => 'TOP',

                'ParentID' => null,

                'Route' => null,

                'URL' => null,

                'Icon' => 'bi bi-database',

                'SortOrder' => 1,

                'IsMenu' => true,

                'IsActive' => true,

            ],



            [

                'Code' => 'MASTER_CORPORATE',

                'Name' => 'Corporate',

                'MenuArea' => 'TOP',

                'ParentID' => null,

                'Route' => null,

                'URL' => null,

                'Icon' => 'bi bi-building',

                'SortOrder' => 1,

                'IsMenu' => true,

                'IsActive' => true,

            ],



            [

                'Code' => 'MASTER_GEOGRAPHY',

                'Name' => 'Geography',

                'MenuArea' => 'TOP',

                'ParentID' => null,

                'Route' => null,

                'URL' => null,

                'Icon' => 'bi bi-globe2',

                'SortOrder' => 2,

                'IsMenu' => true,

                'IsActive' => true,

            ],



            [

                'Code' => 'MASTER_ORGANIZATION',

                'Name' => 'Organization',

                'MenuArea' => 'TOP',

                'ParentID' => null,

                'Route' => null,

                'URL' => null,

                'Icon' => 'bi bi-diagram-3',

                'SortOrder' => 3,

                'IsMenu' => true,

                'IsActive' => true,

            ],



            [

                'Code' => 'MASTER_EMPLOYEE_HR',

                'Name' => 'Employee & HR',

                'MenuArea' => 'TOP',

                'ParentID' => null,

                'Route' => null,

                'URL' => null,

                'Icon' => 'bi bi-person-badge',

                'SortOrder' => 4,

                'IsMenu' => true,

                'IsActive' => true,

            ],



            [
                'Code' => 'MASTER_ASSET',
                'Name' => 'Asset Management',
                'MenuArea' => 'SIDEBAR',
                'ParentID' => null,
                'Route' => null,
                'URL' => null,
                'Icon' => 'bi bi-box-seam',
                'SortOrder' => 5,
                'IsMenu' => true,
                'IsActive' => true,
            ],

            [
                'Code' => 'MASTER_ASSET_GROUP',
                'Name' => 'Asset Group',
                'MenuArea' => 'SIDEBAR',
                'ParentID' => null,
                'Route' => 'master.asset-group.index',
                'URL' => null,
                'Icon' => 'bi bi-collection',
                'SortOrder' => 1,
                'IsMenu' => true,
                'IsActive' => true,
            ],

            [
                'Code' => 'MASTER_ASSET_TYPE',
                'Name' => 'Asset Type',
                'MenuArea' => 'SIDEBAR',
                'ParentID' => null,
                'Route' => 'master.asset-type.index',
                'URL' => null,
                'Icon' => 'bi bi-tags',
                'SortOrder' => 2,
                'IsMenu' => true,
                'IsActive' => true,
            ],

            [
                'Code' => 'MASTER_CURRENCY',
                'Name' => 'Currency',
                'MenuArea' => 'SIDEBAR',
                'ParentID' => null,
                'Route' => 'master.currency.index',
                'URL' => null,
                'Icon' => 'bi bi-currency-exchange',
                'SortOrder' => 3,
                'IsMenu' => true,
                'IsActive' => true,
            ],

            [
                'Code' => 'MASTER_ASSET_ITEM',
                'Name' => 'Asset',
                'MenuArea' => 'SIDEBAR',
                'ParentID' => null,
                'Route' => 'master.asset.index',
                'URL' => null,
                'Icon' => 'bi bi-box-seam-fill',
                'SortOrder' => 4,
                'IsMenu' => true,
                'IsActive' => true,
            ],

            [
                'Code' => 'MASTER_COMPANY',

                'Name' => 'Company',

                'MenuArea' => 'TOP',

                'ParentID' => null,

                'Route' => 'master.company.index',

                'URL' => null,

                'Icon' => 'bi bi-building',

                'SortOrder' => 1,

                'IsMenu' => true,

                'IsActive' => true,

            ],



            [

                'Code' => 'MASTER_EMAIL_GROUP',

                'Name' => 'Email Group',

                'MenuArea' => 'TOP',

                'ParentID' => null,

                'Route' => 'master.email-group.index',

                'URL' => null,

                'Icon' => 'bi bi-envelope-at',

                'SortOrder' => 2,

                'IsMenu' => true,

                'IsActive' => true,

            ],



            [

                'Code' => 'MASTER_COC',

                'Name' => 'Code of Conduct',

                'MenuArea' => 'TOP',

                'ParentID' => null,

                'Route' => 'master.coc.index',

                'URL' => null,

                'Icon' => 'bi bi-file-earmark-text',

                'SortOrder' => 3,

                'IsMenu' => true,

                'IsActive' => true,

            ],



            [

                'Code' => 'MASTER_COUNTRY',

                'Name' => 'Country',

                'MenuArea' => 'TOP',

                'ParentID' => null,

                'Route' => 'master.country.index',

                'URL' => null,

                'Icon' => 'bi bi-globe2',

                'SortOrder' => 1,

                'IsMenu' => true,

                'IsActive' => true,

            ],



            [

                'Code' => 'MASTER_PROVINCE',

                'Name' => 'Province',

                'MenuArea' => 'TOP',

                'ParentID' => null,

                'Route' => 'master.province.index',

                'URL' => null,

                'Icon' => 'bi bi-map',

                'SortOrder' => 2,

                'IsMenu' => true,

                'IsActive' => true,

            ],



            [

                'Code' => 'MASTER_CITY',

                'Name' => 'City',

                'MenuArea' => 'TOP',

                'ParentID' => null,

                'Route' => 'master.city.index',

                'URL' => null,

                'Icon' => 'bi bi-buildings',

                'SortOrder' => 3,

                'IsMenu' => true,

                'IsActive' => true,

            ],



            [

                'Code' => 'MASTER_DISTRICT',

                'Name' => 'District',

                'MenuArea' => 'TOP',

                'ParentID' => null,

                'Route' => 'master.district.index',

                'URL' => null,

                'Icon' => 'bi bi-geo',

                'SortOrder' => 4,

                'IsMenu' => true,

                'IsActive' => true,

            ],



            [

                'Code' => 'MASTER_VILLAGE',

                'Name' => 'Village',

                'MenuArea' => 'TOP',

                'ParentID' => null,

                'Route' => 'master.village.index',

                'URL' => null,

                'Icon' => 'bi bi-geo-alt',

                'SortOrder' => 5,

                'IsMenu' => true,

                'IsActive' => true,

            ],



            [

                'Code' => 'MASTER_DIRECTORATE',

                'Name' => 'Directorate',

                'MenuArea' => 'TOP',

                'ParentID' => null,

                'Route' => 'master.directorate.index',

                'URL' => null,

                'Icon' => 'bi bi-diagram-3',

                'SortOrder' => 1,

                'IsMenu' => true,

                'IsActive' => true,

            ],



            [

                'Code' => 'MASTER_DIVISION',

                'Name' => 'Division',

                'MenuArea' => 'TOP',

                'ParentID' => null,

                'Route' => 'master.division.index',

                'URL' => null,

                'Icon' => 'bi bi-diagram-2',

                'SortOrder' => 2,

                'IsMenu' => true,

                'IsActive' => true,

            ],



            [

                'Code' => 'MASTER_DEPARTMENT',

                'Name' => 'Department',

                'MenuArea' => 'TOP',

                'ParentID' => null,

                'Route' => 'master.department.index',

                'URL' => null,

                'Icon' => 'bi bi-diagram-3-fill',

                'SortOrder' => 3,

                'IsMenu' => true,

                'IsActive' => true,

            ],



            [

                'Code' => 'MASTER_RELIGION',

                'Name' => 'Religion',

                'MenuArea' => 'TOP',

                'ParentID' => null,

                'Route' => 'master.religion.index',

                'URL' => null,

                'Icon' => 'bi bi-person-heart',

                'SortOrder' => 1,

                'IsMenu' => true,

                'IsActive' => true,

            ],



            [

                'Code' => 'MASTER_JOB_LEVEL',

                'Name' => 'Job Level',

                'MenuArea' => 'TOP',

                'ParentID' => null,

                'Route' => 'master.job-level.index',

                'URL' => null,

                'Icon' => 'bi bi-bar-chart-steps',

                'SortOrder' => 2,

                'IsMenu' => true,

                'IsActive' => true,

            ],



            [

                'Code' => 'MASTER_JOB_TITLE',

                'Name' => 'Job Title',

                'MenuArea' => 'TOP',

                'ParentID' => null,

                'Route' => 'master.job-title.index',

                'URL' => null,

                'Icon' => 'bi bi-person-vcard',

                'SortOrder' => 3,

                'IsMenu' => true,

                'IsActive' => true,

            ],



            [

                'Code' => 'ADMINISTRATION',

                'Name' => 'Administration',

                'MenuArea' => 'TOP',

                'ParentID' => null,

                'Route' => null,

                'URL' => null,

                'Icon' => 'bi bi-shield-lock',

                'SortOrder' => 3,

                'IsMenu' => true,

                'IsActive' => true,

            ],



            [

                'Code' => 'SECURITY',

                'Name' => 'Security',

                'MenuArea' => 'TOP',

                'ParentID' => null,

                'Route' => null,

                'URL' => null,

                'Icon' => 'bi bi-shield-lock',

                'SortOrder' => 1,

                'IsMenu' => true,

                'IsActive' => true,

            ],



            [

                'Code' => 'SECURITY_USERS',

                'Name' => 'Users',

                'MenuArea' => 'TOP',

                'ParentID' => null,

                'Route' => 'security.users.index',

                'URL' => null,

                'Icon' => 'bi bi-people',

                'SortOrder' => 1,

                'IsMenu' => true,

                'IsActive' => true,

            ],



            [

                'Code' => 'SECURITY_ROLES',

                'Name' => 'Roles',

                'MenuArea' => 'TOP',

                'ParentID' => null,

                'Route' => 'security.roles.index',

                'URL' => null,

                'Icon' => 'bi bi-person-badge',

                'SortOrder' => 2,

                'IsMenu' => true,

                'IsActive' => true,

            ],



            [

                'Code' => 'SECURITY_MENUS',

                'Name' => 'Menus',

                'MenuArea' => 'TOP',

                'ParentID' => null,

                'Route' => 'security.menus.index',

                'URL' => null,

                'Icon' => 'bi bi-list',

                'SortOrder' => 3,

                'IsMenu' => true,

                'IsActive' => true,

            ],



            [

                'Code' => 'WORKFLOW',

                'Name' => 'Workflow',

                'MenuArea' => 'TOP',

                'ParentID' => null,

                'Route' => null,

                'URL' => null,

                'Icon' => 'bi bi-diagram-3',

                'SortOrder' => 4,

                'IsMenu' => true,

                'IsActive' => true,

            ],



            /*

             * =========================================================

             * SIDEBAR / TRANSACTION

             * =========================================================

             */



            [

                'Code' => 'MY_WORKSPACE',

                'Name' => 'My Workspace',

                'MenuArea' => 'SIDEBAR',

                'ParentID' => null,

                'Route' => null,

                'URL' => null,

                'Icon' => 'bi bi-grid',

                'SortOrder' => 1,

                'IsMenu' => true,

                'IsActive' => true,

            ],



            [

                'Code' => 'EMPLOYEE_FORM',

                'Name' => 'Employee Form Request',

                'MenuArea' => 'SIDEBAR',

                'ParentID' => null,

                'Route' => 'employee-form.index',

                'URL' => null,

                'Icon' => 'bi bi-file-earmark-person',

                'SortOrder' => 1,

                'IsMenu' => true,

                'IsActive' => true,

            ],

        ];



        foreach ($menus as $menu) {

            DB::table('sc_menu')->updateOrInsert(

                ['Code' => $menu['Code']],

                array_merge($menu, [

                    'ModifUser' => 'Admin',

                    'ModifDate' => now(),

                ])

            );

        }



        $parentMap = [

            'MASTER' => 'SYSTEM',

            'MASTER_CORPORATE' => 'MASTER',

            'MASTER_GEOGRAPHY' => 'MASTER',

            'MASTER_ORGANIZATION' => 'MASTER',

            'MASTER_EMPLOYEE_HR' => 'MASTER',
            'MASTER_ASSET' => null,

            'MASTER_ASSET_GROUP' => 'MASTER_ASSET',
            'MASTER_ASSET_TYPE' => 'MASTER_ASSET',
            'MASTER_CURRENCY' => 'MASTER_ASSET',
            'MASTER_ASSET_ITEM' => 'MASTER_ASSET',



            'MASTER_COMPANY' => 'MASTER_CORPORATE',

            'MASTER_EMAIL_GROUP' => 'MASTER_CORPORATE',

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



            'SECURITY' => 'ADMINISTRATION',

            'SECURITY_USERS' => 'SECURITY',

            'SECURITY_ROLES' => 'SECURITY',

            'SECURITY_MENUS' => 'SECURITY',



            'EMPLOYEE_FORM' => 'MY_WORKSPACE',

        ];



        foreach ($parentMap as $childCode => $parentCode) {

            $parentId = DB::table('sc_menu')

                ->where('Code', $parentCode)

                ->value('MenuID');



            DB::table('sc_menu')

                ->where('Code', $childCode)

                ->update([

                    'ParentID' => $parentId,

                    'ModifUser' => 'Admin',

                    'ModifDate' => now(),

                ]);

        }

    }

}
