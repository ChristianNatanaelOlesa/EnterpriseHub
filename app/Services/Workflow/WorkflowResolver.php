<?php

namespace App\Services\Workflow;

use App\Enums\WorkflowResolverType;
use App\Models\Security\ScUser;
use App\Models\Workflow\WfApprovalStep;
use Illuminate\Support\Facades\DB;

class WorkflowResolver
{
    public function requesterScope(?object $profile): string
    {
        if (!$profile) {
            return 'STAFF';
        }

        $title = strtolower(trim((string) ($profile->JobTitle ?? '')));
        $level = strtolower(trim((string) ($profile->JobLevel ?? '')));

        if (
            in_array($level, ['director', 'president director'], true)
            || (str_contains($title, 'director') && !str_contains($title, 'vice director'))
        ) {
            return 'DIRECTOR';
        }

        if (str_contains($title, 'head') && str_contains($title, 'division')) {
            return 'HEAD_DIVISION';
        }

        if (str_contains($title, 'head') && str_contains($title, 'department')) {
            return 'HEAD_DEPARTMENT';
        }

        return 'STAFF';
    }

    public function profileByEmpFormId(?string $empFormId): ?object
    {
        if (!$empFormId) {
            return null;
        }

        return DB::table('tr_empformhist as h')
            ->leftJoin('ms_job_title as jt', 'h.JobTitleID', '=', 'jt.JobTitleID')
            ->leftJoin('ms_job_level as jl', 'h.JobLvlID', '=', 'jl.JobLevelID')
            ->where('h.EmpFormID', $empFormId)
            ->orderByDesc('h.EffectiveDate')
            ->orderByDesc('h.EmpFormHistID')
            ->select([
                'h.EmpFormHistID', 'h.EmpFormID', 'h.DirID', 'h.DivID', 'h.DeptID',
                'h.JobLvlID', 'h.JobTitleID', 'h.ReportTo',
                'h.EffectiveDate', 'h.IsActive',
                'jt.JobTitle', 'jl.JobLevel',
            ])
            ->first();
    }

    public function resolve(WfApprovalStep $step, array $context): ?ScUser
    {
        $type = WorkflowResolverType::tryFrom((string) $step->ResolverType);
        $config = is_array($step->ResolverConfig) ? $step->ResolverConfig : [];

        return match ($type) {
            WorkflowResolverType::REQUESTER_REPORT_TO => $this->reportToUser($context['requesterProfile'] ?? null),
            WorkflowResolverType::TARGET_EMPLOYEE_REPORT_TO => $this->reportToUser($context['targetProfile'] ?? null),
            WorkflowResolverType::HEAD_DEPARTMENT => $this->headOfDepartment(
                $this->resolveOrgValue($config, 'department_id', $context['requesterProfile'] ?? null, 'DeptID')
            ),
            WorkflowResolverType::HEAD_DIVISION => $this->headOfDivision(
                $this->resolveOrgValue($config, 'division_id', $context['requesterProfile'] ?? null, 'DivID')
            ),
            WorkflowResolverType::DIRECTOR => $this->directorOfDirectorate(
                $this->resolveOrgValue($config, 'directorate_id', $context['requesterProfile'] ?? null, 'DirID')
            ),
            WorkflowResolverType::FIXED_USER => $this->activeUser($config['user_id'] ?? null),
            WorkflowResolverType::GROUP => $this->groupUser($config['group_id'] ?? null),
            default => null,
        };
    }

    protected function resolveOrgValue(array $config, string $key, ?object $profile, string $profileField): mixed
    {
        // Explicit organization IDs are fixed targets (for example IT Infra / IT Division).
        if (array_key_exists($key, $config) && $config[$key] !== null && $config[$key] !== '') {
            return $config[$key];
        }

        // When scope is REQUESTER, resolve the department/division/directorate from
        // the requester's current employee organization. This is deliberately not
        // hard-coded to IT so Finance/HR/Marketing/etc. follow their own hierarchy.
        if (strtoupper((string) ($config['scope'] ?? '')) === 'REQUESTER') {
            return $profile?->{$profileField};
        }

        // Backward-compatible default: if no fixed ID exists, use the requester
        // organization for organization-based resolvers.
        return $profile?->{$profileField};
    }

