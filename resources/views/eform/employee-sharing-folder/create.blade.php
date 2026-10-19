@extends('layouts.app')

@php($mode = 'create')

@section('title', 'Create Employee Sharing Folder')

@section('content')

    <div class="container-fluid">

        <div class="mb-4">
            <h4 class="mb-1">
                Create Employee Sharing Folder Request
            </h4>

            <div class="text-muted">
                Create new employee sharing folder request
            </div>
        </div>

        <x-alert />

        @if ($errors->any())
            <div class="eh-validation-alert mb-3">
                <div class="eh-validation-title">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    <strong>Please check the following:</strong>
                </div>

                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('employee-sharing-folder.store') }}">

            @csrf

            <div class="card mb-3">

                <div class="card-header">
                    <h5 class="mb-0">Employee Information</h5>
                </div>

                <div class="card-body">

                    <div class="row g-3">

                        <div class="col-md-4">

                            <label class="form-label">
                                Employee Sharing Folder ID
                            </label>

                            <input type="text" class="form-control" value="AUTO" readonly>

                        </div>

                        <div class="col-md-4">

                            <label class="form-label">
                                Emp Form ID
                            </label>

                            <input type="text" class="form-control" value="{{ $empFormID ?? '-' }}" readonly>

                        </div>

                        <div class="col-md-4">

                            <label class="form-label">
                                Request Date
                            </label>

                            <input type="text" class="form-control" value="{{ now()->format('d/m/Y') }}" readonly>

                        </div>

                        <div class="col-md-4">

                            <label class="form-label">
                                Request User
                            </label>

                            <input type="text" class="form-control" value="{{ $reqUser ?? '-' }}" readonly>

                        </div>

                        <div class="col-md-4">

                            <label class="form-label">
                                Division
                            </label>

                            <input type="text" class="form-control" value="{{ $division?->Division ?? '-' }}"
                                readonly>

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

                            <select name="ReqType" id="ReqType" class="form-select" required>

                                <option value="Permanent" @selected(old('ReqType', 'Permanent') === 'Permanent')>
                                    Permanent
                                </option>

                                <option value="Temporary" @selected(old('ReqType') === 'Temporary')>
                                    Temporary
                                </option>

                            </select>

                        </div>


                        <div class="col-md-4">

                            <label for="DateFrom" class="form-label">
                                Date From
                            </label>

                            <input type="date" name="DateFrom" id="DateFrom" class="form-control"
                                value="{{ old('DateFrom', now()->format('Y-m-d')) }}" required>

                        </div>


                        <div class="col-md-4">

                            <label for="DateUntil" class="form-label">
                                Date Until
                            </label>

                            <input type="date" name="DateUntil" id="DateUntil" class="form-control"
                                value="{{ old('DateUntil', '1900-01-01') }}">

                        </div>


                        <div class="col-md-4">

                            <label for="FolderRequestType" class="form-label">
                                Folder Request <span class="text-danger">*</span>
                            </label>

                            <select name="FolderRequestType" id="FolderRequestType" class="form-select" required>

                                <option value="Existing" @selected(old('FolderRequestType', 'Existing') === 'Existing')>
                                    Existing Folder
                                </option>

                                <option value="New" @selected(old('FolderRequestType') === 'New')>
                                    New Folder
                                </option>

                            </select>

                        </div>


                        <div class="col-md-4">

                            <label for="AccessType" class="form-label">
                                Access Type <span class="text-danger">*</span>
                            </label>

                            <select name="AccessType" id="AccessType" class="form-select" required>

                                <option value="Read" @selected(old('AccessType', $existingAccessType ?? 'Read') === 'Read')>
                                    Read
                                </option>

                                <option value="ReadWrite" @selected(old('AccessType', $existingAccessType ?? '') === 'ReadWrite')>
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

                            <textarea name="Purpose" id="Purpose" rows="3" class="form-control" required>{{ old('Purpose', 'Kebutuhan Pekerjaan') }}</textarea>

                        </div>


                        <div class="col-12">

                            <label for="Notes" class="form-label">
                                Notes
                            </label>

                            <textarea name="Notes" id="Notes" rows="3" class="form-control">{{ old('Notes', '-') }}</textarea>

                        </div>

                    </div>

                </div>

            </div>


            <div class="d-flex justify-content-end gap-2 mb-4">

                <a href="{{ route('employee-sharing-folder.index') }}" class="btn btn-secondary">
                    Close
                </a>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i>
                    Create
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


        .folder-section-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 1rem;
        }

        .folder-count-badge {
            display: inline-flex;
            align-items: center;
            white-space: nowrap;
            padding: .35rem .65rem;
            border: 1px solid #dee2e6;
            border-radius: 999px;
            background: #f8f9fa;
            color: #6c757d;
            font-size: .8rem;
        }

        .folder-search-wrap {
            max-width: 100%;
        }

        .folder-list {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: .75rem;
            max-height: 360px;
            overflow-y: auto;
            padding: .15rem;
        }

        .folder-card {
            position: relative;
            min-width: 0;
        }

        .folder-checkbox {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .folder-card-label {
            position: relative;
            display: flex;
            align-items: center;
            gap: .75rem;
            width: 100%;
            min-height: 76px;
            margin: 0;
            padding: .8rem .9rem;
            border: 1px solid #dee2e6;
            border-radius: .6rem;
            background: #fff;
            cursor: pointer;
            transition: border-color .15s ease, box-shadow .15s ease, background-color .15s ease;
        }

        .folder-card-label:hover {
            border-color: #b6c2d2;
            background: #f8fafc;
        }

        .folder-checkbox:checked + .folder-card-label {
            border-color: #0d6efd;
            background: #f4f8ff;
            box-shadow: 0 0 0 2px rgba(13, 110, 253, .08);
        }

        .folder-icon {
            flex: 0 0 38px;
            width: 38px;
            height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: .5rem;
            background: #eef4ff;
            color: #0d6efd;
            font-size: 1.1rem;
        }

        .folder-card-content {
            min-width: 0;
            flex: 1 1 auto;
            display: flex;
            flex-direction: column;
            gap: .2rem;
        }

        .folder-card-name {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .folder-card-path {
            display: block;
            color: #6c757d;
            font-size: .8rem;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .folder-card-check {
            flex: 0 0 auto;
            width: 28px;
            height: 28px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #dee2e6;
            border-radius: 50%;
            color: transparent;
            background: #fff;
        }

        .folder-checkbox:checked + .folder-card-label .folder-card-check {
            border-color: #0d6efd;
            background: #0d6efd;
            color: #fff;
        }

        .folder-empty-state {
            min-height: 150px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 1.5rem;
            border: 1px dashed #ced4da;
            border-radius: .6rem;
            background: #f8f9fa;
            color: #6c757d;
        }

        .folder-empty-state > i {
            font-size: 1.8rem;
            margin-bottom: .5rem;
        }

        .new-folder-panel {
            padding: 1rem;
            border: 1px solid #dee2e6;
            border-radius: .65rem;
            background: #f8fafc;
        }


        .requested-path-preview {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: .5rem;
            padding: .75rem .9rem;
        }

        .requested-path-preview .font-monospace {
            overflow-wrap: anywhere;
            color: #495057;
        }

        @media (max-width: 767.98px) {
            .folder-section-header {
                flex-direction: column;
            }

            .folder-list {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush


@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const reqType =
                document.getElementById('ReqType');

            const dateFrom =
                document.getElementById('DateFrom');

            const dateUntil =
                document.getElementById('DateUntil');

            const folderRequestType =
                document.getElementById('FolderRequestType');

            const existingSection =
                document.querySelector('.existing-folder-section');

            const newSection =
                document.querySelector('.new-folder-section');

            const folderSearch =
                document.getElementById('folderSearch');

            const parentFolderPath =
                document.getElementById('ParentFolderPathID');

            const newFolderName =
                document.getElementById('NewFolderName');

            const requestedPathPreview =
                document.getElementById('requestedPathPreview');

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

                    dateUntil.min =
                        dateFrom.value || '';

                    if (
                        !dateUntil.value ||
                        dateUntil.value === '1900-01-01'
                    ) {

                        dateUntil.value =
                            dateFrom.value || '';

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


            reqType.addEventListener(
                'change',
                syncDateUntil
            );


            dateFrom.addEventListener(
                'change',
                function() {

                    if (reqType.value === 'Temporary') {

                        dateUntil.min =
                            dateFrom.value || '';

                        if (
                            dateUntil.value &&
                            dateUntil.value !== '1900-01-01' &&
                            dateUntil.value < dateFrom.value
                        ) {

                            dateUntil.value =
                                dateFrom.value;

                        }

                    }

                }
            );


            folderRequestType.addEventListener(
                'change',
                syncFolderType
            );


            if (folderSearch) {

                folderSearch.addEventListener(
                    'input',
                    function() {

                        const keyword =
                            this.value.toLowerCase().trim();

                        let visibleCount = 0;

                        document
                            .querySelectorAll('.folder-item')
                            .forEach(function(item) {

                                const visible = !keyword ||
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
                        }|
                                    item.dataset.search.includes(keyword) ?
                                    '' :
                                    'none';

                            });

                    }
                );

            }


            syncDateUntil();

            syncFolderType();

        });
    </script>
@endpush
