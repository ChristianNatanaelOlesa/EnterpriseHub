@extends('layouts.app')

@php($mode = 'edit')

@section('title', 'Edit Employee Sharing Folder')

@section('content')

<div class="container-fluid">

    <div class="mb-4">
        <h4 class="mb-1">
            {{ $mode === 'edit' ? 'Edit Employee Sharing Folder Request' : 'Create Employee Sharing Folder Request' }}
        </h4>

        <div class="text-muted">
            {{ $mode === 'edit' ? 'Update employee sharing folder request' : 'Create new employee sharing folder request' }}
        </div>
    </div>

    <x-alert />

    @if($errors->any())
        <div class="eh-validation-alert mb-3">
            <div class="eh-validation-title">
                <i class="bi bi-exclamation-circle-fill"></i>
                <strong>Please check the following:</strong>
            </div>

            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        method="POST"
        action="{{ $mode === 'edit'
            ? route('employee-sharing-folder.update', $data->EmpSharingFolderID)
            : route('employee-sharing-folder.store') }}"
    >

        @csrf

        @if($mode === 'edit')
            @method('PUT')
        @endif

        <div class="card mb-3">

            <div class="card-header">
                <h5 class="mb-0">Employee Information</h5>
            </div>

            <div class="card-body">

                <div class="row g-3">

                    <div class="col-md-4">

                        <label class="form-label">Employee Sharing Folder ID</label>

                        <input
                            type="text"
                            class="form-control"
                            value="{{ $mode === 'edit' ? $data->EmpSharingFolderID : 'AUTO' }}"
                            readonly
                        >

                    </div>

                    <div class="col-md-4">

                        <label class="form-label">Emp Form ID</label>

                        <input
                            type="text"
                            class="form-control"
                            value="{{ $mode === 'edit' ? $data->EmpFormID : ($empFormID ?? '-') }}"
                            readonly
                        >

                    </div>

                    <div class="col-md-4">

                        <label class="form-label">Request Date</label>

                        <input
                            type="text"
                            class="form-control"
                            value="{{ $mode === 'edit'
                                ? ($data->ReqDate?->format('d/m/Y') ?? '-')
                                : now()->format('d/m/Y') }}"
                            readonly
                        >

                    </div>

                    <div class="col-md-4">

                        <label class="form-label">Request User</label>

                        <input
                            type="text"
                            class="form-control"
                            value="{{ $mode === 'edit'
                                ? $data->EmpFormID
                                : ($reqUser ?? '-') }}"
                            readonly
                        >

                    </div>

                    <div class="col-md-4">

                        <label class="form-label">Division</label>

                        <input
                            type="text"
                            class="form-control"
                            value="{{ $mode === 'edit'
                                ? ($data->division?->Division ?? '-')
                                : ($division?->Division ?? '-') }}"
                            readonly
                        >

                    </div>

                </div>

            </div>

        </div>

        <div class="card mb-3">

            <div class="card-header">
                <h5 class="mb-0">Sharing Folder Request</h5>
            </div>

            <div class="card-body">

                <div class="row g-3">

                    <div class="col-md-4">

                        <label for="ReqType" class="form-label">
                            Request Type <span class="text-danger">*</span>
                        </label>

                        <select
                            name="ReqType"
                            id="ReqType"
                            class="form-select"
                            required
                        >
                            <option value="Permanent"
                                @selected(old('ReqType', $data->ReqType ?? 'Permanent') === 'Permanent')>
                                Permanent
                            </option>

                            <option value="Temporary"
                                @selected(old('ReqType', $data->ReqType ?? '') === 'Temporary')>
                                Temporary
                            </option>
                        </select>

                    </div>

                    <div class="col-md-4">

                        <label for="DateFrom" class="form-label">
                            Date From <span class="text-danger">*</span>
                        </label>

                        <input
                            type="date"
                            name="DateFrom"
                            id="DateFrom"
                            class="form-control"
                            value="{{ old(
                                'DateFrom',
                                $data->DateFrom?->format('Y-m-d') ?? now()->format('Y-m-d')
                            ) }}"
                            required
                        >

                    </div>

                    <div class="col-md-4">

                        <label for="DateUntil" class="form-label">
                            Date Until
                        </label>

                        <input
                            type="date"
                            name="DateUntil"
                            id="DateUntil"
                            class="form-control"
                            value="{{ old(
                                'DateUntil',
                                $data->DateUntil?->format('Y-m-d') ?? '1900-01-01'
                            ) }}"
                        >

                    </div>

                    <div class="col-md-4">

                        <label for="FolderRequestType" class="form-label">
                            Folder Request <span class="text-danger">*</span>
                        </label>

                        <select
                            name="FolderRequestType"
                            id="FolderRequestType"
                            class="form-select"
                            required
                        >
                            <option value="Existing"
                                @selected(old(
                                    'FolderRequestType',
                                    $data->FolderRequestType ?? 'Existing'
                                ) === 'Existing')>
                                Existing Folder
                            </option>

                            <option value="New"
                                @selected(old(
                                    'FolderRequestType',
                                    $data->FolderRequestType ?? ''
                                ) === 'New')>
                                New Folder
                            </option>
                        </select>

                    </div>

                    <div class="col-md-4">

                        <label for="AccessType" class="form-label">
                            Access Type <span class="text-danger">*</span>
                        </label>

                        <select
                            name="AccessType"
                            id="AccessType"
                            class="form-select"
                            required
                        >
                            <option value="Read"
                                @selected(old(
                                    'AccessType',
                                    $existingAccessType ?? 'Read'
                                ) === 'Read')>
                                Read
                            </option>

                            <option value="ReadWrite"
                                @selected(old(
                                    'AccessType',
                                    $existingAccessType ?? ''
                                ) === 'ReadWrite')>
                                Read &amp; Write
                            </option>
                        </select>

                    </div>

                    
                        <div class="col-12 existing-folder-section">

                            <div class="folder-section-header mb-3">
                                <div>
                                    <label class="form-label mb-1">
                                        Existing Sharing Folder
                                    </label>
                                    <div class="text-muted small">
                                        Select one or more existing folders to grant access.
                                    </div>
                                </div>

                                <span class="folder-count-badge">
                                    <i class="bi bi-folder2-open me-1"></i>
                                    {{ $folders->count() }} available
                                </span>
                            </div>

                            <div class="folder-picker">

                                <div class="folder-search-wrap mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-search"></i>
                                        </span>
                                        <input
                                            type="text"
                                            id="folderSearch"
                                            class="form-control"
                                            placeholder="Search folder name or path..."
                                            autocomplete="off"
                                        >
                                    </div>
                                </div>

                                <div class="folder-list" id="folderList">

                                    @forelse($folders as $folder)

                                        <div
                                            class="folder-card folder-item"
                                            data-search="{{ strtolower($folder->FolderName . ' ' . $folder->FolderPath) }}"
                                        >

                                            <input
                                                class="folder-checkbox"
                                                type="checkbox"
                                                name="FolderPathIDs[]"
                                                value="{{ $folder->FolderPathID }}"
                                                id="folder_{{ $folder->FolderPathID }}"
                                                @checked(
                                                    in_array(
                                                        $folder->FolderPathID,
                                                        old('FolderPathIDs', $selectedFolderIds ?? [])
                                                    )
                                                )
                                            >

                                            <label
                                                class="folder-card-label"
                                                for="folder_{{ $folder->FolderPathID }}"
                                            >
                                                <span class="folder-icon">
                                                    <i class="bi bi-folder-fill"></i>
                                                </span>

                                                <span class="folder-card-content">
                                                    <strong class="folder-card-name">
                                                        {{ $folder->FolderName }}
                                                    </strong>

                                                    <span class="folder-card-path">
                                                        {{ $folder->FolderPath }}
                                                    </span>
                                                </span>

                                                <span class="folder-card-check">
                                                    <i class="bi bi-check2"></i>
                                                </span>
                                            </label>

                                        </div>

                                    @empty

                                        <div class="folder-empty-state">
                                            <i class="bi bi-folder-x"></i>
                                            <div class="fw-semibold">No active sharing folders found</div>
                                            <div class="text-muted small">
                                                Create a Folder Path first before requesting access.
                                            </div>
                                        </div>

                                    @endforelse

                                </div>

                                <div id="folderSearchEmpty" class="folder-empty-state d-none">
                                    <i class="bi bi-search"></i>
                                    <div class="fw-semibold">No matching folder</div>
                                    <div class="text-muted small">
                                        Try another folder name or path.
                                    </div>
                                </div>

                            </div>

                        </div>



                        <div class="col-12 new-folder-section d-none">

                            <div class="new-folder-panel">

                                <div class="new-folder-panel-header mb-3">
                                    <div>
                                        <div class="fw-semibold">
                                            <i class="bi bi-folder-plus me-1"></i>
                                            Create New Sharing Folder
                                        </div>
                                        <div class="text-muted small">
                                            Select the parent folder and enter the new folder name.
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-3">

                                    <div class="col-md-6">

                                        <label class="form-label">
                                            Create Under Folder <span class="text-danger">*</span>
                                        </label>

                                        <select
                                            name="ParentFolderPathID"
                                            id="ParentFolderPathID"
                                            class="form-select"
                                        >

                                            <option value="">
                                                - Select Folder Path -
                                            </option>

                                            @foreach ($folders as $folder)
                                                <option
                                                    value="{{ $folder->FolderPathID }}"
                                                    data-path="{{ $folder->FolderPath }}"
                                                    @selected(
                                                        old(
                                                            'ParentFolderPathID',
                                                            $selectedParentFolderId ?? ''
                                                        ) == $folder->FolderPathID
                                                    )
                                                >
                                                    {{ $folder->FolderName }} - {{ $folder->FolderPath }}
                                                </option>
                                            @endforeach

                                        </select>

                                    </div>

                                    <div class="col-md-6">

                                        <label class="form-label">
                                            New Folder Name <span class="text-danger">*</span>
                                        </label>

                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bi bi-folder-plus"></i>
                                            </span>
                                            <input
                                                type="text"
                                                name="NewFolderName"
                                                id="NewFolderName"
                                                class="form-control"
                                                value="{{ old('NewFolderName', $newFolderName ?? '') }}"
                                                maxlength="150"
                                                placeholder="e.g. Human Capital"
                                            >
                                        </div>

                                        <div class="form-text">
                                            Use the folder name only. The final network path will be generated from the selected Folder Path.
                                        </div>

                                    </div>

                                    <div class="col-12">
                                        <div class="requested-path-preview">
                                            <div class="small text-muted mb-1">Requested Path Preview</div>
                                            <div class="font-monospace" id="requestedPathPreview">-</div>
                                            <input type="hidden" id="RequestedPathPreview" value="">
                                        </div>
                                    </div>

                                </div>

                            </div>

                        </div>

                    <div class="col-12">

                        <label for="Purpose" class="form-label">
                            Purpose <span class="text-danger">*</span>
                        </label>

                        <textarea
                            name="Purpose"
                            id="Purpose"
                            rows="3"
                            class="form-control"
                            required
                        >{{ old('Purpose', $data->Purpose ?? 'Kebutuhan Pekerjaan') }}</textarea>

                    </div>

                    <div class="col-12">

                        <label for="Notes" class="form-label">
                            Notes
                        </label>

                        <textarea
                            name="Notes"
                            id="Notes"
                            rows="3"
                            class="form-control"
                        >{{ old('Notes', $data->Notes ?? '-') }}</textarea>

                    </div>

                </div>

            </div>

        </div>

        <div class="d-flex justify-content-end gap-2 mb-4">

            <a
                href="{{ route('employee-sharing-folder.index') }}"
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

