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

                            <input type="text" class="form-control" value="{{ $division?->DivisionName ?? '-' }}"
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


                        <div class="col-md-4 existing-folder-section">

                            <label class="form-label">
                                Existing Sharing Folder
                            </label>

                            <div class="folder-picker">

                                <div class="folder-search mb-2">

                                    <input type="text" id="folderSearch" class="form-control"
                                        placeholder="Search folder...">

                                </div>

                                <div class="border rounded p-2 folder-list">

                                    @foreach ($folders as $folder)
                                        <div class="form-check folder-item py-1"
                                            data-search="{{ strtolower($folder->FolderName . ' ' . $folder->FolderPath) }}">

                                            <input class="form-check-input" type="checkbox" name="FolderPathIDs[]"
                                                value="{{ $folder->FolderPathID }}"
                                                id="folder_{{ $folder->FolderPathID }}" @checked(in_array($folder->FolderPathID, old('FolderPathIDs', $selectedFolderIds ?? [])))>

                                            <label class="form-check-label" for="folder_{{ $folder->FolderPathID }}">

                                                <strong>
                                                    {{ $folder->FolderName }}
                                                </strong>

                                                <small class="text-muted d-block">
                                                    {{ $folder->FolderPath }}
                                                </small>

                                            </label>

                                        </div>
                                    @endforeach

                                </div>

                            </div>

                        </div>


                        <div class="col-md-8 new-folder-section d-none">

                            <div class="row g-3">

                                <div class="col-md-6">

                                    <label class="form-label">
                                        Parent Folder <span class="text-danger">*</span>
                                    </label>

                                    <select name="ParentFolderPathID" id="ParentFolderPathID" class="form-select">

                                        <option value="">
                                            - Select Parent Folder -
                                        </option>

                                        @foreach ($folders as $folder)
                                            <option value="{{ $folder->FolderPathID }}" @selected(old('ParentFolderPathID', $selectedParentFolderId ?? '') === $folder->FolderPathID)>
                                                {{ $folder->FolderName }}
                                                -
                                                {{ $folder->FolderPath }}
                                            </option>
                                        @endforeach

                                    </select>

                                </div>


                                <div class="col-md-6">

                                    <label class="form-label">
                                        New Folder Name
                                        <span class="text-danger">*</span>
                                    </label>

                                    <input type="text" name="NewFolderName" id="NewFolderName" class="form-control"
                                        value="{{ old('NewFolderName', $newFolderName ?? '') }}" maxlength="150">

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

        .folder-list {
            max-height: 280px;
            overflow-y: auto;
        }

        .folder-item {
            border-radius: 5px;
            padding-left: .5rem !important;
            padding-right: .5rem !important;
        }

        .folder-item:hover {
            background: #f8f9fa;
        }

        .folder-item label {
            cursor: pointer;
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

                        document
                            .querySelectorAll('.folder-item')
                            .forEach(function(item) {

                                item.style.display = !keyword ||
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
