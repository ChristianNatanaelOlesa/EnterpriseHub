@extends('layouts.app')

@section('title', $mode === 'create' ? 'Create Approval Step' : 'Edit Approval Step')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">{{ $mode === 'create' ? 'Create Approval Step' : 'Edit Approval Step' }}</h5>
        <small class="text-muted">
            {{ $rule->process->ProcessID }} / {{ $rule->RuleCode }} — {{ $rule->RuleName }}
        </small>
    </div>
    <div class="card-body">
        <x-alert />

        <form method="POST"
              action="{{ $mode === 'create'
                    ? route('workflow.management.step.store', $rule->ApprovalRuleID)
                    : route('workflow.management.step.update', $step->ApprovalStepID) }}">
            @csrf
            @if($mode === 'edit') @method('PUT') @endif

            <div class="row g-3">
                <div class="col-md-2">
                    <label class="form-label">Step No <span class="text-danger">*</span></label>
                    <input type="number" min="1" name="StepNo" class="form-control"
                           value="{{ old('StepNo', $step->StepNo) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Step Code <span class="text-danger">*</span></label>
                    <input type="text" name="StepCode" class="form-control"
                           value="{{ old('StepCode', $step->StepCode) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Step Name <span class="text-danger">*</span></label>
                    <input type="text" name="StepName" class="form-control"
                           value="{{ old('StepName', $step->StepName) }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Resolver Type <span class="text-danger">*</span></label>
                    <select name="ResolverType" id="resolverType" class="form-select">
                        @foreach(\App\Enums\WorkflowResolverType::cases() as $resolver)
                            <option value="{{ $resolver->value }}"
                                @selected(old('ResolverType', $step->ResolverType) === $resolver->value)>
                                {{ $resolver->value }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Resolver Config (JSON)</label>
                    <textarea name="ResolverConfig" id="resolverConfig" class="form-control font-monospace"
                              rows="3" placeholder='{"department_id":39}'>{{ old('ResolverConfig', empty($step->ResolverConfig) ? '' : json_encode($step->ResolverConfig, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)) }}</textarea>
                    <div class="form-text">
                        Contoh: <code>{"department_id":39}</code>,
                        <code>{"division_id":20}</code>,
                        <code>{"directorate_id":1}</code>,
                        <code>{"user_id":123}</code>,
                        <code>{"group_id":1}</code>.
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Department helper</label>
                    <select class="form-select" data-config-key="department_id">
                        <option value="">-- Select Department --</option>
                        @foreach($departments as $item)
                            <option value="{{ $item->DeptID }}">
                                {{ $item->DeptID }} - {{ $item->Department }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Division helper</label>
                    <select class="form-select" data-config-key="division_id">
                        <option value="">-- Select Division --</option>
                        @foreach($divisions as $item)
                            <option value="{{ $item->DivID }}">
                                {{ $item->DivID }} - {{ $item->Division }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Directorate helper</label>
                    <select class="form-select" data-config-key="directorate_id">
                        <option value="">-- Select Directorate --</option>
                        @foreach($directorates as $item)
                            <option value="{{ $item->DirID }}">
                                {{ $item->DirID }} - {{ $item->Directorate }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Fixed User helper</label>
                    <select class="form-select" data-config-key="user_id">
                        <option value="">-- Select User --</option>
                        @foreach($users as $item)
                            <option value="{{ $item->UserID }}">
                                {{ $item->Username }} - {{ $item->FullName }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">SLA Days</label>
                    <input type="number" min="0" name="SLADays" class="form-control"
                           value="{{ old('SLADays', $step->SLADays) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="IsActive" class="form-select">
                        <option value="1" @selected(old('IsActive', $step->IsActive ? 1 : 0) == 1)>Active</option>
                        <option value="0" @selected(old('IsActive', $step->IsActive ? 1 : 0) == 0)>Inactive</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Mandatory</label>
                    <select name="IsMandatory" class="form-select">
                        <option value="1" @selected(old('IsMandatory', $step->IsMandatory ? 1 : 0) == 1)>Yes</option>
                        <option value="0" @selected(old('IsMandatory', $step->IsMandatory ? 1 : 0) == 0)>No</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Allow Self Skip</label>
                    <select name="AllowSelfSkip" class="form-select">
                        <option value="1" @selected(old('AllowSelfSkip', $step->AllowSelfSkip ? 1 : 0) == 1)>Yes</option>
                        <option value="0" @selected(old('AllowSelfSkip', $step->AllowSelfSkip ? 1 : 0) == 0)>No</option>
                    </select>
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
    const configBox = document.getElementById('resolverConfig');

    function readConfig() {
        try {
            return JSON.parse(configBox.value || '{}');
        } catch (e) {
            return {};
        }
    }

    function writeConfig(key, value) {
        const config = readConfig();
        if (value === '') {
            delete config[key];
        } else {
            config[key] = /^\d+$/.test(value) ? Number(value) : value;
        }
        configBox.value = JSON.stringify(config, null, 2);
    }

    document.querySelectorAll('[data-config-key]').forEach(function (select) {
        const key = select.dataset.configKey;
        const current = readConfig()[key];
        if (current !== undefined && current !== null) {
            select.value = String(current);
        }
        select.addEventListener('change', function () {
            writeConfig(key, this.value);
        });
    });
});
</script>
@endpush
@endsection
