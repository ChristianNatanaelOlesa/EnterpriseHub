<?php

namespace App\Services\Workflow;

use App\Enums\WorkflowAction;
use App\Enums\WorkflowStatus;
use App\Models\Security\ScUser;
use App\Models\Workflow\WfApprovalRule;
use App\Models\Workflow\WfApprovalStep;
use App\Models\Workflow\WfInstance;
use App\Models\Workflow\WfInstanceRevision;
use App\Models\Workflow\WfInstanceStep;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Scopes\EmployeeVisibilityScope;
use Illuminate\Support\Str;

class WorkflowEngine
{
    public function __construct(
        protected WorkflowResolver $resolver
    ) {

    }

    /**

     * Start a workflow, or resubmit an existing instance in REVISION_REQUIRED.

     */

    public function requestApproval(
        string $processId,
        string $module,
        string $transactionId,
        ?ScUser $requester = null,
        ?string $requesterEmpFormId = null,
        ?string $targetEmpFormId = null,
        ?Model $transaction = null,
        ?string $statusField = 'Status',
    ): WfInstance {

        $requester ??= auth()->user();

        if (!$requester instanceof ScUser) {

            throw new WorkflowException('Workflow membutuhkan user requester yang valid.');

        }

        $requesterEmpFormId ??= $requester->EmpFormID;

        return DB::transaction(function () use (
            $processId,
            $module,
            $transactionId,
            $requester,
            $requesterEmpFormId,
            $targetEmpFormId,
            $transaction,
            $statusField,
        ) {

            $existing = WfInstance::query()

                ->where('Module', $module)

                ->where('TransactionID', $transactionId)

                ->whereNotIn('Status', [

                    WorkflowStatus::REJECTED->value,

                    WorkflowStatus::CANCELLED->value,

                    WorkflowStatus::APPROVED->value,

                    WorkflowStatus::COMPLETED->value,

                ])

                ->latest('InputDate')

                ->lockForUpdate()

                ->first();

            if ($existing) {

                if ($existing->Status !== WorkflowStatus::REVISION_REQUIRED->value) {

                    throw new WorkflowException('Transaction ini sudah memiliki workflow yang sedang berjalan.');

                }

                $this->assertRevisionResubmissionAllowed($existing, (int) $requester->UserID);

                return $this->resubmit(
                    $existing,
                    $requester,
                    $transaction,
                    $statusField,
                );

            }

            $process = DB::table('wf_process')

                ->where('ProcessID', $processId)

                ->where('IsActive', true)

                ->first();

            if (!$process) {

                throw new WorkflowException("Workflow process [{$processId}] tidak ditemukan atau tidak aktif.");

            }

            $requesterProfile = $this->resolver->profileByEmpFormId($requesterEmpFormId);

            $targetProfile = $this->resolver->profileByEmpFormId($targetEmpFormId);

            $requesterScope = $this->resolver->requesterScope($requesterProfile);

            $rule = $this->findRule($processId, $requesterScope);

            if (!$rule) {

                throw new WorkflowException(
                    "Approval rule untuk process [{$processId}] dan requester scope [{$requesterScope}] tidak ditemukan."
                );

            }

            $instance = new WfInstance();

            $instance->fill([

                'ProcessID' => $processId,

                'ApprovalRuleID' => $rule->ApprovalRuleID,

                'Module' => $module,

                'TransactionID' => $transactionId,

                'RequesterUserID' => $requester->UserID,

                'RequesterEmpFormID' => $requesterEmpFormId,

                'TargetEmpFormID' => $targetEmpFormId,

                'Status' => WorkflowStatus::WAITING_APPROVAL->value,

                'RevisionNo' => 0,

                'StartedAt' => now(),

            ]);

            $instance->save();

            $steps = $rule->steps()->where('IsActive', true)->get();

            if ($steps->isEmpty()) {

                throw new WorkflowException("Approval rule [{$rule->RuleCode}] tidak memiliki approval step aktif.");

            }

            $this->createRuntimeSteps(
                $instance,
                $steps,
                0,
                [

                    'requesterProfile' => $requesterProfile,

                    'targetProfile' => $targetProfile,

                ],
            );

            $this->activateNextStep($instance);

            $instance->refresh();

            $this->syncTransactionStatus($transaction, $statusField, $instance->Status);

            return $instance->fresh(['steps', 'revisions']);

        });

    }

