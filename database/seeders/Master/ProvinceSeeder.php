<?php

namespace Database\Seeders\Master;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvinceSeeder extends Seeder
{
    private const PROVINCES = [
        ['ID-AC', 'Aceh'],
        ['ID-SU', 'Sumatera Utara'],
        ['ID-SB', 'Sumatera Barat'],
        ['ID-RI', 'Riau'],
        ['ID-JA', 'Jambi'],
        ['ID-SM', 'Sumatera Selatan'],
        ['ID-BE', 'Bengkulu'],
        ['ID-LA', 'Lampung'],
        ['ID-BB', 'Kepulauan Bangka Belitung'],
        ['ID-KR', 'Kepulauan Riau'],

        ['ID-JK', 'DKI Jakarta'],
        ['ID-JB', 'Jawa Barat'],
        ['ID-JT', 'Jawa Tengah'],
        ['ID-YO', 'Daerah Istimewa Yogyakarta'],
        ['ID-JI', 'Jawa Timur'],
        ['ID-BT', 'Banten'],

        ['ID-BA', 'Bali'],
        ['ID-NB', 'Nusa Tenggara Barat'],
        ['ID-NT', 'Nusa Tenggara Timur'],

        ['ID-KB', 'Kalimantan Barat'],
        ['ID-KT', 'Kalimantan Tengah'],
        ['ID-KS', 'Kalimantan Selatan'],
        ['ID-KI', 'Kalimantan Timur'],
        ['ID-KU', 'Kalimantan Utara'],

        ['ID-SA', 'Sulawesi Utara'],
        ['ID-ST', 'Sulawesi Tengah'],
        ['ID-SN', 'Sulawesi Selatan'],
        ['ID-SG', 'Sulawesi Tenggara'],
        ['ID-GO', 'Gorontalo'],
        ['ID-SR', 'Sulawesi Barat'],

        ['ID-MA', 'Maluku'],
        ['ID-MU', 'Maluku Utara'],

        ['ID-PA', 'Papua'],
        ['ID-PB', 'Papua Barat'],
        ['ID-PS', 'Papua Selatan'],
        ['ID-PE', 'Papua Tengah'],
        ['ID-PT', 'Papua Pegunungan'],
        ['ID-PD', 'Papua Barat Daya'],
    ];

    public function run(): void
    {
        foreach (self::PROVINCES as [$provinceId, $province]) {
            DB::table('ms_province')->updateOrInsert(
                ['ProvinceID' => $provinceId],
                [
                    'CountryID' => 'IDN',
                    'Province' => $province,
                    'IsActive' => true,
                    'InputUser' => 'admin',
                    'InputDate' => now(),
                    'ModifUser' => 'admin',
                    'ModifDate' => now(),
                ]
            );
        }

        $this->command?->info('Province master imported: ' . count(self::PROVINCES));
    }
}
