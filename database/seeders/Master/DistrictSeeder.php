<?php

namespace Database\Seeders\Master;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class DistrictSeeder extends Seeder
{
    private const URL =
        'https://raw.githubusercontent.com/awanaprilino/wilayah-administrasi-kemendagri/main/csv/districts.csv';

    public function run(): void
    {
        $response = Http::timeout(180)
            ->retry(3, 1000)
            ->get(self::URL);

        if (! $response->successful()) {
            throw new RuntimeException(
                'Failed to download districts.csv. HTTP ' . $response->status()
            );
        }

        $handle = fopen('php://temp', 'r+');

        fwrite($handle, $response->body());
        rewind($handle);

        $header = fgetcsv($handle);

        $count = 0;

        while (($row = fgetcsv($handle)) !== false) {
            if (count($row) !== count($header)) {
                continue;
            }

            $data = array_combine($header, $row);

            DB::table('ms_district')->updateOrInsert(
                ['DistrictID' => (string) $data['id']],
                [
                    'CityID' => (string) $data['regency_id'],
                    'District' => trim($data['name']),
                    'IsActive' => true,
                    'InputUser' => 'admin',
                    'InputDate' => now(),
                    'ModifUser' => 'admin',
                    'ModifDate' => now(),
                ]
            );

            $count++;
        }

        fclose($handle);

        $this->command?->info("District master imported: {$count}");
    }
}
