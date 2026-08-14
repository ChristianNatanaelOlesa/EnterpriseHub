<?php

namespace Database\Seeders\Security;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $Menus = [

            [
                'Code'      => 'DASHBOARD',
                'Name'      => 'Dashboard',
                'Route'     => 'dashboard',
                'Icon'      => 'bi bi-speedometer2',
                'SortOrder' => 1,
                'IsMenu'    => true,
                'IsActive'  => true,
            ],

            [
                'Code'      => 'MASTER',
                'Name'      => 'Master',
                'Icon'      => 'bi bi-database',
                'SortOrder' => 10,
                'IsMenu'    => true,
                'IsActive'  => true,
            ],

            [
                'Code'      => 'MASTER_COMPANY',
                'Name'      => 'Company',
                'Route'     => 'master.company.index',
                'Icon'      => 'bi bi-building',
                'SortOrder' => 11,
                'IsMenu'    => true,
                'IsActive'  => true,
            ],

            [
                'Code'      => 'SECURITY',
                'Name'      => 'Security',
                'Icon'      => 'bi bi-shield-lock',
                'SortOrder' => 20,
                'IsMenu'    => true,
                'IsActive'  => true,
            ],

            [
                'Code'      => 'SECURITY_USERS',
                'Name'      => 'Users',
                'Route'     => 'security.users.index',
                'Icon'      => 'bi bi-people',
                'SortOrder' => 21,
                'IsMenu'    => true,
                'IsActive'  => true,
            ],

            [
                'Code'      => 'SECURITY_ROLES',
                'Name'      => 'Roles',
                'Route'     => 'security.roles.index',
                'Icon'      => 'bi bi-person-badge',
                'SortOrder' => 22,
                'IsMenu'    => true,
                'IsActive'  => true,
            ],

            [
                'Code'      => 'SECURITY_MENUS',
                'Name'      => 'Menus',
                'Route'     => 'security.menus.index',
                'Icon'      => 'bi bi-list',
                'SortOrder' => 23,
                'IsMenu'    => true,
                'IsActive'  => true,
            ],

        ];

        foreach ($Menus as $Menu) {

            DB::table('sc_menu')->updateOrInsert(
                [
                    'Code' => $Menu['Code'],
                ],
                array_merge(
                    $Menu,
                    [
                        'CreatedDate' => now(),
                    ]
                )
            );
        }

        $MasterID = DB::table('sc_menu')
            ->where('Code', 'MASTER')
            ->value('MenuID');

        DB::table('sc_menu')
            ->where('Code', 'MASTER_COMPANY')
            ->update([
                'ParentID' => $MasterID,
            ]);

        $SecurityID = DB::table('sc_menu')
            ->where('Code', 'SECURITY')
            ->value('MenuID');

        DB::table('sc_menu')
            ->whereIn('Code', [
                'SECURITY_USERS',
                'SECURITY_ROLES',
                'SECURITY_MENUS',
            ])
            ->update([
                'ParentID' => $SecurityID,
            ]);
    }
}