    public function approve(
        string $instanceId,
        ?string $comment = null,
        ?ScUser $actor = null,
    ): WfInstance {

        return $this->completeCurrentStep($instanceId, WorkflowAction::APPROVE, $comment, $actor);

    }

    public function reject(
        string $instanceId,
        string $comment,
        ?ScUser $actor = null,
    ): WfInstance {

        return $this->completeCurrentStep($instanceId, WorkflowAction::REJECT, $comment, $actor);

    }

    public function requestRevision(
        string $instanceId,
        string $comment,
        ?ScUser $actor = null,
        string $revisionTargetType = 'REQUESTER',
        ?int $revisionTargetUserId = null,
    ): WfInstance {

        if (trim($comment) === '') {

            throw new WorkflowException('Request Revision wajib memiliki alasan / comment.');

        }

        $actor ??= auth()->user();

        if (!$actor instanceof ScUser) {

            throw new WorkflowException('Workflow membutuhkan approver yang valid.');

        }

        return DB::transaction(function () use (
            $instanceId,
            $comment,
            $actor,
            $revisionTargetType,
            $revisionTargetUserId,
        ) {

            $instance = WfInstance::query()

                ->with('rule')

                ->whereKey($instanceId)

                ->lockForUpdate()

                ->firstOrFail();

            $step = $this->currentStep($instance);

            $this->assertCanAct($instance, $step, $actor);

            $targetUserId = $revisionTargetUserId;

            if ($revisionTargetType === 'REQUESTER') {

                $targetUserId = (int) $instance->RequesterUserID;

            }

            $revisionNo = ((int) $instance->RevisionNo) + 1;

            WfInstanceRevision::create([

                'WorkflowInstanceID' => $instance->WorkflowInstanceID,

                'RevisionNo' => $revisionNo,

                'RequestedByUserID' => $actor->UserID,

                'RequestedAt' => now(),

                'RevisionTargetType' => $revisionTargetType,

                'RevisionTargetUserID' => $targetUserId,

                'RevisionStepNo' => $step->StepNo,

                'Reason' => $comment,

            ]);

            $step->update([

                'Status' => 'REVISION_REQUESTED',

                'Action' => WorkflowAction::REQUEST_REVISION->value,

                'Comments' => $comment,

                'CompletedAt' => now(),

            ]);

            $instance->update([

                'Status' => WorkflowStatus::REVISION_REQUIRED->value,

                'RevisionNo' => $revisionNo,

                'ModifUser' => $actor->Username,

                'ModifDate' => now(),

            ]);

            // Keep the business transaction status in sync with the workflow.

            // Without this, the requester would still see WAITING_APPROVAL

            // even after an approver requested a revision.

            $this->syncWorkflowTransactionStatus($instance);

            return $instance->fresh(['steps', 'revisions']);

        });

    }

    protected function completeCurrentStep(
        string $instanceId,
        WorkflowAction $action,
        ?string $comment,
        ?ScUser $actor,
    ): WfInstance {

        $actor ??= auth()->user();

        if (!$actor instanceof ScUser) {

            throw new WorkflowException('Workflow membutuhkan approver yang valid.');

        }

        if ($action === WorkflowAction::REJECT && trim((string) $comment) === '') {

            throw new WorkflowException('Reject wajib memiliki alasan / comment.');

        }

        return DB::transaction(function () use ($instanceId, $action, $comment, $actor) {

            $instance = WfInstance::query()

                ->whereKey($instanceId)

                ->lockForUpdate()

                ->firstOrFail();

            $step = $this->currentStep($instance);

            $this->assertCanAct($instance, $step, $actor);

            $step->update([

                'Status' => $action === WorkflowAction::APPROVE ? 'APPROVED' : 'REJECTED',

                'Action' => $action->value,

                'Comments' => $comment,

                'CompletedAt' => now(),

            ]);

            if ($action === WorkflowAction::REJECT) {

                $instance->update([

                    'Status' => WorkflowStatus::REJECTED->value,

                    'CurrentStepNo' => $step->StepNo,

                    'CompletedAt' => now(),

                ]);

                $this->syncWorkflowTransactionStatus($instance);

                return $instance->fresh(['steps', 'revisions']);

            }

            $this->activateNextStep($instance);

            $instance->refresh();

            $this->syncWorkflowTransactionStatus($instance);

            return $instance->fresh(['steps', 'revisions']);

        });

    }

