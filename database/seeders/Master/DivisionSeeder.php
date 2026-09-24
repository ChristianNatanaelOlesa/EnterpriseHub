<?php

namespace Database\Seeders\Master;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class DivisionSeeder extends Seeder
{
    public function run(): void
    {
        $directorates = DB::table('ms_directorate')
            ->pluck('DirectorateID', 'DirectorateCode');

        $rows = [
            ['DivisionCode' => 'ADV', 'DirectorateCode' => 'OTH', 'DivisionName' => 'Corporate Advisor', 'IsActive' => false],
            ['DivisionCode' => 'BOC', 'DirectorateCode' => 'BOM', 'DivisionName' => 'Board Of Commissioner', 'IsActive' => false],
            ['DivisionCode' => 'BOD', 'DirectorateCode' => 'BOM', 'DivisionName' => 'Board Of Director', 'IsActive' => true],
            ['DivisionCode' => 'BSA', 'DirectorateCode' => 'SUP', 'DivisionName' => 'Business Analyst & Strategy Development', 'IsActive' => true],
            ['DivisionCode' => 'CAC', 'DirectorateCode' => 'PRD', 'DivisionName' => 'Corporate Actuaries', 'IsActive' => true],
            ['DivisionCode' => 'CMP', 'DirectorateCode' => 'PRD', 'DivisionName' => 'Risk Management & Compliance', 'IsActive' => true],
            ['DivisionCode' => 'COM', 'DirectorateCode' => 'CCO', 'DivisionName' => 'Committee', 'IsActive' => false],
            ['DivisionCode' => 'CSC', 'DirectorateCode' => 'PRD', 'DivisionName' => 'Corporate Secretary', 'IsActive' => true],
            ['DivisionCode' => 'DPS', 'DirectorateCode' => 'SSB', 'DivisionName' => 'Sharia Supervisory Board', 'IsActive' => false],
            ['DivisionCode' => 'FAS', 'DirectorateCode' => 'SUP', 'DivisionName' => 'Finance Accounting & Sharia', 'IsActive' => true],
            ['DivisionCode' => 'GAC', 'DirectorateCode' => 'GRI', 'DivisionName' => 'Claim Service & Loss Adjusting - General', 'IsActive' => true],
            ['DivisionCode' => 'GCP', 'DirectorateCode' => 'GRI', 'DivisionName' => 'Client Services & Post Acquisition Support - General', 'IsActive' => true],
            ['DivisionCode' => 'GMC', 'DirectorateCode' => 'GRI', 'DivisionName' => 'Facultative - General', 'IsActive' => true],
            ['DivisionCode' => 'GRC', 'DirectorateCode' => 'PRD', 'DivisionName' => 'Legal', 'IsActive' => true],
            ['DivisionCode' => 'GSA', 'DirectorateCode' => 'CSL', 'DivisionName' => 'General Sharia Admin & Claim', 'IsActive' => false],
            ['DivisionCode' => 'GSU', 'DirectorateCode' => 'GRI', 'DivisionName' => 'General Sharia Underwriting', 'IsActive' => false],
            ['DivisionCode' => 'GUW', 'DirectorateCode' => 'GRI', 'DivisionName' => 'Treaty, Retrocession & Risk Management', 'IsActive' => true],
            ['DivisionCode' => 'HTC', 'DirectorateCode' => 'PRD', 'DivisionName' => 'HC GA', 'IsActive' => true],
            ['DivisionCode' => 'IAU', 'DirectorateCode' => 'PRD', 'DivisionName' => 'Internal Auditor (Unit)', 'IsActive' => true],
            ['DivisionCode' => 'INT', 'DirectorateCode' => 'SUP', 'DivisionName' => 'Information Technology', 'IsActive' => true],
            ['DivisionCode' => 'INV', 'DirectorateCode' => 'SUP', 'DivisionName' => 'Investment', 'IsActive' => true],
            ['DivisionCode' => 'LAC', 'DirectorateCode' => 'LRI', 'DivisionName' => 'Client Services & Post Acquisition Support - Life', 'IsActive' => true],
            ['DivisionCode' => 'LMC', 'DirectorateCode' => 'LRI', 'DivisionName' => 'Claim Services & Loss Adjusting - Life', 'IsActive' => true],
            ['DivisionCode' => 'LRS', 'DirectorateCode' => 'LRI', 'DivisionName' => 'Sharia Reinsurance Unit', 'IsActive' => true],
            ['DivisionCode' => 'LTC', 'DirectorateCode' => 'LRI', 'DivisionName' => 'Life Technical II', 'IsActive' => false],
            ['DivisionCode' => 'LTL', 'DirectorateCode' => 'LRI', 'DivisionName' => 'Technical & Operation Life', 'IsActive' => true],
            ['DivisionCode' => 'TAC', 'DirectorateCode' => 'SUP', 'DivisionName' => 'Technical Accounting & Collection', 'IsActive' => true],
            ['DivisionCode' => 'UNK', 'DirectorateCode' => 'UNK', 'DivisionName' => 'Unknown', 'IsActive' => false],
        ];

        foreach ($rows as $row) {
            $directorateId = $directorates[$row['DirectorateCode']] ?? null;

            if ($directorateId === null) {
                throw new RuntimeException(
                    "Directorate dengan code {$row['DirectorateCode']} belum tersedia."
                );
            }

            DB::table('ms_division')->updateOrInsert(
                ['DivisionCode' => $row['DivisionCode']],
                [
                    'DirectorateID' => $directorateId,
                    'DivisionName' => $row['DivisionName'],
                    'IsActive' => $row['IsActive'],
                    'InputUser' => 'Admin',
                    'InputDate' => now(),
                    'ModifUser' => 'Admin',
                    'ModifDate' => now(),
                    'DeletedBy' => null,
                    'DeletedDate' => null,
                ]
            );
        }
    }
}
