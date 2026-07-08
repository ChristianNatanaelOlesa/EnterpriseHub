<?php

namespace Database\Seeders\Security;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        // Dashboard
        DB::table('Sc_Menu')->insert([
            'Code'         => 'DASHBOARD',
            'Name'         => 'Dashboard',
            'Route'        => 'dashboard.index',
            'URL'          => null,
            'Icon'         => 'bi-speedometer2',
            'SortOrder'    => 1,
            'IsMenu'       => true,
            'IsActive'     => true,
            'CreatedDate'  => now(),
        ]);

        // Master Header
        DB::table('Sc_Menu')->insert([
            'Code'         => 'MASTER',
            'Name'         => 'Master',
            'Route'        => null,
            'URL'          => null,
            'Icon'         => 'bi-database',
            'SortOrder'    => 2,
            'IsMenu'       => false,
            'IsActive'     => true,
            'CreatedDate'  => now(),
        ]);

        // Ambil ID Master
        $MasterID = DB::table('Sc_Menu')
            ->where('Code', 'MASTER')
            ->value('ID');

        DB::table('Sc_Menu')->insert([
            [
                'ParentID'     => $MasterID,
                'Code'         => 'MASTER_COMPANY',
                'Name'         => 'Company',
                'Route'        => 'master.company.index',
                'URL'          => null,
                'Icon'         => 'bi-building',
                'SortOrder'    => 1,
                'IsMenu'       => true,
                'IsActive'     => true,
                'CreatedDate'  => now(),
            ],
            [
                'ParentID'     => $MasterID,
                'Code'         => 'MASTER_DIRECTORATE',
                'Name'         => 'Directorate',
                'Route'        => 'master.directorate.index',
                'URL'          => null,
                'Icon'         => 'bi-diagram-3',
                'SortOrder'    => 2,
                'IsMenu'       => true,
                'IsActive'     => true,
                'CreatedDate'  => now(),
            ],
            [
                'ParentID'     => $MasterID,
                'Code'         => 'MASTER_DIVISION',
                'Name'         => 'Division',
                'Route'        => 'master.division.index',
                'URL'          => null,
                'Icon'         => 'bi-diagram-2',
                'SortOrder'    => 3,
                'IsMenu'       => true,
                'IsActive'     => true,
                'CreatedDate'  => now(),
            ],
            [
                'ParentID'     => $MasterID,
                'Code'         => 'MASTER_DEPARTMENT',
                'Name'         => 'Department',
                'Route'        => 'master.department.index',
                'URL'          => null,
                'Icon'         => 'bi-diagram-2-fill',
                'SortOrder'    => 4,
                'IsMenu'       => true,
                'IsActive'     => true,
                'CreatedDate'  => now(),
            ]
        ]);
    }
}
