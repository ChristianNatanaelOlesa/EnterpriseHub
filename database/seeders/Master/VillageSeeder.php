<?php

namespace Database\Seeders\Master;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class VillageSeeder extends Seeder
{
    private const URL =
        'https://raw.githubusercontent.com/awanaprilino/wilayah-administrasi-kemendagri/main/csv/villages.csv';

    public function run(): void
    {
        $response = Http::timeout(180)
            ->retry(3, 1000)
            ->get(self::URL);

        if (! $response->successful()) {
            throw new RuntimeException(
                'Failed to download villages.csv. HTTP ' . $response->status()
            );
        }

        $handle = fopen('php://temp', 'r+');

        if ($handle === false) {
            throw new RuntimeException('Failed to open temporary CSV file.');
        }

        fwrite($handle, $response->body());
        rewind($handle);

        $header = fgetcsv($handle);

        if ($header === false) {
            fclose($handle);
            throw new RuntimeException('Invalid villages.csv header.');
        }

        if (isset($header[0])) {
            $header[0] = preg_replace('/^\xEF\xBB\xBF/', '', $header[0]);
        }

        $count = 0;
        $batch = [];
        $username = 'admin';

        while (($row = fgetcsv($handle)) !== false) {
            if (count($row) !== count($header)) {
                continue;
            }

            $data = array_combine($header, $row);

            if ($data === false) {
                continue;
            }

            $villageId = trim((string) ($data['id'] ?? ''));

            if ($villageId === '' || ! ctype_digit($villageId)) {
                continue;
            }

            $batch[] = [
                'VillageID' => $villageId,
                'DistrictID' => trim((string) ($data['district_id'] ?? '')),
                'Village' => trim((string) ($data['name'] ?? '')),
                'PostalCode' => $data['postal_code']
                    ?? $data['postalcode']
                    ?? null,
                'IsActive' => true,
                'InputUser' => $username,
                'InputDate' => now(),
                'ModifUser' => $username,
                'ModifDate' => now(),
            ];

            if (count($batch) >= 1000) {
                DB::table('ms_village')->upsert(
                    $batch,
                    ['VillageID'],
                    [
                        'DistrictID',
                        'Village',
                        'PostalCode',
                        'IsActive',
                        'ModifUser',
                        'ModifDate',
                    ]
                );

                $count += count($batch);
                $batch = [];

                $this->command?->info("Imported {$count} villages...");
            }
        }

        if (! empty($batch)) {
            DB::table('ms_village')->upsert(
                $batch,
                ['VillageID'],
                [
                    'DistrictID',
                    'Village',
                    'PostalCode',
                    'IsActive',
                    'ModifUser',
                    'ModifDate',
                ]
            );

            $count += count($batch);
        }

        fclose($handle);

        $this->command?->info(
            "Village master imported successfully: {$count} records."
        );
    }
}
