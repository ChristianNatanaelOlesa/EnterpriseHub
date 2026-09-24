@extends('layouts.app')

@section('title', 'Create Code Of Conduct')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h4 class="mb-1">Create Code Of Conduct</h4>
        <div class="text-muted small">Add Code Of Conduct master data</div>
    </div>

    <a href="{{ route('master.coc.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Back
    </a>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<form
    method="POST"
    action="{{ route('master.coc.store') }}"
    enctype="multipart/form-data"
>
    @csrf

    <div class="card">
        <div class="card-header">
            <strong>FORM : CODE OF CONDUCT</strong>
        </div>

        <div class="card-body">
            <div class="row">

                <div class="col-md-6 mb-3">
                    <label class="form-label">Coc ID</label>
                    <input
                        type="text"
                        class="form-control readonly-field"
                        value="AUTO"
                        readonly
                    >
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">
                        Name <span class="text-danger">*</span>
                    </label>
                    <input
                        type="text"
                        name="Name"
                        class="form-control @error('Name') is-invalid @enderror"
                        value="{{ old('Name') }}"
                        maxlength="200"
                        required
                    >
                    @error('Name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label">
                        Description <span class="text-danger">*</span>
                    </label>
                    <textarea
                        name="Description"
                        rows="3"
                        maxlength="1000"
                        class="form-control @error('Description') is-invalid @enderror"
                        required
                    >{{ old('Description') }}</textarea>
                    @error('Description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label">
                        Contents <span class="text-danger">*</span>
                    </label>
                    <textarea
                        name="Contents"
                        rows="10"
                        class="form-control @error('Contents') is-invalid @enderror"
                        required
                    >{{ old('Contents') }}</textarea>
                    @error('Contents')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label">File <span class="text-danger">*</span></label>
                    <input
                        type="file"
                        name="File"
                        class="form-control @error('File') is-invalid @enderror"
                        required
                        accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt"
                    >
                    <div class="form-text">
                        Maximum 10 MB. PDF, Word, Excel, PowerPoint, or TXT.
                    </div>
                    @error('File')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2 mt-3">
        <a href="{{ route('master.coc.index') }}" class="btn btn-secondary">
            Cancel
        </a>

        <button type="submit" class="btn btn-primary">
            <i class="bi bi-save me-1"></i>Save
        </button>
    </div>
</form>

@endsection

@push('styles')
<style>
    .readonly-field {
        background-color: #f1f3f5 !important;
        color: #495057 !important;
        cursor: not-allowed;
    }
</style>
@endpush