@push('styles')
<style>
    .eh-validation-alert {
        background: #f8d7da;
        border: 1px solid #f1aeb5;
        color: #842029;
        border-radius: 6px;
        padding: 1rem 1.1rem;
    }

    .eh-validation-title {
        display: flex;
        align-items: center;
        gap: .5rem;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const reqType = document.getElementById('ReqType');
    const dateFrom = document.getElementById('DateFrom');
    const dateUntil = document.getElementById('DateUntil');

    const folderRequestType = document.getElementById('FolderRequestType');
    const existingSection = document.querySelector('.existing-folder-section');
    const newSection = document.querySelector('.new-folder-section');

    const folderSearch = document.getElementById('folderSearch');
    const parentFolderPath = document.getElementById('ParentFolderPathID');
    const newFolderName = document.getElementById('NewFolderName');
    const requestedPathPreview = document.getElementById('requestedPathPreview');

    function syncRequestedPathPreview() {
        if (!parentFolderPath || !newFolderName || !requestedPathPreview) {
            return;
        }

        const option = parentFolderPath.options[parentFolderPath.selectedIndex];
        const rawPath = option?.dataset?.path || '';
        const folderName = newFolderName.value.trim();

        requestedPathPreview.textContent = rawPath && folderName
            ? rawPath.replace(/\\+$/, '') + '\\' + folderName
            : '-';
    }

    function syncDateUntil() {

        if (reqType.value === 'Permanent') {

            dateUntil.value = '1900-01-01';
            dateUntil.readOnly = true;
            dateUntil.removeAttribute('min');

        } else {

            dateUntil.readOnly = false;
            dateUntil.min = dateFrom.value || '';

            if (
                !dateUntil.value ||
                dateUntil.value === '1900-01-01'
            ) {
                dateUntil.value = dateFrom.value || '';
            }
        }
    }

    function syncFolderType() {

        if (folderRequestType.value === 'Existing') {

            existingSection.classList.remove('d-none');
            newSection.classList.add('d-none');

        } else {

            existingSection.classList.add('d-none');
            newSection.classList.remove('d-none');

        }
    }

    reqType.addEventListener('change', syncDateUntil);

    dateFrom.addEventListener('change', function () {

        if (reqType.value === 'Temporary') {

            dateUntil.min = dateFrom.value || '';

            if (
                dateUntil.value &&
                dateUntil.value !== '1900-01-01' &&
                dateUntil.value < dateFrom.value
            ) {
                dateUntil.value = dateFrom.value;
            }
        }
    });

    folderRequestType.addEventListener('change', syncFolderType);

    if (folderSearch) {

        folderSearch.addEventListener('input', function () {

            const keyword = this.value.toLowerCase().trim();

            let visibleCount = 0;

            document.querySelectorAll('.folder-item').forEach(function (item) {

                const visible =
                    !keyword ||
                    item.dataset.search.includes(keyword);

                item.style.display = visible ? '' : 'none';

                if (visible) {
                    visibleCount++;
                }

            });

            const emptyState =
                document.getElementById('folderSearchEmpty');

            if (emptyState) {
                emptyState.classList.toggle(
                    'd-none',
                    visibleCount > 0
                );
            }

        });

    }

    if (parentFolderPath) {
        parentFolderPath.addEventListener('change', syncRequestedPathPreview);
    }

    if (newFolderName) {
        newFolderName.addEventListener('input', syncRequestedPathPreview);
    }

    syncDateUntil();
    syncFolderType();
    syncRequestedPathPreview();

});
</script>
@endpush
