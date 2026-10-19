@extends('layouts.app')

@section('title', 'Workflow Management')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0">Workflow Management</h5>
                <small class="text-muted">Process → Approval Rule → Approval Step</small>
            </div>
            @canAdd('workflow.management.index')
            <a href="{{ route('workflow.management.process.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Create Process
            </a>
            @endcanAdd
        </div>

        <div class="card-body">
            <x-alert />

            <form method="GET" action="{{ route('workflow.management.index') }}" class="row g-2 mb-3">
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control"
                        placeholder="Search process ID, name, or description..." value="{{ request('search') }}">
                </div>
                <div class="col-auto">
                    <button class="btn btn-primary"><i class="bi bi-search"></i> Search</button>
                </div>
                @if (request('search'))
                    <div class="col-auto">
                        <a href="{{ route('workflow.management.index') }}" class="btn btn-secondary">Reset</a>
                    </div>
                @endif
            </form>

            @forelse($processes as $process)
                <div class="border rounded mb-4">
                    <div class="p-3 bg-light d-flex flex-wrap gap-2 justify-content-between align-items-center">
                        <div>
                            <div class="fw-semibold">{{ $process->Process }}</div>
                            <div class="small text-muted">
                                <code>{{ $process->ProcessID }}</code>
                                @if ($process->ProcessDesc)
                                    · {{ $process->ProcessDesc }}
                                @endif
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            @if ($process->IsActive)
                                <span class="badge bg-success align-self-center">Active</span>
                            @else
                                <span class="badge bg-secondary align-self-center">Inactive</span>
                            @endif

                            @canEdit('workflow.management.index')
                            <a href="{{ route('workflow.management.process.edit', $process->ProcessID) }}"
                                class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                            @endcanEdit

                            @canAdd('workflow.management.index')
                            <a href="{{ route('workflow.management.rule.create', $process->ProcessID) }}"
                                class="btn btn-sm btn-primary"><i class="bi bi-diagram-3"></i> Add Rule</a>
                            @endcanAdd

                            @canDelete('workflow.management.index')
                            @if ($process->approvalRules->isEmpty())
                                <form method="POST"
                                    action="{{ route('workflow.management.process.destroy', $process->ProcessID) }}"
                                    class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this process?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            @endif
                            @endcanDelete
                        </div>
                    </div>

                    <div class="p-3">
                        @forelse($process->approvalRules as $rule)
                            <div class="border rounded mb-3">
                                <div class="p-2 d-flex flex-wrap gap-2 justify-content-between align-items-center">
                                    <div>
                                        <span class="badge text-bg-dark me-1">{{ $rule->RuleCode }}</span>
                                        <strong>{{ $rule->RuleName }}</strong>
                                        <div class="small text-muted mt-1">
                                            Condition:
                                            {{ $rule->ConditionType === 'ANY' ? 'ANY' : ($rule->ConditionValue ?: '-') }}
                                            · Priority {{ $rule->Priority }}
                                            · Revision: {{ $rule->RevisionMode }}
                                        </div>
                                    </div>
                                    <div class="d-flex gap-1">
                                        @if ($rule->IsActive)
                                            <span class="badge bg-success align-self-center">Active</span>
                                        @else
                                            <span class="badge bg-secondary align-self-center">Inactive</span>
                                        @endif

                                        @canEdit('workflow.management.index')
                                        <a href="{{ route('workflow.management.rule.edit', $rule->ApprovalRuleID) }}"
                                            class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                                        @endcanEdit

                                        @canAdd('workflow.management.index')
                                        <a href="{{ route('workflow.management.step.create', $rule->ApprovalRuleID) }}"
                                            class="btn btn-sm btn-outline-primary">Add Step</a>
                                        @endcanAdd

                                        @canDelete('workflow.management.index')
                                        @if ($rule->steps->isEmpty())
                                            <form method="POST"
                                                action="{{ route('workflow.management.rule.destroy', $rule->ApprovalRuleID) }}"
                                                class="d-inline">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Delete this rule?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                        @endcanDelete
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered mb-0 align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th width="70">Step</th>
                                                <th>Code</th>
                                                <th>Name</th>
                                                <th>Resolver</th>
                                                <th>Config</th>
                                                <th>Status</th>
                                                <th width="120">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($rule->steps as $step)
                                                <tr>
                                                    <td class="text-center">{{ $step->StepNo }}</td>
                                                    <td><code>{{ $step->StepCode }}</code></td>
                                                    <td>{{ $step->StepName }}</td>
                                                    <td><span class="badge text-bg-info">{{ $step->ResolverType }}</span>
                                                    </td>
                                                    <td class="small">
                                                        @if (empty($step->ResolverConfig))
                                                            -
                                                        @else
                                                            <code>{{ json_encode($step->ResolverConfig, JSON_UNESCAPED_SLASHES) }}</code>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($step->IsActive)
                                                            <span class="badge bg-success">Active</span>
                                                        @else
                                                            <span class="badge bg-secondary">Inactive</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-nowrap">
                                                        @canEdit('workflow.management.index')
                                                        <a href="{{ route('workflow.management.step.edit', $step->ApprovalStepID) }}"
                                                            class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                                                        @endcanEdit
                                                        @canDelete('workflow.management.index')
                                                        <form method="POST"
                                                            action="{{ route('workflow.management.step.destroy', $step->ApprovalStepID) }}"
                                                            class="d-inline">
                                                            @csrf @method('DELETE')
                                                            <button class="btn btn-sm btn-danger"
                                                                onclick="return confirm('Delete this step?')">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </form>
                                                        @endcanDelete
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7" class="text-center text-muted">No approval steps
                                                        configured.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-muted py-3">No approval rules configured.</div>
                        @endforelse
                    </div>
                </div>
            @empty
                <div class="text-center text-muted py-5">No workflow process found.</div>
            @endforelse

            {{ $processes->links() }}
        </div>
    </div>
@endsection
