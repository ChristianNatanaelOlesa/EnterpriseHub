<?php

namespace App\Http\Controllers\Workflow;

use App\Enums\WorkflowResolverType;
use App\Http\Controllers\Controller;
use App\Models\Master\MsDepartment;
use App\Models\Master\MsDirectorate;
use App\Models\Master\MsDivision;
use App\Models\Security\ScUser;
use App\Models\Workflow\WfApprovalRule;
use App\Models\Workflow\WfApprovalStep;
use App\Models\Workflow\WfProcess;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class WorkflowManagementController extends Controller
{
    public function index(Request $request)
    {
        $processes = WfProcess::query()
            ->with(['approvalRules.steps'])
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = trim($request->input('search'));
                $query->where(function ($q) use ($search) {
                    $q->where('ProcessID', 'like', "%{$search}%")
                        ->orWhere('Process', 'like', "%{$search}%")
                        ->orWhere('ProcessDesc', 'like', "%{$search}%");
                });
            })
            ->orderBy('Process')
            ->paginate(15)
            ->withQueryString();

        return view('workflow.management.index', compact('processes'));
    }

    public function createProcess()
    {
        return view('workflow.management.process-form', [
            'process' => new WfProcess([
                'IsActive' => true,
                'EffectiveDate' => now()->toDateString(),
            ]),
            'mode' => 'create',
        ]);
    }

    public function storeProcess(Request $request)
    {
        $data = $request->validate([
            'ProcessID' => ['required', 'string', 'max:50', 'unique:wf_process,ProcessID'],
            'Process' => ['required', 'string', 'max:255'],
            'ProcessDesc' => ['nullable', 'string', 'max:1000'],
            'EffectiveDate' => ['nullable', 'date'],
            'SLADays' => ['nullable', 'integer', 'min:0'],
            'IsActive' => ['required', 'boolean'],
        ]);

        WfProcess::create($data);

        return redirect()
            ->route('workflow.management.index')
            ->with('success', 'Workflow process berhasil ditambahkan.');
    }

    public function editProcess(string $processId)
    {
        $process = WfProcess::findOrFail($processId);

        return view('workflow.management.process-form', [
            'process' => $process,
            'mode' => 'edit',
        ]);
    }

    public function updateProcess(Request $request, string $processId)
    {
        $process = WfProcess::findOrFail($processId);

        $data = $request->validate([
            'ProcessID' => ['required', 'string', 'max:50', Rule::unique('wf_process', 'ProcessID')->ignore($process->ProcessID, 'ProcessID')],
            'Process' => ['required', 'string', 'max:255'],
            'ProcessDesc' => ['nullable', 'string', 'max:1000'],
            'EffectiveDate' => ['nullable', 'date'],
            'SLADays' => ['nullable', 'integer', 'min:0'],
            'IsActive' => ['required', 'boolean'],
        ]);

        if ($data['ProcessID'] !== $process->ProcessID) {
            $process->ProcessID = $data['ProcessID'];
        }

        $process->fill([
            'Process' => $data['Process'],
            'ProcessDesc' => $data['ProcessDesc'] ?? null,
            'EffectiveDate' => $data['EffectiveDate'] ?? null,
            'SLADays' => $data['SLADays'] ?? null,
            'IsActive' => $data['IsActive'],
        ]);
        $process->save();

        return redirect()
            ->route('workflow.management.index')
            ->with('success', 'Workflow process berhasil diupdate.');
    }

    public function destroyProcess(string $processId)
    {
        $process = WfProcess::findOrFail($processId);

        if ($process->approvalRules()->exists()) {
            return back()->with('error', 'Process tidak dapat dihapus karena masih memiliki approval rule.');
        }

        $process->delete();

        return back()->with('success', 'Workflow process berhasil dihapus.');
    }

    public function createRule(string $processId)
    {
        $process = WfProcess::findOrFail($processId);

        return view('workflow.management.rule-form', [
            'process' => $process,
            'rule' => new WfApprovalRule([
                'ConditionType' => 'REQUESTER_SCOPE',
                'Priority' => ((int) $process->approvalRules()->max('Priority')) + 1,
                'RevisionMode' => 'RETURN_TO_REVISION_APPROVER',
                'IsActive' => true,
                'EffectiveDate' => now()->toDateString(),
            ]),
            'mode' => 'create',
        ]);
    }

    public function storeRule(Request $request, string $processId)
    {
        WfProcess::findOrFail($processId);

        $data = $this->validateRule($request);

        $data['ProcessID'] = $processId;

        WfApprovalRule::create($data);

        return redirect()
            ->route('workflow.management.index')
            ->with('success', 'Approval rule berhasil ditambahkan.');
    }

    public function editRule(int $ruleId)
    {
        $rule = WfApprovalRule::with('process')->findOrFail($ruleId);

        return view('workflow.management.rule-form', [
            'process' => $rule->process,
            'rule' => $rule,
            'mode' => 'edit',
        ]);
    }

    public function updateRule(Request $request, int $ruleId)
    {
        $rule = WfApprovalRule::findOrFail($ruleId);

        $data = $this->validateRule($request, $ruleId);

        $rule->fill($data);
        $rule->save();

        return redirect()
            ->route('workflow.management.index')
            ->with('success', 'Approval rule berhasil diupdate.');
    }

    public function destroyRule(int $ruleId)
    {
        $rule = WfApprovalRule::findOrFail($ruleId);

        if ($rule->steps()->exists()) {
            return back()->with('error', 'Rule tidak dapat dihapus karena masih memiliki approval step.');
        }

        $rule->delete();

        return back()->with('success', 'Approval rule berhasil dihapus.');
    }

    public function createStep(int $ruleId)
    {
        $rule = WfApprovalRule::with('process')->findOrFail($ruleId);

        return view('workflow.management.step-form', [
            'rule' => $rule,
            'step' => new WfApprovalStep([
                'StepNo' => ((int) $rule->steps()->max('StepNo')) + 1,
                'ResolverType' => WorkflowResolverType::REQUESTER_REPORT_TO->value,
                'IsMandatory' => true,
                'AllowSelfSkip' => true,
                'IsActive' => true,
            ]),
            'mode' => 'create',
            ...$this->masterOptions(),
        ]);
    }

    public function storeStep(Request $request, int $ruleId)
    {
        $rule = WfApprovalRule::findOrFail($ruleId);

        $data = $this->validateStep($request, $ruleId);

        WfApprovalStep::create([
            ...$data,
            'ApprovalRuleID' => $ruleId,
        ]);

        return redirect()
            ->route('workflow.management.index')
            ->with('success', 'Approval step berhasil ditambahkan.');
    }

    public function editStep(int $stepId)
    {
        $step = WfApprovalStep::with('rule.process')->findOrFail($stepId);

        return view('workflow.management.step-form', [
            'rule' => $step->rule,
            'step' => $step,
            'mode' => 'edit',
            ...$this->masterOptions(),
        ]);
    }

    public function updateStep(Request $request, int $stepId)
    {
        $step = WfApprovalStep::findOrFail($stepId);

        $data = $this->validateStep($request, $step->ApprovalRuleID, $stepId);

        $step->fill($data);
        $step->save();

        return redirect()
            ->route('workflow.management.index')
            ->with('success', 'Approval step berhasil diupdate.');
    }

    public function destroyStep(int $stepId)
    {
        $step = WfApprovalStep::findOrFail($stepId);
        $step->delete();

        return back()->with('success', 'Approval step berhasil dihapus.');
    }

    protected function validateRule(Request $request, ?int $ruleId = null): array
    {
        return $request->validate([
            'RuleCode' => [
                'required', 'string', 'max:100',
                Rule::unique('wf_approval_rule', 'RuleCode')
                    ->where(fn ($q) => $q->where('ProcessID', $request->route('processId') ?? WfApprovalRule::find($ruleId)?->ProcessID))
                    ->ignore($ruleId, 'ApprovalRuleID'),
            ],
            'RuleName' => ['required', 'string', 'max:255'],
            'ConditionType' => ['required', Rule::in(['ANY', 'REQUESTER_SCOPE'])],
            'ConditionValue' => ['nullable', 'string', 'max:100'],
            'Priority' => ['required', 'integer', 'min:1'],
            'RevisionMode' => ['required', Rule::in(['RESTART_FROM_FIRST_APPROVER', 'RETURN_TO_REVISION_APPROVER'])],
            'EffectiveDate' => ['nullable', 'date'],
            'IsActive' => ['required', 'boolean'],
        ]);
    }

    protected function validateStep(Request $request, int $ruleId, ?int $stepId = null): array
    {
        $data = $request->validate([
            'StepNo' => [
                'required', 'integer', 'min:1',
                Rule::unique('wf_approval_step', 'StepNo')
                    ->where(fn ($q) => $q->where('ApprovalRuleID', $ruleId))
                    ->ignore($stepId, 'ApprovalStepID'),
            ],
            'StepCode' => ['required', 'string', 'max:100'],
            'StepName' => ['required', 'string', 'max:255'],
            'ResolverType' => ['required', Rule::in(array_map(fn ($e) => $e->value, WorkflowResolverType::cases()))],
            'ResolverConfig' => ['nullable', 'json'],
            'IsMandatory' => ['required', 'boolean'],
            'AllowSelfSkip' => ['required', 'boolean'],
            'SLADays' => ['nullable', 'integer', 'min:0'],
            'IsActive' => ['required', 'boolean'],
        ]);

        $data['ResolverConfig'] = $data['ResolverConfig']
            ? json_decode($data['ResolverConfig'], true, 512, JSON_THROW_ON_ERROR)
            : [];

        return $data;
    }

    protected function masterOptions(): array
    {
        return [
            'departments' => MsDepartment::query()
                ->where('IsActive', true)
                ->whereNull('DeletedDate')
                ->orderBy('Department')
                ->get(['DeptID', 'Department']),
            'divisions' => MsDivision::query()
                ->where('IsActive', true)
                ->whereNull('DeletedDate')
                ->orderBy('Division')
                ->get(['DivID', 'Division']),
            'directorates' => MsDirectorate::query()
                ->where('IsActive', true)
                ->whereNull('DeletedDate')
                ->orderBy('Directorate')
                ->get(['DirID', 'Directorate']),
            'users' => ScUser::query()
                ->where('IsActive', true)
                ->whereNull('DeletedDate')
                ->orderBy('FullName')
                ->get(['UserID', 'Username', 'FullName']),
        ];
    }
}