    protected function findRule(string $processId, string $requesterScope): ?WfApprovalRule
    {

        $today = now()->toDateString();

        $rules = WfApprovalRule::query()

            ->where('ProcessID', $processId)

            ->where('IsActive', true)

            ->where(function ($query) use ($today) {

                $query->whereNull('EffectiveDate')

                    ->orWhere('EffectiveDate', '<=', $today);

            })

            ->orderBy('Priority')

            ->orderByDesc('EffectiveDate')

            ->get();

        return $rules->first(function (WfApprovalRule $rule) use ($requesterScope) {

            if ($rule->ConditionType === 'ANY') {

                return true;

            }

            if ($rule->ConditionType === 'REQUESTER_SCOPE') {

                return strtoupper((string) $rule->ConditionValue) === strtoupper($requesterScope);

            }

            return false;

        });

    }

    protected function createRuntimeSteps(
        WfInstance $instance,
        $steps,
        int $revisionNo,
        array $context,
        ?int $fromStepNo = null,
    ): void {

        foreach ($steps as $step) {

            if ($fromStepNo !== null && $step->StepNo < $fromStepNo) {

                continue;

            }

            $approver = $this->resolver->resolve($step, $context);

            $isSelf = $approver && (int) $approver->UserID === (int) $instance->RequesterUserID;

            $runtime = new WfInstanceStep();

            $runtime->fill([

                'WorkflowInstanceID' => $instance->WorkflowInstanceID,

                'ApprovalStepID' => $step->ApprovalStepID,

                'RevisionNo' => $revisionNo,

                'StepNo' => $step->StepNo,

                'StepCode' => $step->StepCode,

                'StepName' => $step->StepName,

                'ResolverType' => $step->ResolverType,

                'ResolverConfig' => $step->ResolverConfig,

                'ApproverUserID' => $approver?->UserID,

                'ApproverEmpFormID' => $approver?->EmpFormID,

                'Status' => $isSelf && $step->AllowSelfSkip ? 'SKIPPED' : 'PENDING',

                'IsSkipped' => $isSelf && $step->AllowSelfSkip,

                'SkipReason' => $isSelf && $step->AllowSelfSkip ? 'SELF_APPROVAL' : null,

                'RevisionNo' => $revisionNo,

            ]);

            $runtime->save();

            if (!$approver && $step->IsMandatory) {

                throw new WorkflowException(
                    "Approver tidak ditemukan untuk step [{$step->StepCode}] pada workflow [{$instance->WorkflowInstanceID}]."
                );

            }

        }

    }

    protected function activateNextStep(WfInstance $instance): void
    {

        $instance->refresh();

        $revisionNo = (int) $instance->RevisionNo;

        $step = WfInstanceStep::query()

            ->where('WorkflowInstanceID', $instance->WorkflowInstanceID)

            ->where('RevisionNo', $revisionNo)

            ->where('Status', 'PENDING')

            ->orderBy('StepNo')

            ->first();

        if (!$step) {

            $instance->update([

                'Status' => WorkflowStatus::APPROVED->value,

                'CurrentStepNo' => null,

                'CompletedAt' => now(),

            ]);

            return;

        }

        $step->update([

            'Status' => 'ACTIVE',

            'StartedAt' => now(),

            'DueDate' => $step->DueDate ?? $this->calculateDueDate($step),

        ]);

        $instance->update([

            'Status' => WorkflowStatus::WAITING_APPROVAL->value,

            'CurrentStepNo' => $step->StepNo,

            'CompletedAt' => null,

        ]);

    }

    protected function calculateDueDate(WfInstanceStep $step): ?\Carbon\Carbon
    {

        $days = $step->approvalStep?->SLADays;

        return $days ? now()->addDays((int) $days) : null;

    }

