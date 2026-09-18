<?php

namespace Database\Seeders\Master;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class IndonesiaRegionSeeder extends Seeder
{
    private const BASE_URL = 'https://raw.githubusercontent.com/awanaprilino/wilayah-administrasi-kemendagri/main/csv/';

    private const PROVINCE_MAP = [
        '11' => 'ID-AC', '12' => 'ID-SU', '13' => 'ID-SB', '14' => 'ID-RI', '15' => 'ID-JA',
        '16' => 'ID-SM', '17' => 'ID-BE', '18' => 'ID-LA', '19' => 'ID-BB', '21' => 'ID-KR',
        '31' => 'ID-JK', '32' => 'ID-JB', '33' => 'ID-JT', '34' => 'ID-YO', '35' => 'ID-JI',
        '36' => 'ID-BT', '51' => 'ID-BA', '52' => 'ID-NB', '53' => 'ID-NT', '61' => 'ID-KB',
        '62' => 'ID-KT', '63' => 'ID-KS', '64' => 'ID-KI', '65' => 'ID-KU', '71' => 'ID-SA',
        '72' => 'ID-ST', '73' => 'ID-SN', '74' => 'ID-SG', '75' => 'ID-GO', '76' => 'ID-SR',
        '81' => 'ID-MA', '82' => 'ID-MU', '91' => 'ID-PA', '92' => 'ID-PB', '93' => 'ID-PS',
        '94' => 'ID-PE', '95' => 'ID-PT', '96' => 'ID-PD',
    ];

    public function run(): void
    {
        $this->command?->info('Importing Indonesian city/regency data...');
        $this->importCities();
        $this->command?->info('Importing Indonesian district data...');
        $this->importDistricts();
        $this->command?->info('Importing Indonesian village data...');
        $this->importVillages();
        $this->command?->info('Indonesia region master import completed.');
    }

    private function csv(string $file): array
    {
        $response = Http::timeout(180)->retry(3, 1000)->get(self::BASE_URL . $file);
        if (! $response->successful()) {
            throw new RuntimeException("Failed to download {$file}: HTTP {$response->status()}");
        }

        $handle = fopen('php://temp', 'r+');
        fwrite($handle, $response->body());
        rewind($handle);
        $header = fgetcsv($handle);
        if (isset($header[0])) {
            $header[0] = preg_replace('/^\xEF\xBB\xBF/', '', $header[0]);
        }
        $rows = [];
        while (($row = fgetcsv($handle)) !== false) {
            if (count($row) === count($header)) {
                $rows[] = array_combine($header, $row);
            }
        }
        fclose($handle);
        return $rows;
    }

    private function importCities(): void
    {
        $rows = $this->csv('regencies.csv');
        foreach (array_chunk($rows, 500) as $chunk) {
            $data = [];
            foreach ($chunk as $row) {
                $provinceId = self::PROVINCE_MAP[str_pad((string) $row['province_id'], 2, '0', STR_PAD_LEFT)] ?? null;
                if (! $provinceId) continue;
                $data[] = [
                    'CityID' => (string) $row['id'],
                    'ProvinceID' => $provinceId,
                    'City' => trim($row['name']),
                    'IsActive' => true,
                    'InputUser' => 'Admin', 'InputDate' => now(),
                    'ModifUser' => 'Admin', 'ModifDate' => now(),
                ];
            }
            DB::table('ms_city')->upsert($data, ['CityID'], ['ProvinceID','City','IsActive']);
        }
    }

    private function importDistricts(): void
    {
        $rows = $this->csv('districts.csv');
        foreach (array_chunk($rows, 500) as $chunk) {
            $data = [];
            foreach ($chunk as $row) {
                $data[] = [
                    'DistrictID' => (string) $row['id'],
                    'CityID' => (string) $row['regency_id'],
                    'District' => trim($row['name']),
                    'IsActive' => true,
                    'InputUser' => 'Admin', 'InputDate' => now(),
                    'ModifUser' => 'Admin', 'ModifDate' => now(),
                ];
            }
            DB::table('ms_district')->upsert($data, ['DistrictID'], ['CityID','District','IsActive']);
        }
    }

    private function importVillages(): void
    {
        $rows = $this->csv('villages.csv');
        foreach (array_chunk($rows, 1000) as $chunk) {
            $data = [];
            foreach ($chunk as $row) {
                $data[] = [
                    'VillageID' => (int) $row['id'],
                    'DistrictID' => (string) $row['district_id'],
                    'Village' => trim($row['name']),
                    'PostalCode' => $row['postal_code'] ?? $row['postalcode'] ?? null,
                    'IsActive' => true,
                    'InputUser' => 'Admin', 'InputDate' => now(),
                    'ModifUser' => 'Admin', 'ModifDate' => now(),
                ];
            }
            DB::table('ms_village')->upsert($data, ['VillageID'], ['DistrictID','Village','PostalCode','IsActive']);
        }
    }
}

