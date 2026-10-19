<?php

namespace Database\Seeders\Master;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CocSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $rows = [
            ['COC001', 'COC Employee Equipment', 'Kode Etik & Ketentuan Peminjaman Aset TI', 'Kode Etik & Ketentuan Peminjaman Aset TI', 'code-of-conduct/COC001/20260924100740_kode-etik-ketentuan-peminjaman-aset-ti.pdf'],
            ['COC002', 'COC Employee VPN Access', 'Kode Etik Penggunaan Akses VPN', 'Kode Etik Penggunaan Akses VPN', 'code-of-conduct/COC002/20260924102056_kode-etik-penggunaan-akses-vpn.pdf'],
            ['COC003', 'COC Employee Email', 'Kode Etik Penggunaan Email Personal & Corporate', 'Kode Etik Penggunaan Email Personal & Corporate', 'code-of-conduct/COC003/20260924102123_kode-etik-penggunaan-email-personal-corporate.pdf'],
            ['COC004', 'COC Employee Software', 'Kode Etik Penggunaan Software atau Tool diluar Standar', 'Kode Etik Penggunaan Software atau Tool diluar Standar', 'code-of-conduct/COC004/20260924102324_kode-etik-penggunaan-software-atau-tool-diluar-standar.pdf'],
            ['COC005', 'COC Employee Network', 'Kode Etik Pengunaan WLAN, Hotspot, & Internet', 'Kode Etik Pengunaan WLAN, Hotspot, & Internet', 'code-of-conduct/COC005/20260924102349_kode-etik-pengunaan-wlan-hotspot-internet.pdf'],
            ['COC006', 'COC Employee Network Drive', 'Kode Etik Penyimpanan Data Eksternal', 'Kode Etik Penyimpanan Data Eksternal', 'code-of-conduct/COC006/20260924102416_kode-etik-penyimpanan-data-eksternal.pdf'],
        ];

        foreach ($rows as [$id, $name, $description, $contents, $fileLoc]) {
            DB::table('Ms_Coc')->updateOrInsert(
                ['CocID' => $id],
                [
                    'Name' => $name,
                    'Description' => $description,
                    'Contents' => $contents,
                    'FileLoc' => $fileLoc,
                    'InputDate' => $now,
                    'InputUser' => 'Admin',
                    'ModifDate' => $now,
                    'ModifUser' => 'Admin',
                ]
            );
        }
    }
}
