<?php

namespace Database\Seeders\Security;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $menus = [

            [
                'Code' => 'DASHBOARD',
                'Name' => 'Dashboard',
                'Route' => 'dashboard',
                'Icon' => 'bi bi-speedometer2',
                'SortOrder' => 1,
                'IsMenu' => true,
                'IsActive' => true,
            ],

            // =========================
            // MASTER
            // =========================

            [
                'Code' => 'MASTER',
                'Name' => 'Master',
                'Route' => null,
                'Icon' => 'bi bi-database',
                'SortOrder' => 10,
                'IsMenu' => true,
                'IsActive' => true,
            ],

            [
                'Code' => 'MASTER_COMPANY',
                'Name' => 'Company',
                'Route' => 'master.company.index',
                'Icon' => 'bi bi-building',
                'SortOrder' => 11,
                'IsMenu' => true,
                'IsActive' => true,
            ],

            [
                'Code' => 'MASTER_RELIGION',
                'Name' => 'Religion',
                'Route' => 'master.religion.index',
                'Icon' => 'bi bi-person-heart',
                'SortOrder' => 12,
                'IsMenu' => true,
                'IsActive' => true,
            ],

            [
                'Code' => 'MASTER_COUNTRY',
                'Name' => 'Country',
                'Route' => 'master.country.index',
                'Icon' => 'bi bi-globe2',
                'SortOrder' => 12,
                'IsMenu' => true,
                'IsActive' => true,
            ],

            [
                'Code' => 'MASTER_PROVINCE',
                'Name' => 'Province',
                'Route' => 'master.province.index',
                'Icon' => 'bi bi-globe2',
                'SortOrder' => 12,
                'IsMenu' => true,
                'IsActive' => true,
            ],

            [
                'Code' => 'MASTER_CITY',
                'Name' => 'City',
                'Route' => 'master.city.index',
                'Icon' => 'bi bi-buildings',
                'SortOrder' => 13,
                'IsMenu' => true,
                'IsActive' => true,
            ],

            [
                'Code' => 'MASTER_DISTRICT',
                'Name' => 'District',
                'Route' => 'master.district.index',
                'Icon' => 'bi bi-map',
                'SortOrder' => 14,
                'IsMenu' => true,
                'IsActive' => true,
            ],

            [
                'Code' => 'MASTER_VILLAGE',
                'Name' => 'Village',
                'Route' => 'master.village.index',
                'Icon' => 'bi bi-pin-map',
                'SortOrder' => 15,
                'IsMenu' => true,
                'IsActive' => true,
            ],

            [
                'Code' => 'MASTER_DIRECTORATE',
                'Name' => 'Directorate',
                'Route' => 'master.directorate.index',
                'Icon' => 'bi bi-diagram-3',
                'SortOrder' => 13,
                'IsMenu' => true,
                'IsActive' => true,
            ],

            [
                'Code' => 'MASTER_DIVISION',
                'Name' => 'Division',
                'Route' => 'master.division.index',
                'Icon' => 'bi bi-diagram-2',
                'SortOrder' => 14,
                'IsMenu' => true,
                'IsActive' => true,
            ],

            [
                'Code' => 'MASTER_DEPARTMENT',
                'Name' => 'Department',
                'Route' => 'master.department.index',
                'Icon' => 'bi bi-building-gear',
                'SortOrder' => 15,
                'IsMenu' => true,
                'IsActive' => true,
            ],

            // =========================
            // SECURITY
            // =========================

            [
                'Code' => 'SECURITY',
                'Name' => 'Security',
                'Route' => null,
                'Icon' => 'bi bi-shield-lock',
                'SortOrder' => 20,
                'IsMenu' => true,
                'IsActive' => true,
            ],

            [
                'Code' => 'SECURITY_USERS',
                'Name' => 'Users',
                'Route' => 'security.users.index',
                'Icon' => 'bi bi-people',
                'SortOrder' => 21,
                'IsMenu' => true,
                'IsActive' => true,
            ],

            [
                'Code' => 'SECURITY_ROLES',
                'Name' => 'Roles',
                'Route' => 'security.roles.index',
                'Icon' => 'bi bi-person-badge',
                'SortOrder' => 22,
                'IsMenu' => true,
                'IsActive' => true,
            ],

            [
                'Code' => 'SECURITY_MENUS',
                'Name' => 'Menus',
                'Route' => 'security.menus.index',
                'Icon' => 'bi bi-list',
                'SortOrder' => 23,
                'IsMenu' => true,
                'IsActive' => true,
            ],
        ];

        foreach ($menus as $menu) {

            DB::table('sc_menu')->updateOrInsert(
                [
                    'Code' => $menu['Code'],
                ],
                array_merge(
                    $menu,
                    [
                        'UpdatedDate' => now(),
                    ]
                )
            );
        }

        // =========================
        // MASTER PARENT
        // =========================

        $masterId = DB::table('sc_menu')
            ->where('Code', 'MASTER')
            ->value('MenuID');

        DB::table('sc_menu')
            ->whereIn('Code', [
                'MASTER_COMPANY',
                'MASTER_COUNTRY',
                'MASTER_PROVINCE',
                'MASTER_CITY',
                'MASTER_DISTRICT',
                'MASTER_VILLAGE',
                'MASTER_RELIGION',
                'MASTER_DIRECTORATE',
                'MASTER_DIVISION',
                'MASTER_DEPARTMENT',
            ])
            ->update([
                'ParentID' => $masterId,
            ]);

        // =========================
        // SECURITY PARENT
        // =========================

        $securityId = DB::table('sc_menu')
            ->where('Code', 'SECURITY')
            ->value('MenuID');

        DB::table('sc_menu')
            ->whereIn('Code', [
                'SECURITY_USERS',
                'SECURITY_ROLES',
                'SECURITY_MENUS',
            ])
            ->update([
                'ParentID' => $securityId,
            ]);
    }
}
