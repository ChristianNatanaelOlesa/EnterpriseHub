<?php

namespace Database\Seeders\Security;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NormalizedSecuritySeeder extends Seeder
{
    private const PERMISSIONS = [
        'View' => 'View',
        'Create' => 'Create',
        'Update' => 'Update',
        'Delete' => 'Delete',
        'Approve' => 'Approve',
        'Print' => 'Print',
        'Export' => 'Export',
        'IT Fulfillment' => 'IT Fulfillment',
    ];

    public function run(): void
    {
        $now = now();

        foreach (self::PERMISSIONS as $permissionKey => $name) {
            DB::table('sc_permission')->updateOrInsert(
                ['Name' => $name],
                [
                    'IsActive' => true,
                    'InputUser' => 'Security seeder',
                    'InputDate' => $now,
                    'ModifUser' => 'Security seeder',
                    'ModifDate' => $now,
                ]
            );
        }
    }
}
