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
            ->pluck('DirID', 'DirID');

        $rows = [
            ['DivID' => 'ADV', 'DirID' => 'OTH', 'Division' => 'Corporate Advisor', 'IsActive' => false],
            ['DivID' => 'BOC', 'DirID' => 'BOM', 'Division' => 'Board Of Commissioner', 'IsActive' => false],
            ['DivID' => 'BOD', 'DirID' => 'BOM', 'Division' => 'Board Of Director', 'IsActive' => true],
            ['DivID' => 'BSA', 'DirID' => 'SUP', 'Division' => 'Business Analyst & Strategy Development', 'IsActive' => true],
            ['DivID' => 'CAC', 'DirID' => 'PRD', 'Division' => 'Corporate Actuaries', 'IsActive' => true],
            ['DivID' => 'CMP', 'DirID' => 'PRD', 'Division' => 'Risk Management & Compliance', 'IsActive' => true],
            ['DivID' => 'COM', 'DirID' => 'CCO', 'Division' => 'Committee', 'IsActive' => false],
            ['DivID' => 'CSC', 'DirID' => 'PRD', 'Division' => 'Corporate Secretary', 'IsActive' => true],
            ['DivID' => 'DPS', 'DirID' => 'SSB', 'Division' => 'Sharia Supervisory Board', 'IsActive' => false],
            ['DivID' => 'FAS', 'DirID' => 'SUP', 'Division' => 'Finance Accounting & Sharia', 'IsActive' => true],
            ['DivID' => 'GAC', 'DirID' => 'GRI', 'Division' => 'Claim Service & Loss Adjusting - General', 'IsActive' => true],
            ['DivID' => 'GCP', 'DirID' => 'GRI', 'Division' => 'Client Services & Post Acquisition Support - General', 'IsActive' => true],
            ['DivID' => 'GMC', 'DirID' => 'GRI', 'Division' => 'Facultative - General', 'IsActive' => true],
            ['DivID' => 'GRC', 'DirID' => 'PRD', 'Division' => 'Legal', 'IsActive' => true],
            ['DivID' => 'GSA', 'DirID' => 'CSL', 'Division' => 'General Sharia Admin & Claim', 'IsActive' => false],
            ['DivID' => 'GSU', 'DirID' => 'GRI', 'Division' => 'General Sharia Underwriting', 'IsActive' => false],
            ['DivID' => 'GUW', 'DirID' => 'GRI', 'Division' => 'Treaty, Retrocession & Risk Management', 'IsActive' => true],
            ['DivID' => 'HTC', 'DirID' => 'PRD', 'Division' => 'HC GA', 'IsActive' => true],
            ['DivID' => 'IAU', 'DirID' => 'PRD', 'Division' => 'Internal Auditor (Unit)', 'IsActive' => true],
            ['DivID' => 'INT', 'DirID' => 'SUP', 'Division' => 'Information Technology', 'IsActive' => true],
            ['DivID' => 'INV', 'DirID' => 'SUP', 'Division' => 'Investment', 'IsActive' => true],
            ['DivID' => 'LAC', 'DirID' => 'LRI', 'Division' => 'Client Services & Post Acquisition Support - Life', 'IsActive' => true],
            ['DivID' => 'LMC', 'DirID' => 'LRI', 'Division' => 'Claim Services & Loss Adjusting - Life', 'IsActive' => true],
            ['DivID' => 'LRS', 'DirID' => 'LRI', 'Division' => 'Sharia Reinsurance Unit', 'IsActive' => true],
            ['DivID' => 'LTC', 'DirID' => 'LRI', 'Division' => 'Life Technical II', 'IsActive' => false],
            ['DivID' => 'LTL', 'DirID' => 'LRI', 'Division' => 'Technical & Operation Life', 'IsActive' => true],
            ['DivID' => 'TAC', 'DirID' => 'SUP', 'Division' => 'Technical Accounting & Collection', 'IsActive' => true],
            ['DivID' => 'UNK', 'DirID' => 'UNK', 'Division' => 'Unknown', 'IsActive' => false],
        ];

        foreach ($rows as $row) {
            $directorateId = $directorates[$row['DirID']] ?? null;

            if ($directorateId === null) {
                throw new RuntimeException(
                    "Directorate dengan code {$row['DirID']} belum tersedia."
                );
            }

            DB::table('ms_division')->updateOrInsert(
                ['DivID' => $row['DivID']],
                [
                    'DirID' => $directorateId,
                    'Division' => $row['Division'],
                    'Description' => $row['Division'],
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
