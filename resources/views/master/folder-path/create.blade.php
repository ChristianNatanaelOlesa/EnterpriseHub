@extends('layouts.app')

@php($mode = 'create')

@section('title', 'Create Folder Path')

@section('content')

<div class="container-fluid">

    <div class="mb-4">
        <h4 class="mb-1">
            {{ $mode === 'edit' ? 'Edit Folder Path' : 'Create Folder Path' }}
        </h4>

        <div class="text-muted">
            {{ $mode === 'edit' ? 'Update sharing folder path master' : 'Create sharing folder path master' }}
        </div>
    </div>

    <x-alert />

    @if($errors->any())
        <div class="alert alert-danger">
            <div class="fw-semibold mb-1">
                <i class="bi bi-exclamation-circle me-1"></i>
                Please check the following:
            </div>

            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        method="POST"
        action="{{ $mode === 'edit'
            ? route('master.folder-path.update', $data->FolderPathID)
            : route('master.folder-path.store') }}"
    >

        @csrf

        @if($mode === 'edit')
            @method('PUT')
        @endif

        <div class="card mb-3">

            <div class="card-header">
                <h5 class="mb-0">Folder Path Information</h5>
            </div>

            <div class="card-body">

                <div class="row g-3">

                    @if($mode === 'edit')
                        <div class="col-md-4">
                            <label class="form-label">Folder Path ID</label>
                            <input
                                type="text"
                                class="form-control"
                                value="{{ $data->FolderPathID }}"
                                readonly
                            >
                        </div>
                    @endif

                    <div class="col-md-{{ $mode === 'edit' ? '4' : '6' }}">
                        <label class="form-label">
                            Folder Name <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            name="FolderName"
                            class="form-control @error('FolderName') is-invalid @enderror"
                            value="{{ old('FolderName', $data->FolderName ?? '') }}"
                            maxlength="150"
                            required
                        >

                        @error('FolderName')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-{{ $mode === 'edit' ? '4' : '6' }}">
                        <label class="form-label">
                            Folder Path <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            name="FolderPath"
                            class="form-control @error('FolderPath') is-invalid @enderror"
                            value="{{ old('FolderPath', $data->FolderPath ?? '') }}"
                            maxlength="500"
                            required
                        >

                        @error('FolderPath')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">

                        <label class="form-label">Parent Folder</label>

                        <select
                            name="ParentFolderPathID"
                            class="form-select @error('ParentFolderPathID') is-invalid @enderror"
                        >
                            <option value="">- Root Folder -</option>

                            @foreach($parents as $parent)
                                <option
                                    value="{{ $parent->FolderPathID }}"
                                    @selected(old(
                                        'ParentFolderPathID',
                                        $data->ParentFolderPathID ?? ''
                                    ) === $parent->FolderPathID)
                                >
                                    {{ $parent->FolderName }} - {{ $parent->FolderPath }}
                                </option>
                            @endforeach
                        </select>

                        @error('ParentFolderPathID')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                    </div>

                    <div class="col-md-6 d-flex align-items-end">

                        <div class="form-check form-switch mb-2">

                            <input
                                type="checkbox"
                                class="form-check-input"
                                name="IsActive"
                                id="IsActive"
                                value="1"
                                @checked(old('IsActive', $data->IsActive ?? true))
                            >

                            <label class="form-check-label" for="IsActive">
                                Active
                            </label>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="d-flex justify-content-end gap-2 mb-4">

            <a
                href="{{ route('master.folder-path.index') }}"
                class="btn btn-secondary"
            >
                Close
            </a>

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save me-1"></i>
                {{ $mode === 'edit' ? 'Update' : 'Create' }}
            </button>

        </div>

    </form>

</div>

@endsection
