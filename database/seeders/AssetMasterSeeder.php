<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssetMasterSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // =========================================================
        // Ms_AssetGroup
        // =========================================================
        $groups = [
            ['BANGUNAN-NP', 'Bangunan Non-Permanen', 10, 10, 'Bangunan non-permanen'],
            ['BANGUNAN-P', 'Bangunan Permanen', 20, 20, 'Bangunan permanen'],
            ['ELEKTRONIK', 'Inventaris Elektronik', 4, 4, 'Inventaris elektronik'],
            ['FURNITURE', 'Inventaris Furniture', 8, 8, 'Inventaris furniture'],
            ['KOMPUTER', 'Inventaris Komputer', 4, 4, 'Inventaris komputer'],
            ['LOGAM', 'Inventaris Logam', 8, 8, 'Inventaris logam'],
            ['KENDARAAN', 'Kendaraan Bermotor', 8, 8, 'Kendaraan bermotor'],
            ['TANAH', 'Tanah', null, null, 'Tanah'],
        ];

        foreach ($groups as [$id, $name, $comLifetime, $fiscalLifetime, $description]) {
            DB::table('ms_asset_group')->updateOrInsert(
                ['AssGroupID' => $id],
                [
                    'AssetGroup' => $name,
                    'ComLifetime' => $comLifetime,
                    'FiscalLifetime' => $fiscalLifetime,
                    'Description' => $description,
                    'IsActive' => true,
                    'InputUser' => 'Admin',
                    'InputDate' => $now,
                    'ModifUser' => 'Admin',
                    'ModifDate' => $now,
                    'DeletedBy' => null,
                    'DeletedDate' => null,
                ]
            );
        }

        // =========================================================
        // Ms_AssetType
        // =========================================================
        $types = [
            ['AT-AP', 'ELEKTRONIK', 'Access Point', 'Perangkat jaringan wireless / access point.'],
            ['AT-ELEC', 'ELEKTRONIK', 'Elektronik', 'Peralatan elektronik lainnya.'],
            ['AT-COMP', 'KOMPUTER', 'Komputer', 'Komputer atau perangkat desktop/laptop.'],
            ['AT-MON', 'KOMPUTER', 'Monitor', 'Monitor komputer.'],
            ['AT-OTHER', 'ELEKTRONIK', 'Lain - Lain', 'Asset lain yang tidak termasuk kategori utama.'],
            ['AT-PRN', 'KOMPUTER', 'Printer', 'Perangkat printer.'],
            ['AT-PROJ', 'ELEKTRONIK', 'Proyektor', 'Perangkat proyektor.'],
            ['AT-SCAN', 'KOMPUTER', 'Scanner', 'Perangkat scanner.'],
            ['AT-SRV', 'KOMPUTER', 'Server', 'Perangkat server.'],
            ['AT-SW', 'ELEKTRONIK', 'Switch', 'Perangkat jaringan switch.'],
            ['AT-TAB', 'KOMPUTER', 'Tablet', 'Perangkat tablet.'],
            ['AT-UPS', 'ELEKTRONIK', 'UPS', 'Uninterruptible Power Supply.'],
        ];

        foreach ($types as [$id, $groupId, $name, $description]) {
            DB::table('ms_asset_type')->updateOrInsert(
                ['AssTypeID' => $id],
                [
                    'AssetGroupID' => $groupId,
                    'AssetType' => $name,
                    'TypeDesc' => $description,
                    'IsActive' => true,
                    'InputUser' => 'Admin',
                    'InputDate' => $now,
                    'ModifUser' => 'Admin',
                    'ModifDate' => $now,
                    'DeletedBy' => null,
                    'DeletedDate' => null,
                ]
            );
        }

        // =========================================================
        // Ms_Currency
        // =========================================================
        $currencies = [
            ['IDR', 'Indonesian Rupiah', 1],
            ['USD', 'United States Dollar', 2],
            ['SGD', 'Singapore Dollar', 3],
        ];

        foreach ($currencies as [$id, $name, $priority]) {
            DB::table('ms_currency')->updateOrInsert(
                ['CcyID' => $id],
                [
                    'Currency' => $name,
                    'Priority' => $priority,
                    'IsActive' => true,
                    'InputUser' => 'Admin',
                    'InputDate' => $now,
                    'ModifUser' => 'Admin',
                    'ModifDate' => $now,
                    'DeletedBy' => null,
                    'DeletedDate' => null,
                ]
            );
        }

        // =========================================================
        // Ms_Asset
        // VendorID masih NULL sampai Master Vendor dibuat.
        // QRCode sementara menggunakan AssetID sebagai payload unik.
        // =========================================================
        $assets = [
            ['AST-000001', 'AT-COMP', 'Laptop Development IT', 'Lenovo', 'ThinkPad E14', 'PF4XYZ001', 'Black', 'Intel Core i5, RAM 16 GB, SSD 512 GB', 'Asset contoh untuk kebutuhan development IT.', null, '2026-01-15', 'IDR', 1, 12500000, 12500000, true, '2028-01-15', false],
            ['AST-000002', 'AT-MON', 'Monitor IT', 'Dell', 'P2422H', 'CN0MON002', 'Black', '24 inch Full HD IPS Monitor', '-', null, '2026-02-10', 'IDR', 1, 3200000, 3200000, true, '2028-02-10', false],
            ['AST-000003', 'AT-AP', 'Wireless Access Point', 'TP-Link', 'EAP610', 'TPAP003', 'White', 'WiFi 6 Access Point, Gigabit Ethernet', '-', null, '2026-03-05', 'IDR', 1, 1850000, 1850000, true, '2028-03-05', false],
            ['AST-000004', 'AT-PRN', 'Office Printer', 'Epson', 'L3250', 'X4PRN004', 'Black', 'Ink Tank Multifunction Printer', '-', null, '2026-03-20', 'IDR', 1, 2750000, 2750000, false, '1900-01-01', false],
            ['AST-000005', 'AT-SRV', 'Application Server', 'Dell', 'PowerEdge R550', 'SVR005', 'Black', 'Rack Server, Xeon, 64 GB RAM, SSD RAID', 'Server untuk kebutuhan aplikasi internal.', null, '2026-04-01', 'USD', 16500, 2500, 41250000, true, '2029-04-01', true],
        ];

        foreach ($assets as $asset) {
            [$assetId, $typeId, $assetDesc, $brand, $model, $serialNo, $color, $specification, $notes, $vendorId, $purchaseDate, $ccyId, $exchRate, $acqCost, $acqCostIdr, $isWarranty, $warrantyDate, $isIso] = $asset;

            DB::table('ms_asset')->updateOrInsert(
                ['AssetID' => $assetId],
                [
                    'AssTypeID' => $typeId,
                    'QRCode' => $assetId,
                    'AssetDesc' => $assetDesc,
                    'Brand' => $brand,
                    'Model' => $model,
                    'SerialNo' => $serialNo,
                    'Color' => $color,
                    'Specification' => $specification,
                    'Notes' => $notes ?: '-',
                    'VendorID' => $vendorId,
                    'PurchaseDate' => $purchaseDate,
                    'CcyID' => $ccyId,
                    'ExchRate' => $exchRate,
                    'AcqCost' => $acqCost,
                    'AcqCostIDR' => $acqCostIdr,
                    'IsWarranty' => $isWarranty,
                    'WarrantyDate' => $warrantyDate,
                    'IsISO' => $isIso,
                    'IsActive' => true,
                    'InputUser' => 'Admin',
                    'InputDate' => $now,
                    'ModifUser' => 'Admin',
                    'ModifDate' => $now,
                    'DeletedBy' => null,
                    'DeletedDate' => null,
                ]
            );
        }
    }
}
