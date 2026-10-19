@extends('layouts.app')

@section('title', $mode === 'create' ? 'Create Workflow Process' : 'Edit Workflow Process')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">{{ $mode === 'create' ? 'Create Workflow Process' : 'Edit Workflow Process' }}</h5>
    </div>
    <div class="card-body">
        <x-alert />

        <form method="POST"
              action="{{ $mode === 'create'
                    ? route('workflow.management.process.store')
                    : route('workflow.management.process.update', $process->ProcessID) }}">
            @csrf
            @if($mode === 'edit') @method('PUT') @endif

            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Process ID <span class="text-danger">*</span></label>
                    <input type="text" name="ProcessID" class="form-control"
                           value="{{ old('ProcessID', $process->ProcessID) }}"
                           {{ $mode === 'edit' ? 'readonly' : '' }} required>
                </div>
                <div class="col-md-8">
                    <label class="form-label">Process Name <span class="text-danger">*</span></label>
                    <input type="text" name="Process" class="form-control"
                           value="{{ old('Process', $process->Process) }}" required>
                </div>
                <div class="col-md-8">
                    <label class="form-label">Description</label>
                    <textarea name="ProcessDesc" class="form-control" rows="3">{{ old('ProcessDesc', $process->ProcessDesc) }}</textarea>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Effective Date</label>
                    <input type="date" name="EffectiveDate" class="form-control"
                           value="{{ old('EffectiveDate', optional($process->EffectiveDate)->format('Y-m-d')) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">SLA Days</label>
                    <input type="number" min="0" name="SLADays" class="form-control"
                           value="{{ old('SLADays', $process->SLADays) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <select name="IsActive" class="form-select">
                        <option value="1" @selected(old('IsActive', $process->IsActive ? 1 : 0) == 1)>Active</option>
                        <option value="0" @selected(old('IsActive', $process->IsActive ? 1 : 0) == 0)>Inactive</option>
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
@endsection