    protected function reportToUser(?object $profile): ?ScUser
    {
        $reportTo = $profile?->ReportTo;

        if ($reportTo === null || $reportTo === '') {
            return null;
        }

        return ScUser::query()
            ->where('IsActive', true)
            ->whereNull('DeletedDate')
            ->where(function ($query) use ($reportTo) {
                $query->where('UserID', $reportTo)
                    ->orWhere('EmpFormID', $reportTo);
            })
            ->first();
    }

    protected function headOfDepartment(mixed $departmentId): ?ScUser
    {
        if ($departmentId === null || $departmentId === '') {
            return null;
        }

        return $this->headQuery()
            ->where('h.DeptID', $departmentId)
            ->where(function ($query) {
                $query->whereRaw("LOWER(jt.JobTitle) LIKE '%head%department%'");
            })
            ->orderByDesc('h.EffectiveDate')
            ->orderByDesc('h.EmpFormHistID')
            ->first();
    }

    protected function headOfDivision(mixed $divisionId): ?ScUser
    {
        if ($divisionId === null || $divisionId === '') {
            return null;
        }

        return $this->headQuery()
            ->where('h.DivID', $divisionId)
            ->whereRaw("LOWER(jt.JobTitle) LIKE '%head%division%'")
            ->orderByDesc('h.EffectiveDate')
            ->orderByDesc('h.EmpFormHistID')
            ->first();
    }

    protected function directorOfDirectorate(mixed $directorateId): ?ScUser
    {
        if ($directorateId === null || $directorateId === '') {
            return null;
        }

        return $this->headQuery()
            ->where('h.DirID', $directorateId)
            ->where(function ($query) {
                $query->whereIn('jl.JobLevel', ['Director', 'President Director'])
                    ->orWhere(function ($q) {
                        $q->whereRaw("LOWER(jt.JobTitle) LIKE '%director%'")
                            ->whereRaw("LOWER(jt.JobTitle) NOT LIKE '%vice director%'");
                    });
            })
            ->orderByRaw("CASE WHEN jl.JobLevel = 'Director' THEN 1 WHEN jl.JobLevel = 'President Director' THEN 2 ELSE 3 END")
            ->orderByDesc('h.EffectiveDate')
            ->orderByDesc('h.EmpFormHistID')
            ->first();
    }

    protected function headQuery()
    {
        return ScUser::query()
            ->join('tr_empformhist as h', 'h.EmpFormID', '=', 'sc_user.EmpFormID')
            ->join('ms_job_title as jt', 'h.JobTitleID', '=', 'jt.JobTitleID')
            ->leftJoin('ms_job_level as jl', 'h.JobLvlID', '=', 'jl.JobLevelID')
            ->where('h.IsActive', true)
            ->where('sc_user.IsActive', true)
            ->whereNull('sc_user.DeletedDate')
            ->select('sc_user.*');
    }

    protected function activeUser(mixed $userId): ?ScUser
    {
        if ($userId === null || $userId === '') {
            return null;
        }

        return ScUser::query()
            ->whereKey($userId)
            ->where('IsActive', true)
            ->whereNull('DeletedDate')
            ->first();
    }

    protected function groupUser(mixed $groupId): ?ScUser
    {
        if ($groupId === null || $groupId === '') {
            return null;
        }

        $userId = DB::table('wf_group_member')
            ->where('GroupID', $groupId)
            ->where('IsActive', true)
            ->orderByDesc('IsDefault')
            ->orderBy('GroupMemberID')
            ->value('UserID');

        return $this->activeUser($userId);
    }
}
