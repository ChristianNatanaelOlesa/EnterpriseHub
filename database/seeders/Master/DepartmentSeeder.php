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
            ->pluck('DivID', 'DivID');

        $rows = [
            ['DeptID' => 'ACO', 'DivID' => 'COM', 'Department' => 'Audit Committee', 'IsActive' => false],
            ['DeptID' => 'ACT', 'DivID' => 'CAC', 'Department' => 'Actuaries', 'IsActive' => true],
            ['DeptID' => 'ANR', 'DivID' => 'GCP', 'Department' => 'Market Services', 'IsActive' => true],
            ['DeptID' => 'ANT', 'DivID' => 'FAS', 'Department' => 'Accounting & Tax', 'IsActive' => true],
            ['DeptID' => 'ATS', 'DivID' => 'FAS', 'Department' => 'Sharia Accounting & Tax', 'IsActive' => false],
            ['DeptID' => 'BNC', 'DivID' => 'TAC', 'Department' => 'Billing & Collection', 'IsActive' => true],
            ['DeptID' => 'CGC', 'DivID' => 'COM', 'Department' => 'Corporate Governance Policy Committee', 'IsActive' => false],
            ['DeptID' => 'CMP', 'DivID' => 'GRC', 'Department' => 'Compliance', 'IsActive' => false],
            ['DeptID' => 'CMS', 'DivID' => 'BOC', 'Department' => 'Commissioner', 'IsActive' => false],
            ['DeptID' => 'CSC', 'DivID' => 'CSC', 'Department' => 'Corporate Secretary', 'IsActive' => true],
            ['DeptID' => 'CSV', 'DivID' => 'HTC', 'Department' => 'Corporate Services', 'IsActive' => false],
            ['DeptID' => 'DIR', 'DivID' => 'BOD', 'Department' => 'Director', 'IsActive' => false],
            ['DeptID' => 'FAD', 'DivID' => 'ADV', 'Department' => 'Finance Accounting Advisor', 'IsActive' => false],
            ['DeptID' => 'FIS', 'DivID' => 'FAS', 'Department' => 'Sharia Finance', 'IsActive' => true],
            ['DeptID' => 'FNL', 'DivID' => 'GMC', 'Department' => 'Facultative Financial Lines & Marine', 'IsActive' => false],
            ['DeptID' => 'FNT', 'DivID' => 'FAS', 'Department' => 'Investment & Financial Analysis', 'IsActive' => true],
            ['DeptID' => 'GAM', 'DivID' => 'GUW', 'Department' => 'Account Management', 'IsActive' => false],
            ['DeptID' => 'GCS', 'DivID' => 'GAC', 'Department' => 'Claim Services & Loss Adjusting', 'IsActive' => true],
            ['DeptID' => 'GFM', 'DivID' => 'GMC', 'Department' => 'Facultative Financial Lines & Marine', 'IsActive' => true],
            ['DeptID' => 'GFP', 'DivID' => 'GUW', 'Department' => 'Facultative Industrial, Engineering Major Risks', 'IsActive' => true],
            ['DeptID' => 'GOS', 'DivID' => 'GCP', 'Department' => 'Operation Support & Administration - General', 'IsActive' => true],
            ['DeptID' => 'GRK', 'DivID' => 'GUW', 'Department' => 'Risk Management & Survey', 'IsActive' => true],
            ['DeptID' => 'GRS', 'DivID' => 'GUW', 'Department' => 'Analitycs, Retrocession & Outward', 'IsActive' => true],
            ['DeptID' => 'GSA', 'DivID' => 'GSU', 'Department' => 'Sharia Account Management', 'IsActive' => false],
            ['DeptID' => 'GSC', 'DivID' => 'GSA', 'Department' => 'Sharia Claim Services', 'IsActive' => false],
            ['DeptID' => 'GSF', 'DivID' => 'GSU', 'Department' => 'Sharia Facultative', 'IsActive' => false],
            ['DeptID' => 'GSO', 'DivID' => 'GSA', 'Department' => 'Sharia Administration', 'IsActive' => false],
            ['DeptID' => 'GSR', 'DivID' => 'GSU', 'Department' => 'Sharia Retro , Recovery, and Statistics', 'IsActive' => false],
            ['DeptID' => 'GST', 'DivID' => 'GSU', 'Department' => 'Sharia Treaty', 'IsActive' => false],
            ['DeptID' => 'GTS', 'DivID' => 'GUW', 'Department' => 'Pool KPIAI-TS', 'IsActive' => false],
            ['DeptID' => 'GTY', 'DivID' => 'GUW', 'Department' => 'General Treaty', 'IsActive' => true],
            ['DeptID' => 'HCM', 'DivID' => 'HTC', 'Department' => 'Human Capital Management', 'IsActive' => true],
            ['DeptID' => 'HCO', 'DivID' => 'HTC', 'Department' => 'Human Capital Operational & General Affair', 'IsActive' => true],
            ['DeptID' => 'IAU', 'DivID' => 'IAU', 'Department' => 'Internal Audit', 'IsActive' => true],
            ['DeptID' => 'ICM', 'DivID' => 'BOC', 'Department' => 'Independent Commissioner', 'IsActive' => false],
            ['DeptID' => 'ICO', 'DivID' => 'COM', 'Department' => 'Investment Committee', 'IsActive' => false],
            ['DeptID' => 'IND', 'DivID' => 'BOD', 'Department' => 'Independent Director', 'IsActive' => false],
            ['DeptID' => 'ITD', 'DivID' => 'INT', 'Department' => 'IT Development', 'IsActive' => true],
            ['DeptID' => 'ITI', 'DivID' => 'INT', 'Department' => 'IT Infrastructure', 'IsActive' => true],
            ['DeptID' => 'ITQ', 'DivID' => 'INT', 'Department' => 'IT Quality Assurance', 'IsActive' => true],
            ['DeptID' => 'ITR', 'DivID' => 'INT', 'Department' => 'IT Database & Reporting', 'IsActive' => true],
            ['DeptID' => 'ITS', 'DivID' => 'INT', 'Department' => 'IT Services', 'IsActive' => true],
            ['DeptID' => 'IVA', 'DivID' => 'FAS', 'Department' => 'Investment Administration', 'IsActive' => false],
            ['DeptID' => 'IVY', 'DivID' => 'FAS', 'Department' => 'Investment Analysis', 'IsActive' => false],
            ['DeptID' => 'LAD', 'DivID' => 'LMC', 'Department' => 'Post Acquisition Support 2 Life', 'IsActive' => true],
            ['DeptID' => 'LAS', 'DivID' => 'LMC', 'Department' => 'Post Acquisition Support 1 Life', 'IsActive' => true],
            ['DeptID' => 'LCS', 'DivID' => 'GAC', 'Department' => 'Data Analysis & Life Reinsurance Claims', 'IsActive' => true],
            ['DeptID' => 'LGL', 'DivID' => 'GRC', 'Department' => 'Legal', 'IsActive' => true],
            ['DeptID' => 'LMK', 'DivID' => 'LAC', 'Department' => 'Client Services - Life', 'IsActive' => true],
            ['DeptID' => 'LPA', 'DivID' => 'LTL', 'Department' => 'Life Pricing & Valuation', 'IsActive' => true],
            ['DeptID' => 'LRS', 'DivID' => 'GUW', 'Department' => 'Retro Life Reinsurance', 'IsActive' => true],
            ['DeptID' => 'LSA', 'DivID' => 'LRS', 'Department' => 'Life Sharia Admin & Claim', 'IsActive' => true],
            ['DeptID' => 'LSM', 'DivID' => 'LRS', 'Department' => 'Life Sharia Marketing', 'IsActive' => true],
            ['DeptID' => 'LSU', 'DivID' => 'LRS', 'Department' => 'Life Sharia Technical (U/W, Actuarial, Retro)', 'IsActive' => true],
            ['DeptID' => 'LUW', 'DivID' => 'LTL', 'Department' => 'Life Underwriting', 'IsActive' => true],
            ['DeptID' => 'PCM', 'DivID' => 'BOC', 'Department' => 'President Commissioner', 'IsActive' => false],
            ['DeptID' => 'PDR', 'DivID' => 'BOD', 'Department' => 'President Director', 'IsActive' => false],
            ['DeptID' => 'PDS', 'DivID' => 'LTL', 'Department' => 'Product Development & Life Reinsurance Statistics', 'IsActive' => true],
            ['DeptID' => 'RCO', 'DivID' => 'COM', 'Department' => 'Risk Monitoring Committee', 'IsActive' => false],
            ['DeptID' => 'RMO', 'DivID' => 'BSA', 'Department' => 'Business Analyst', 'IsActive' => true],
            ['DeptID' => 'RSA', 'DivID' => 'GMC', 'Department' => 'Facultative Non-Marine', 'IsActive' => true],
            ['DeptID' => 'RSM', 'DivID' => 'CMP', 'Department' => 'Risk Management & Compliance', 'IsActive' => true],
            ['DeptID' => 'SCH', 'DivID' => 'DPS', 'Department' => 'DPS Chairman', 'IsActive' => false],
            ['DeptID' => 'SMB', 'DivID' => 'DPS', 'Department' => 'DPS Member', 'IsActive' => false],
            ['DeptID' => 'TAC', 'DivID' => 'TAC', 'Department' => 'Technical Accounting', 'IsActive' => true],
            ['DeptID' => 'TAD', 'DivID' => 'ADV', 'Department' => 'Technical Advisor', 'IsActive' => false],
            ['DeptID' => 'TRN', 'DivID' => 'HTC', 'Department' => 'Training', 'IsActive' => false],
            ['DeptID' => 'UNK', 'DivID' => 'UNK', 'Department' => 'Unknown', 'IsActive' => false],
            ['DeptID' => 'VPD', 'DivID' => 'BOD', 'Department' => 'Vice President Director', 'IsActive' => false],
        ];

        foreach ($rows as $row) {
            $divisionId = $divisions[$row['DivID']] ?? null;

            if ($divisionId === null) {
                throw new RuntimeException(
                    "Division dengan code {$row['DivID']} belum tersedia."
                );
            }

            DB::table('ms_department')->updateOrInsert(
                ['DeptID' => $row['DeptID']],
                [
                    'DivID' => $divisionId,
                    'Department' => $row['Department'],
                    'Description' => $row['Department'],
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