    protected function currentStep(WfInstance $instance): WfInstanceStep
    {

        $step = WfInstanceStep::query()

            ->where('WorkflowInstanceID', $instance->WorkflowInstanceID)

            ->where('RevisionNo', $instance->RevisionNo)

            ->where('Status', 'ACTIVE')

            ->orderBy('StepNo')

            ->first();

        if (!$step) {

            throw new WorkflowException('Workflow tidak memiliki approval step aktif.');

        }

        return $step;

    }

    protected function assertCanAct(WfInstance $instance, WfInstanceStep $step, ScUser $actor): void
    {

        if ((int) $step->ApproverUserID === (int) $actor->UserID) {

            return;

        }

        $isSuperAdmin = method_exists($actor, 'activeRoles')

            && $actor->activeRoles()->where('Role', 'Super Administrator')->exists();

        if ($isSuperAdmin) {

            return;

        }

        throw new WorkflowException('User tidak memiliki hak untuk melakukan action pada approval step ini.');

    }

    protected function assertRevisionResubmissionAllowed(WfInstance $instance, int $userId): void
    {

        $revision = $instance->revisions()

            ->whereNull('ResolvedAt')

            ->latest('RevisionNo')

            ->first();

        if (!$revision) {

            throw new WorkflowException('Workflow revision tidak ditemukan.');

        }

        $targetUserId = $revision->RevisionTargetUserID ?: $instance->RequesterUserID;

        if ((int) $targetUserId !== $userId) {

            throw new WorkflowException('User ini bukan target dari Request Revision.');

        }

    }

    protected function resubmit(
        WfInstance $instance,
        ScUser $requester,
        ?Model $transaction,
        string $statusField,
    ): WfInstance {

        $rule = $instance->rule()->with('steps')->firstOrFail();

        $revision = $instance->revisions()->whereNull('ResolvedAt')->latest('RevisionNo')->firstOrFail();

        $newRevisionNo = (int) $instance->RevisionNo;

        $requesterProfile = $this->resolver->profileByEmpFormId($instance->RequesterEmpFormID);

        $targetProfile = $this->resolver->profileByEmpFormId($instance->TargetEmpFormID);

        $context = [

            'requesterProfile' => $requesterProfile,

            'targetProfile' => $targetProfile,

        ];

        $fromStepNo = null;

        if ($rule->RevisionMode === 'RETURN_TO_REVISION_APPROVER') {

            $fromStepNo = $revision->RevisionStepNo;

        }

        $this->createRuntimeSteps(
            $instance,
            $rule->steps()->where('IsActive', true)->get(),
            $newRevisionNo,
            $context,
            $fromStepNo,
        );

        $revision->update([

            'ResolvedAt' => now(),

            'ModifUser' => $requester->Username,

            'ModifDate' => now(),

        ]);

        $instance->update([

            'Status' => WorkflowStatus::WAITING_APPROVAL->value,

            'CurrentStepNo' => null,

            'CompletedAt' => null,

            'ModifUser' => $requester->Username,

            'ModifDate' => now(),

        ]);

        $this->activateNextStep($instance);

        $instance->refresh();

        $this->syncTransactionStatus($transaction, $statusField, $instance->Status);

        return $instance->fresh(['steps', 'revisions']);

    }

    protected function syncWorkflowTransactionStatus(WfInstance $instance): void
    {

        $map = [

            'EMPLOYEE_EQUIPMENT' => [\App\Models\EForm\TrEmpEquip::class, 'EmpEquipID'],

            'EMPLOYEE_SOFTWARE' => [\App\Models\EForm\TrEmpSoftware::class, 'EmpSoftwareID'],

            'EMPLOYEE_IT_AREA' => [\App\Models\EForm\TrEmpITArea::class, 'EmpITAreaID'],

            'EMPLOYEE_SHARING_FOLDER' => [\App\Models\EForm\TrEmpSharingFolder::class, 'EmpSharingFolderID'],

            'EMPLOYEE_NETWORK' => [\App\Models\EForm\TrEmpNetwork::class, 'EmpNetworkID'],

            'EMPLOYEE_INFRA' => [\App\Models\EForm\TrEmpInfra::class, 'EmpInfraID'],

            'EMPLOYEE_EMAIL' => [\App\Models\EForm\TrEmpEmail::class, 'EmpEmailID'],

            'EMPLOYEE_APPLICATION_EXTERNAL' => [\App\Models\EForm\TrEmpApp::class, 'EmpAppID'],

            'EMPLOYEE_APPLICATION_INTERNAL' => [\App\Models\EForm\TrEmpApp::class, 'EmpAppID'],

        ];

        if (!isset($map[$instance->Module])) {

            return;

        }

        [$class, $key] = $map[$instance->Module];

        if (!class_exists($class)) {

            return;

        }

        $transaction = $class::query()
            ->withoutGlobalScope(EmployeeVisibilityScope::class)
            ->where($key, $instance->TransactionID)
            ->first();

        if (!$transaction) {

            return;

        }

        $this->syncTransactionStatus($transaction, 'Status', $instance->Status);

    }

