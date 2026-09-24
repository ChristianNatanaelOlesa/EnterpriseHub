<?php

namespace Database\Seeders\Master;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        $countries = [
            ['CountryID' => 'IDN', 'Country' => 'Indonesia'],
        ];

        foreach ($countries as $country) {
            DB::table('ms_country')->updateOrInsert(
                ['CountryID' => $country['CountryID']],
                [
                    'Country' => $country['Country'],
                    'IsActive' => true,
                    'InputUser' => 'admin',
                    'InputDate' => now(),
                    'ModifUser' => 'admin',
                    'ModifDate' => now(),
                ]
            );
        }

        $this->command?->info('Country master imported.');
    }
}
