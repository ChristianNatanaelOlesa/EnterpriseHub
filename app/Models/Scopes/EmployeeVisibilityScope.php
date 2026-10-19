<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\DB;

class EmployeeVisibilityScope implements Scope
{
    private static array $contextCache = [];

    public function apply(Builder $builder, Model $model): void
    {
        $user = auth()->user();

        if (!$user) {
            return;
        }

        $userId = (string) ($user->UserID ?? $user->getAuthIdentifier());

        if (!array_key_exists($userId, self::$contextCache)) {
            self::$contextCache[$userId] = $this->buildContext($user);
        }

        $context = self::$contextCache[$userId];

        // Super Administrator is not restricted by employee hierarchy.
        if ($context['unrestricted']) {
            return;
        }

        $table = $model->getTable();

        // Non-admin account without EmpFormID: no transaction rows.
        if (! $context['empFormId']) {
            $builder->whereRaw('1 = 0');
            return;
        }

        // Users with 'Transaction Approver' role can see all pending approvals
        // (WAITING_APPROVAL) across every organization, in addition to their own
        // scoped data. This lets kabag.iti / kadiv.int approve requests from
        // staff in other departments/divisions while still seeing their own org.
        $hasApproverRole = $user->activeRoles()
            ->where('Role', 'Transaction Approver')
            ->exists();

        if ($hasApproverRole) {
            $builder->where(function ($query) use ($table, $context) {
                $query->whereIn($table . '.EmpFormID', $this->allowedEmployeeIdsQuery($context))
                    ->orWhere($table . '.Status', 'WAITING_APPROVAL');
            });
        } else {
            $builder->whereIn(
                $table . '.EmpFormID',
                $this->allowedEmployeeIdsQuery($context)
            );
        }
    }

    private function buildContext($user): array
    {
        $unrestricted = $user->activeRoles()
            ->where('Role', 'Super Administrator')
            ->exists();

        if ($unrestricted) {
            return [
                'unrestricted' => true,
                'empFormId' => null,
                'scopeType' => null,
                'dirId' => null,
                'divId' => null,
                'deptId' => null,
            ];
        }

        $empFormId = trim((string) ($user->EmpFormID ?? ''));

        if ($empFormId === '') {
            return [
                'unrestricted' => false,
                'empFormId' => null,
                'scopeType' => 'staff',
                'dirId' => null,
                'divId' => null,
                'deptId' => null,
            ];
        }

        $profile = DB::table('tr_empformhist as h')
            ->leftJoin(
                'ms_job_title as jt',
                'h.JobTitleID',
                '=',
                'jt.JobTitleID'
            )
            ->leftJoin(
                'ms_job_level as jl',
                'h.JobLvlID',
                '=',
                'jl.JobLevelID'
            )
            ->where('h.EmpFormID', $empFormId)
            ->orderByDesc('h.EffectiveDate')
            ->orderByDesc('h.EmpFormHistID')
            ->select([
                'h.DirID',
                'h.DivID',
                'h.DeptID',
                'jt.JobTitle',
                'jl.JobLevel',
            ])
            ->first();

        if (!$profile) {
            return [
                'unrestricted' => false,
                'empFormId' => $empFormId,
                'scopeType' => 'staff',
                'dirId' => null,
                'divId' => null,
                'deptId' => null,
            ];
        }

        return [
            'unrestricted' => false,
            'empFormId' => $empFormId,
            'scopeType' => $this->resolveScopeType(
                (string) ($profile->JobTitle ?? ''),
                (string) ($profile->JobLevel ?? '')
            ),
            'dirId' => $profile->DirID,
            'divId' => $profile->DivID,
            'deptId' => $profile->DeptID,
        ];
    }

    private function resolveScopeType(
        string $jobTitle,
        string $jobLevel
    ): string {
        $title = strtolower(trim($jobTitle));
        $level = strtolower(trim($jobLevel));

        // Director / President Director.
        if (
            $title === 'director'
            || $title === 'president director'
            || $level === 'director'
            || $level === 'president director'
        ) {
            return 'director';
        }

        // Head of Division.
        if (
            str_contains($title, 'head')
            && str_contains($title, 'division')
        ) {
            return 'division';
        }

        // Head of Department.
        if (
            str_contains($title, 'head')
            && str_contains($title, 'department')
        ) {
            return 'department';
        }

        return 'staff';
    }

    private function allowedEmployeeIdsQuery(array $context)
    {
        $latest = DB::table('tr_empformhist as h')
            ->whereNotExists(function ($query) {
                $query
                    ->selectRaw('1')
                    ->from('tr_empformhist as newer')
                    ->whereColumn(
                        'newer.EmpFormID',
                        'h.EmpFormID'
                    )
                    ->where(function ($q) {
                        $q->whereColumn(
                            'newer.EffectiveDate',
                            '>',
                            'h.EffectiveDate'
                        )->orWhere(function ($q2) {
                            $q2->whereColumn(
                                'newer.EffectiveDate',
                                'h.EffectiveDate'
                            )->whereColumn(
                                'newer.EmpFormHistID',
                                '>',
                                'h.EmpFormHistID'
                            );
                        });
                    });
            });

        switch ($context['scopeType']) {
            case 'director':
                $latest->where('h.DirID', $context['dirId']);
                break;

            case 'division':
                $latest->where('h.DivID', $context['divId']);
                break;

            case 'department':
                $latest->where('h.DeptID', $context['deptId']);
                break;

            default:
                $latest->where(
                    'h.EmpFormID',
                    $context['empFormId']
                );
                break;
        }

        return $latest->select('h.EmpFormID');
    }
}
