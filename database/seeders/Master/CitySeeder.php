<?php

namespace Database\Seeders\Master;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class CitySeeder extends Seeder
{
    private const URL =
        'https://raw.githubusercontent.com/awanaprilino/wilayah-administrasi-kemendagri/main/csv/regencies.csv';

    private const PROVINCE_MAP = [
        '11' => 'ID-AC',
        '12' => 'ID-SU',
        '13' => 'ID-SB',
        '14' => 'ID-RI',
        '15' => 'ID-JA',
        '16' => 'ID-SM',
        '17' => 'ID-BE',
        '18' => 'ID-LA',
        '19' => 'ID-BB',
        '21' => 'ID-KR',

        '31' => 'ID-JK',
        '32' => 'ID-JB',
        '33' => 'ID-JT',
        '34' => 'ID-YO',
        '35' => 'ID-JI',
        '36' => 'ID-BT',

        '51' => 'ID-BA',
        '52' => 'ID-NB',
        '53' => 'ID-NT',

        '61' => 'ID-KB',
        '62' => 'ID-KT',
        '63' => 'ID-KS',
        '64' => 'ID-KI',
        '65' => 'ID-KU',

        '71' => 'ID-SA',
        '72' => 'ID-ST',
        '73' => 'ID-SN',
        '74' => 'ID-SG',
        '75' => 'ID-GO',
        '76' => 'ID-SR',

        '81' => 'ID-MA',
        '82' => 'ID-MU',

        '91' => 'ID-PA',
        '92' => 'ID-PB',
        '93' => 'ID-PS',
        '94' => 'ID-PE',
        '95' => 'ID-PT',
        '96' => 'ID-PD',
    ];

    public function run(): void
    {
        $response = Http::timeout(180)
            ->retry(3, 1000)
            ->get(self::URL);

        if (! $response->successful()) {
            throw new RuntimeException(
                'Failed to download regencies.csv. HTTP ' . $response->status()
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

            $provinceCode = str_pad(
                (string) $data['province_id'],
                2,
                '0',
                STR_PAD_LEFT
            );

            $provinceId = self::PROVINCE_MAP[$provinceCode] ?? null;

            if (! $provinceId) {
                continue;
            }

            DB::table('ms_city')->updateOrInsert(
                ['CityID' => (string) $data['id']],
                [
                    'ProvinceID' => $provinceId,
                    'City' => trim($data['name']),
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

        $this->command?->info("City master imported: {$count}");
    }
}
