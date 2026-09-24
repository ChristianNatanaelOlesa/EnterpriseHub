<?php

namespace Database\Seeders\Master;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $divisions = DB::table('ms_division')
            ->pluck('DivisionID', 'DivisionCode');

        $rows = [
            ['DepartmentCode' => 'ACO', 'DivisionCode' => 'COM', 'DepartmentName' => 'Audit Committee', 'IsActive' => false],
            ['DepartmentCode' => 'ACT', 'DivisionCode' => 'CAC', 'DepartmentName' => 'Actuaries', 'IsActive' => true],
            ['DepartmentCode' => 'ANR', 'DivisionCode' => 'GCP', 'DepartmentName' => 'Market Services', 'IsActive' => true],
            ['DepartmentCode' => 'ANT', 'DivisionCode' => 'FAS', 'DepartmentName' => 'Accounting & Tax', 'IsActive' => true],
            ['DepartmentCode' => 'ATS', 'DivisionCode' => 'FAS', 'DepartmentName' => 'Sharia Accounting & Tax', 'IsActive' => false],
            ['DepartmentCode' => 'BNC', 'DivisionCode' => 'TAC', 'DepartmentName' => 'Billing & Collection', 'IsActive' => true],
            ['DepartmentCode' => 'CGC', 'DivisionCode' => 'COM', 'DepartmentName' => 'Corporate Governance Policy Committee', 'IsActive' => false],
            ['DepartmentCode' => 'CMP', 'DivisionCode' => 'GRC', 'DepartmentName' => 'Compliance', 'IsActive' => false],
            ['DepartmentCode' => 'CMS', 'DivisionCode' => 'BOC', 'DepartmentName' => 'Commissioner', 'IsActive' => false],
            ['DepartmentCode' => 'CSC', 'DivisionCode' => 'CSC', 'DepartmentName' => 'Corporate Secretary', 'IsActive' => true],
            ['DepartmentCode' => 'CSV', 'DivisionCode' => 'HTC', 'DepartmentName' => 'Corporate Services', 'IsActive' => false],
            ['DepartmentCode' => 'DIR', 'DivisionCode' => 'BOD', 'DepartmentName' => 'Director', 'IsActive' => false],
            ['DepartmentCode' => 'FAD', 'DivisionCode' => 'ADV', 'DepartmentName' => 'Finance Accounting Advisor', 'IsActive' => false],
            ['DepartmentCode' => 'FIS', 'DivisionCode' => 'FAS', 'DepartmentName' => 'Sharia Finance', 'IsActive' => true],
            ['DepartmentCode' => 'FNL', 'DivisionCode' => 'GMC', 'DepartmentName' => 'Facultative Financial Lines & Marine', 'IsActive' => false],
            ['DepartmentCode' => 'FNT', 'DivisionCode' => 'FAS', 'DepartmentName' => 'Investment & Financial Analysis', 'IsActive' => true],
            ['DepartmentCode' => 'GAM', 'DivisionCode' => 'GUW', 'DepartmentName' => 'Account Management', 'IsActive' => false],
            ['DepartmentCode' => 'GCS', 'DivisionCode' => 'GAC', 'DepartmentName' => 'Claim Services & Loss Adjusting', 'IsActive' => true],
            ['DepartmentCode' => 'GFM', 'DivisionCode' => 'GMC', 'DepartmentName' => 'Facultative Financial Lines & Marine', 'IsActive' => true],
            ['DepartmentCode' => 'GFP', 'DivisionCode' => 'GUW', 'DepartmentName' => 'Facultative Industrial, Engineering Major Risks', 'IsActive' => true],
            ['DepartmentCode' => 'GOS', 'DivisionCode' => 'GCP', 'DepartmentName' => 'Operation Support & Administration - General', 'IsActive' => true],
            ['DepartmentCode' => 'GRK', 'DivisionCode' => 'GUW', 'DepartmentName' => 'Risk Management & Survey', 'IsActive' => true],
            ['DepartmentCode' => 'GRS', 'DivisionCode' => 'GUW', 'DepartmentName' => 'Analitycs, Retrocession & Outward', 'IsActive' => true],
            ['DepartmentCode' => 'GSA', 'DivisionCode' => 'GSU', 'DepartmentName' => 'Sharia Account Management', 'IsActive' => false],
            ['DepartmentCode' => 'GSC', 'DivisionCode' => 'GSA', 'DepartmentName' => 'Sharia Claim Services', 'IsActive' => false],
            ['DepartmentCode' => 'GSF', 'DivisionCode' => 'GSU', 'DepartmentName' => 'Sharia Facultative', 'IsActive' => false],
            ['DepartmentCode' => 'GSO', 'DivisionCode' => 'GSA', 'DepartmentName' => 'Sharia Administration', 'IsActive' => false],
            ['DepartmentCode' => 'GSR', 'DivisionCode' => 'GSU', 'DepartmentName' => 'Sharia Retro , Recovery, and Statistics', 'IsActive' => false],
            ['DepartmentCode' => 'GST', 'DivisionCode' => 'GSU', 'DepartmentName' => 'Sharia Treaty', 'IsActive' => false],
            ['DepartmentCode' => 'GTS', 'DivisionCode' => 'GUW', 'DepartmentName' => 'Pool KPIAI-TS', 'IsActive' => false],
            ['DepartmentCode' => 'GTY', 'DivisionCode' => 'GUW', 'DepartmentName' => 'General Treaty', 'IsActive' => true],
            ['DepartmentCode' => 'HCM', 'DivisionCode' => 'HTC', 'DepartmentName' => 'Human Capital Management', 'IsActive' => true],
            ['DepartmentCode' => 'HCO', 'DivisionCode' => 'HTC', 'DepartmentName' => 'Human Capital Operational & General Affair', 'IsActive' => true],
            ['DepartmentCode' => 'IAU', 'DivisionCode' => 'IAU', 'DepartmentName' => 'Internal Audit', 'IsActive' => true],
            ['DepartmentCode' => 'ICM', 'DivisionCode' => 'BOC', 'DepartmentName' => 'Independent Commissioner', 'IsActive' => false],
            ['DepartmentCode' => 'ICO', 'DivisionCode' => 'COM', 'DepartmentName' => 'Investment Committee', 'IsActive' => false],
            ['DepartmentCode' => 'IND', 'DivisionCode' => 'BOD', 'DepartmentName' => 'Independent Director', 'IsActive' => false],
            ['DepartmentCode' => 'ITD', 'DivisionCode' => 'INT', 'DepartmentName' => 'IT Development', 'IsActive' => true],
            ['DepartmentCode' => 'ITI', 'DivisionCode' => 'INT', 'DepartmentName' => 'IT Infrastructure', 'IsActive' => true],
            ['DepartmentCode' => 'ITQ', 'DivisionCode' => 'INT', 'DepartmentName' => 'IT Quality Assurance', 'IsActive' => true],
            ['DepartmentCode' => 'ITR', 'DivisionCode' => 'INT', 'DepartmentName' => 'IT Database & Reporting', 'IsActive' => true],
            ['DepartmentCode' => 'ITS', 'DivisionCode' => 'INT', 'DepartmentName' => 'IT Services', 'IsActive' => true],
            ['DepartmentCode' => 'IVA', 'DivisionCode' => 'FAS', 'DepartmentName' => 'Investment Administration', 'IsActive' => false],
            ['DepartmentCode' => 'IVY', 'DivisionCode' => 'FAS', 'DepartmentName' => 'Investment Analysis', 'IsActive' => false],
            ['DepartmentCode' => 'LAD', 'DivisionCode' => 'LMC', 'DepartmentName' => 'Post Acquisition Support 2 Life', 'IsActive' => true],
            ['DepartmentCode' => 'LAS', 'DivisionCode' => 'LMC', 'DepartmentName' => 'Post Acquisition Support 1 Life', 'IsActive' => true],
            ['DepartmentCode' => 'LCS', 'DivisionCode' => 'GAC', 'DepartmentName' => 'Data Analysis & Life Reinsurance Claims', 'IsActive' => true],
            ['DepartmentCode' => 'LGL', 'DivisionCode' => 'GRC', 'DepartmentName' => 'Legal', 'IsActive' => true],
            ['DepartmentCode' => 'LMK', 'DivisionCode' => 'LAC', 'DepartmentName' => 'Client Services - Life', 'IsActive' => true],
            ['DepartmentCode' => 'LPA', 'DivisionCode' => 'LTL', 'DepartmentName' => 'Life Pricing & Valuation', 'IsActive' => true],
            ['DepartmentCode' => 'LRS', 'DivisionCode' => 'GUW', 'DepartmentName' => 'Retro Life Reinsurance', 'IsActive' => true],
            ['DepartmentCode' => 'LSA', 'DivisionCode' => 'LRS', 'DepartmentName' => 'Life Sharia Admin & Claim', 'IsActive' => true],
            ['DepartmentCode' => 'LSM', 'DivisionCode' => 'LRS', 'DepartmentName' => 'Life Sharia Marketing', 'IsActive' => true],
            ['DepartmentCode' => 'LSU', 'DivisionCode' => 'LRS', 'DepartmentName' => 'Life Sharia Technical (U/W, Actuarial, Retro)', 'IsActive' => true],
            ['DepartmentCode' => 'LUW', 'DivisionCode' => 'LTL', 'DepartmentName' => 'Life Underwriting', 'IsActive' => true],
            ['DepartmentCode' => 'PCM', 'DivisionCode' => 'BOC', 'DepartmentName' => 'President Commissioner', 'IsActive' => false],
            ['DepartmentCode' => 'PDR', 'DivisionCode' => 'BOD', 'DepartmentName' => 'President Director', 'IsActive' => false],
            ['DepartmentCode' => 'PDS', 'DivisionCode' => 'LTL', 'DepartmentName' => 'Product Development & Life Reinsurance Statistics', 'IsActive' => true],
            ['DepartmentCode' => 'RCO', 'DivisionCode' => 'COM', 'DepartmentName' => 'Risk Monitoring Committee', 'IsActive' => false],
            ['DepartmentCode' => 'RMO', 'DivisionCode' => 'BSA', 'DepartmentName' => 'Business Analyst', 'IsActive' => true],
            ['DepartmentCode' => 'RSA', 'DivisionCode' => 'GMC', 'DepartmentName' => 'Facultative Non-Marine', 'IsActive' => true],
            ['DepartmentCode' => 'RSM', 'DivisionCode' => 'CMP', 'DepartmentName' => 'Risk Management & Compliance', 'IsActive' => true],
            ['DepartmentCode' => 'SCH', 'DivisionCode' => 'DPS', 'DepartmentName' => 'DPS Chairman', 'IsActive' => false],
            ['DepartmentCode' => 'SMB', 'DivisionCode' => 'DPS', 'DepartmentName' => 'DPS Member', 'IsActive' => false],
            ['DepartmentCode' => 'TAC', 'DivisionCode' => 'TAC', 'DepartmentName' => 'Technical Accounting', 'IsActive' => true],
            ['DepartmentCode' => 'TAD', 'DivisionCode' => 'ADV', 'DepartmentName' => 'Technical Advisor', 'IsActive' => false],
            ['DepartmentCode' => 'TRN', 'DivisionCode' => 'HTC', 'DepartmentName' => 'Training', 'IsActive' => false],
            ['DepartmentCode' => 'UNK', 'DivisionCode' => 'UNK', 'DepartmentName' => 'Unknown', 'IsActive' => false],
            ['DepartmentCode' => 'VPD', 'DivisionCode' => 'BOD', 'DepartmentName' => 'Vice President Director', 'IsActive' => false],
        ];

        foreach ($rows as $row) {
            $divisionId = $divisions[$row['DivisionCode']] ?? null;

            if ($divisionId === null) {
                throw new RuntimeException(
                    "Division dengan code {$row['DivisionCode']} belum tersedia."
                );
            }

            DB::table('ms_department')->updateOrInsert(
                ['DepartmentCode' => $row['DepartmentCode']],
                [
                    'DivisionID' => $divisionId,
                    'DepartmentName' => $row['DepartmentName'],
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