    protected function syncTransactionStatus(?Model $transaction, string $statusField, string $status): void
    {

        if (!$transaction || !$statusField || !array_key_exists($statusField, $transaction->getAttributes())) {

            return;

        }

        $transaction->setAttribute($statusField, $status);

        $transaction->save();

    }

    public function cancelByRequester(
        string $instanceId,
        ScUser $requester
    ): WfInstance {
        return DB::transaction(function () use ($instanceId, $requester) {
            $instance = WfInstance::query()
                ->whereKey($instanceId)
                ->lockForUpdate()
                ->firstOrFail();

            if (strtoupper((string) $instance->Module) !== 'EMPLOYEE_EMAIL') {
                throw new WorkflowException(
                    'Pembatalan ini hanya berlaku untuk Employee Email.'
                );
            }

            if ((int) $instance->RequesterUserID !== (int) $requester->UserID) {
                throw new WorkflowException(
                    'Anda tidak memiliki akses untuk membatalkan pengajuan ini.'
                );
            }

            if ($instance->Status !== WorkflowStatus::WAITING_APPROVAL->value) {
                throw new WorkflowException(
                    'Pengajuan tidak dapat dibatalkan karena status workflow sudah berubah.'
                );
            }

            // Cancel hanya diperbolehkan sebelum approver melakukan action.
            // Periksa seluruh revisi agar action sebelumnya tidak terlewat.
            $hasApproverAction = WfInstanceStep::query()
                ->where('WorkflowInstanceID', $instance->WorkflowInstanceID)
                ->where(function ($query) {
                    $query->whereIn('Status', [
                        'APPROVED',
                        'REJECTED',
                        'REVISION_REQUESTED',
                    ])->orWhere(function ($actionQuery) {
                        $actionQuery
                            ->whereNotNull('Action')
                            ->whereNotIn('Action', ['', '-']);
                    });
                })
                ->exists();

            if ($hasApproverAction) {
                throw new WorkflowException(
                    'Cancel tidak diperbolehkan karena Approver 1 atau approver berikutnya sudah melakukan action.'
                );
            }

            $transaction = \App\Models\EForm\TrEmpEmail::query()
                ->withoutGlobalScope(EmployeeVisibilityScope::class)
                ->where('EmpEmailID', $instance->TransactionID)
                ->lockForUpdate()
                ->first();

            if (!$transaction) {
                throw new WorkflowException(
                    'Data Employee Email tidak ditemukan.'
                );
            }

            if (
                strtoupper((string) $transaction->Status)
                !== WorkflowStatus::WAITING_APPROVAL->value
            ) {
                throw new WorkflowException(
                    'Status transaksi sudah berubah dan tidak dapat dibatalkan.'
                );
            }

            $instance->update([
                'Status' => WorkflowStatus::CANCELLED->value,
                'CompletedAt' => now(),
                'ModifUser' => $requester->Username,
                'ModifDate' => now(),
            ]);

            // Tandai step yang belum dijalankan sebagai CANCELLED.
            WfInstanceStep::query()
                ->where('WorkflowInstanceID', $instance->WorkflowInstanceID)
                ->whereIn('Status', ['ACTIVE', 'PENDING'])
                ->update([
                    'Status' => 'CANCELLED',
                ]);

            // Sinkronkan status transaksi berdasarkan mapping engine.
            $this->syncWorkflowTransactionStatus($instance);

            return $instance->fresh(['steps', 'revisions']);
        });
    }

}
