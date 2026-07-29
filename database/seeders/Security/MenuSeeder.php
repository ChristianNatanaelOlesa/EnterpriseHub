<?php

namespace Database\Seeders\Security;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        // Dashboard
        DB::table('Sc_Menu')->updateOrInsert(
            [
                'Code' => 'DASHBOARD',
            ],
            [
                'ParentID' => null,
                'Name' => 'Dashboard',
                'Route' => 'dashboard.index',
                'URL' => null,
                'Icon' => 'bi-speedometer2',
                'SortOrder' => 1,
                'IsMenu' => true,
                'IsActive' => true,
                'CreatedDate' => now(),
            ]
        );

        // Master
        DB::table('Sc_Menu')->updateOrInsert(
            [
                'Code' => 'MASTER',
            ],
            [
                'ParentID' => null,
                'Name' => 'Master',
                'Route' => null,
                'URL' => null,
                'Icon' => 'bi-database',
                'SortOrder' => 2,
                'IsMenu' => false,
                'IsActive' => true,
                'CreatedDate' => now(),
            ]
        );

        $MasterID = DB::table('Sc_Menu')
            ->where('Code', 'MASTER')
            ->value('ID');

        DB::table('Sc_Menu')->updateOrInsert(
            [
                'Code' => 'MASTER_COMPANY',
            ],
            [
                'ParentID' => $MasterID,
                'Name' => 'Company',
                'Route' => 'master.company.index',
                'URL' => null,
                'Icon' => 'bi-building',
                'SortOrder' => 1,
                'IsMenu' => true,
                'IsActive' => true,
                'CreatedDate' => now(),
            ]
        );

        DB::table('Sc_Menu')->updateOrInsert(
            [
                'Code' => 'MASTER_DIRECTORATE',
            ],
            [
                'ParentID' => $MasterID,
                'Name' => 'Directorate',
                'Route' => 'master.directorate.index',
                'URL' => null,
                'Icon' => 'bi-diagram-3',
                'SortOrder' => 2,
                'IsMenu' => true,
                'IsActive' => true,
                'CreatedDate' => now(),
            ]
        );

        DB::table('Sc_Menu')->updateOrInsert(
            [
                'Code' => 'MASTER_DIVISION',
            ],
            [
                'ParentID' => $MasterID,
                'Name' => 'Division',
                'Route' => 'master.division.index',
                'URL' => null,
                'Icon' => 'bi-diagram-2',
                'SortOrder' => 3,
                'IsMenu' => true,
                'IsActive' => true,
                'CreatedDate' => now(),
            ]
        );

        DB::table('Sc_Menu')->updateOrInsert(
            [
                'Code' => 'MASTER_DEPARTMENT',
            ],
            [
                'ParentID' => $MasterID,
                'Name' => 'Department',
                'Route' => 'master.department.index',
                'URL' => null,
                'Icon' => 'bi-diagram-2-fill',
                'SortOrder' => 4,
                'IsMenu' => true,
                'IsActive' => true,
                'CreatedDate' => now(),
            ]
        );
    }
}
