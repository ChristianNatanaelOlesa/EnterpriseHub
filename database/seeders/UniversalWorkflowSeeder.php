<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UniversalWorkflowSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        $user = auth()->user()?->Username ?? 'Admin';

        $processes = [
            'EMPLOYEE_EQUIPMENT' => 'Employee Equipment',
            'EMPLOYEE_SOFTWARE' => 'Employee Software',
            'EMPLOYEE_IT_AREA' => 'Employee IT Area',
            'EMPLOYEE_SHARING_FOLDER' => 'Employee Sharing Folder',
            'EMPLOYEE_NETWORK' => 'Employee Network',
            'EMPLOYEE_EMAIL' => 'Employee Email',
            'EMPLOYEE_APPLICATION_EXTERNAL' => 'Employee Application External',
            'EMPLOYEE_APPLICATION_INTERNAL' => 'Employee Application Internal',
            'EMPLOYEE_FORM_NEW' => 'Employee Form Request - New',
            'EMPLOYEE_FORM_MUTATION' => 'Employee Form Request - Mutation',
            'EMPLOYEE_FORM_RESIGN' => 'Employee Form Request - Resign',
        ];

        foreach ($processes as $processId => $name) {
            DB::table('wf_process')->updateOrInsert(
                ['ProcessID' => $processId],
                [
                    'Process' => $name,
                    'ProcessDesc' => 'Universal approval workflow',
                    'EffectiveDate' => $now->toDateString(),
                    'SLADays' => null,
                    'IsActive' => true,
                    'InputDate' => $now,
                    'InputUser' => $user,
                    'ModifDate' => $now,
                    'ModifUser' => $user,
                ]
            );
        }

        $general = [
            [
                'code' => 'STAFF',
                'name' => 'Staff approval chain',
                'condition' => 'STAFF',
                'steps' => [
                    ['HEAD_DEPARTMENT_REQUESTER', 'Kabag Terkait', 'HEAD_DEPARTMENT', ['scope' => 'REQUESTER']],
                    ['HEAD_DIVISION_REQUESTER', 'Kadiv Terkait', 'HEAD_DIVISION', ['scope' => 'REQUESTER']],
                    ['HEAD_IT_INFRA', 'Kabag IT Infra', 'HEAD_DEPARTMENT', ['department_id' => 'ITI']],
                    ['HEAD_IT', 'Kadiv IT', 'HEAD_DIVISION', ['division_id' => 'INT']],
                ],
            ],
            [
                'code' => 'HEAD_DEPARTMENT',
                'name' => 'Head of Department approval chain',
                'condition' => 'HEAD_DEPARTMENT',
                'steps' => [
                    ['HEAD_DIVISION_REQUESTER', 'Kadiv Terkait', 'HEAD_DIVISION', ['scope' => 'REQUESTER']],
                    ['HEAD_IT_INFRA', 'Kabag IT Infra', 'HEAD_DEPARTMENT', ['department_id' => 'ITI']],
                    ['HEAD_IT', 'Kadiv IT', 'HEAD_DIVISION', ['division_id' => 'INT']],
                ],
            ],
            [
                'code' => 'HEAD_DIVISION',
                'name' => 'Head of Division approval chain',
                'condition' => 'HEAD_DIVISION',
                'steps' => [
                    ['HEAD_IT_INFRA', 'Kabag IT Infra', 'HEAD_DEPARTMENT', ['department_id' => 'ITI']],
                    ['HEAD_IT', 'Kadiv IT', 'HEAD_DIVISION', ['division_id' => 'INT']],
                ],
            ],
            [
                'code' => 'DIRECTOR',
                'name' => 'Director approval chain',
                'condition' => 'DIRECTOR',
                'steps' => [
                    ['HEAD_IT_INFRA', 'Kabag IT Infra', 'HEAD_DEPARTMENT', ['department_id' => 'ITI']],
                    ['HEAD_IT', 'Kadiv IT', 'HEAD_DIVISION', ['division_id' => 'INT']],
                ],
            ],
        ];

        foreach ($processes as $processId => $_) {
            $this->seedGeneralRules($processId, $general, $now, $user);
        }

        $this->seedInternalApplication($now, $user);
        $this->seedEmployeeForm($now, $user);
    }

    protected function seedGeneralRules(string $processId, array $definitions, $now, string $user): void
    {
        foreach ($definitions as $priority => $definition) {
            $definition['priority'] = $priority + 1;
            $ruleId = $this->upsertRule($processId, $definition, $now, $user);
            $this->replaceSteps($ruleId, $definition['steps'], $now, $user);
        }
    }

    protected function seedInternalApplication($now, string $user): void
    {
        $processId = 'EMPLOYEE_APPLICATION_INTERNAL';

        $definitions = [
            [
                'code' => 'STAFF',
                'name' => 'Staff approval chain',
                'condition' => 'STAFF',
                'priority' => 1,
                'steps' => [
                    ['HEAD_DEPARTMENT_REQUESTER', 'Kabag Terkait', 'HEAD_DEPARTMENT', ['scope' => 'REQUESTER']],
                    ['HEAD_DIVISION_REQUESTER', 'Kadiv Terkait', 'HEAD_DIVISION', ['scope' => 'REQUESTER']],
                    ['HEAD_IT_DEVELOPMENT', 'Kabag IT Development', 'HEAD_DEPARTMENT', ['department_id' => 'ITD']],
                    ['HEAD_IT', 'Kadiv IT', 'HEAD_DIVISION', ['division_id' => 'INT']],
                ],
            ],
            [
                'code' => 'HEAD_DEPARTMENT',
                'name' => 'Head of Department approval chain',
                'condition' => 'HEAD_DEPARTMENT',
                'priority' => 2,
                'steps' => [
                    ['HEAD_DIVISION_REQUESTER', 'Kadiv Terkait', 'HEAD_DIVISION', ['scope' => 'REQUESTER']],
                    ['HEAD_IT_INFRA', 'Kabag IT Infra', 'HEAD_DEPARTMENT', ['department_id' => 'ITI']],
                    ['HEAD_IT', 'Kadiv IT', 'HEAD_DIVISION', ['division_id' => 'INT']],
                ],
            ],
            [
                'code' => 'HEAD_DIVISION',
                'name' => 'Head of Division approval chain',
                'condition' => 'HEAD_DIVISION',
                'priority' => 3,
                'steps' => [
                    ['HEAD_IT_INFRA', 'Kabag IT Infra', 'HEAD_DEPARTMENT', ['department_id' => 'ITI']],
                    ['HEAD_IT', 'Kadiv IT', 'HEAD_DIVISION', ['division_id' => 'INT']],
                ],
            ],
            [
                'code' => 'DIRECTOR',
                'name' => 'Director approval chain',
                'condition' => 'DIRECTOR',
                'priority' => 4,
                'steps' => [
                    ['HEAD_IT_INFRA', 'Kabag IT Infra', 'HEAD_DEPARTMENT', ['department_id' => 'ITI']],
                    ['HEAD_IT', 'Kadiv IT', 'HEAD_DIVISION', ['division_id' => 'INT']],
                ],
            ],
        ];

        foreach ($definitions as $definition) {
            $ruleId = $this->upsertRule($processId, $definition, $now, $user);
            $this->replaceSteps($ruleId, $definition['steps'], $now, $user);
        }
    }

    protected function seedEmployeeForm($now, string $user): void
    {
        $definitions = [
            'EMPLOYEE_FORM_NEW' => [
                'NEW',
                'Employee Form Request - New',
                [
                    ['TARGET_REPORT_TO', 'Atasan Karyawan Yang Diajukan', 'TARGET_EMPLOYEE_REPORT_TO', []],
                    ['HEAD_IT_INFRA', 'Kabag IT Infra', 'HEAD_DEPARTMENT', ['department_id' => 'ITI']],
                    ['HEAD_IT_DATABASE', 'Kabag IT Database', 'HEAD_DEPARTMENT', ['department_id' => 'ITR']],
                    ['HEAD_IT_DEVELOPMENT', 'Kabag IT Development', 'HEAD_DEPARTMENT', ['department_id' => 'ITD']],
                    ['HEAD_IT', 'Kadiv IT', 'HEAD_DIVISION', ['division_id' => 'INT']],
                ],
            ],
            'EMPLOYEE_FORM_MUTATION' => [
                'MUTATION',
                'Employee Form Request - Mutation',
                [
                    ['TARGET_REPORT_TO', 'Atasan Karyawan Yang Diajukan', 'TARGET_EMPLOYEE_REPORT_TO', []],
                    ['HEAD_IT_INFRA', 'Kabag IT Infra', 'HEAD_DEPARTMENT', ['department_id' => 'ITI']],
                    ['HEAD_IT_DATABASE', 'Kabag IT Database', 'HEAD_DEPARTMENT', ['department_id' => 'ITR']],
                    ['HEAD_IT_DEVELOPMENT', 'Kabag IT Development', 'HEAD_DEPARTMENT', ['department_id' => 'ITD']],
                    ['HEAD_IT', 'Kadiv IT', 'HEAD_DIVISION', ['division_id' => 'INT']],
                ],
            ],
            'EMPLOYEE_FORM_RESIGN' => [
                'RESIGN',
                'Employee Form Request - Resign',
                [
                    ['TARGET_REPORT_TO', 'Atasan Karyawan Yang Diajukan', 'TARGET_EMPLOYEE_REPORT_TO', []],
                    ['HEAD_IT_DEVELOPMENT', 'Kabag IT Development', 'HEAD_DEPARTMENT', ['department_id' => 'ITD']],
                    ['HEAD_IT_DATABASE', 'Kabag IT Database', 'HEAD_DEPARTMENT', ['department_id' => 'ITR']],
                    ['HEAD_IT_INFRA', 'Kabag IT Infra', 'HEAD_DEPARTMENT', ['department_id' => 'ITI']],
                    ['HEAD_IT', 'Kadiv IT', 'HEAD_DIVISION', ['division_id' => 'INT']],
                ],
            ],
        ];

        foreach ($definitions as $processId => [$condition, $name, $steps]) {
            $definition = [
                'code' => $condition,
                'name' => $name,
                'condition' => 'ANY',
                'priority' => 1,
                'steps' => $steps,
            ];

            $ruleId = $this->upsertRule($processId, $definition, $now, $user);
            $this->replaceSteps($ruleId, $steps, $now, $user);
        }
    }

    protected function upsertRule(string $processId, array $definition, $now, string $user): int
    {
        DB::table('wf_approval_rule')->updateOrInsert(
            ['ProcessID' => $processId, 'RuleCode' => $definition['code']],
            [
                'RuleName' => $definition['name'],
                'ConditionType' => $definition['condition'] === 'ANY' ? 'ANY' : 'REQUESTER_SCOPE',
                'ConditionValue' => $definition['condition'] === 'ANY' ? null : $definition['condition'],
                'Priority' => $definition['priority'],
                'RevisionMode' => 'RETURN_TO_REVISION_APPROVER',
                'EffectiveDate' => $now->toDateString(),
                'IsActive' => true,
                'InputDate' => $now,
                'InputUser' => $user,
                'ModifDate' => $now,
                'ModifUser' => $user,
            ]
        );

        return (int) DB::table('wf_approval_rule')
            ->where(['ProcessID' => $processId, 'RuleCode' => $definition['code']])
            ->value('ApprovalRuleID');
    }

    protected function replaceSteps(int $ruleId, array $steps, $now, string $user): void
    {
        DB::table('wf_approval_step')->where('ApprovalRuleID', $ruleId)->delete();

        foreach ($steps as $index => [$code, $name, $resolver, $config]) {
            DB::table('wf_approval_step')->insert([
                'ApprovalRuleID' => $ruleId,
                'StepNo' => $index + 1,
                'StepCode' => $code,
                'StepName' => $name,
                'ResolverType' => $resolver,
                'ResolverConfig' => json_encode($config, JSON_THROW_ON_ERROR),
                'IsMandatory' => true,
                'AllowSelfSkip' => true,
                'SLADays' => null,
                'IsActive' => true,
                'InputDate' => $now,
                'InputUser' => $user,
                'ModifDate' => $now,
                'ModifUser' => $user,
            ]);
        }
    }
}
