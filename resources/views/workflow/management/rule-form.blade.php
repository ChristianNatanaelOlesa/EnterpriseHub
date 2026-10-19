@extends('layouts.app')

@section('title', $mode === 'create' ? 'Create Approval Rule' : 'Edit Approval Rule')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">{{ $mode === 'create' ? 'Create Approval Rule' : 'Edit Approval Rule' }}</h5>
        <small class="text-muted">{{ $process->ProcessID }} — {{ $process->Process }}</small>
    </div>
    <div class="card-body">
        <x-alert />

        <form method="POST"
              action="{{ $mode === 'create'
                    ? route('workflow.management.rule.store', $process->ProcessID)
                    : route('workflow.management.rule.update', $rule->ApprovalRuleID) }}">
            @csrf
            @if($mode === 'edit') @method('PUT') @endif

            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Rule Code <span class="text-danger">*</span></label>
                    <input type="text" name="RuleCode" class="form-control"
                           value="{{ old('RuleCode', $rule->RuleCode) }}" required>
                </div>
                <div class="col-md-8">
                    <label class="form-label">Rule Name <span class="text-danger">*</span></label>
                    <input type="text" name="RuleName" class="form-control"
                           value="{{ old('RuleName', $rule->RuleName) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Condition Type</label>
                    <select name="ConditionType" id="conditionType" class="form-select">
                        <option value="REQUESTER_SCOPE" @selected(old('ConditionType', $rule->ConditionType) === 'REQUESTER_SCOPE')>Requester Scope</option>
                        <option value="ANY" @selected(old('ConditionType', $rule->ConditionType) === 'ANY')>ANY</option>
                    </select>
                </div>
                <div class="col-md-4" id="conditionValueWrap">
                    <label class="form-label">Condition Value</label>
                    <select name="ConditionValue" class="form-select">
                        @foreach(['STAFF','HEAD_DEPARTMENT','HEAD_DIVISION','DIRECTOR'] as $scope)
                            <option value="{{ $scope }}" @selected(old('ConditionValue', $rule->ConditionValue) === $scope)>{{ $scope }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Priority <span class="text-danger">*</span></label>
                    <input type="number" min="1" name="Priority" class="form-control"
                           value="{{ old('Priority', $rule->Priority ?? 1) }}" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Status</label>
                    <select name="IsActive" class="form-select">
                        <option value="1" @selected(old('IsActive', $rule->IsActive ? 1 : 0) == 1)>Active</option>
                        <option value="0" @selected(old('IsActive', $rule->IsActive ? 1 : 0) == 0)>Inactive</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Revision Mode <span class="text-danger">*</span></label>
                    <select name="RevisionMode" class="form-select">
                        <option value="RETURN_TO_REVISION_APPROVER" @selected(old('RevisionMode', $rule->RevisionMode) === 'RETURN_TO_REVISION_APPROVER')>
                            Return to Revision Approver
                        </option>
                        <option value="RESTART_FROM_FIRST_APPROVER" @selected(old('RevisionMode', $rule->RevisionMode) === 'RESTART_FROM_FIRST_APPROVER')>
                            Restart From First Approver
                        </option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Effective Date</label>
                    <input type="date" name="EffectiveDate" class="form-control"
                           value="{{ old('EffectiveDate', optional($rule->EffectiveDate)->format('Y-m-d')) }}">
                </div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <button class="btn btn-primary"><i class="bi bi-check-lg"></i> Save</button>
                <a href="{{ route('workflow.management.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const type = document.getElementById('conditionType');
    const wrap = document.getElementById('conditionValueWrap');
    function toggle() {
        wrap.style.display = type.value === 'ANY' ? 'none' : '';
    }
    type.addEventListener('change', toggle);
    toggle();
});
</script>
@endpush
@endsection
