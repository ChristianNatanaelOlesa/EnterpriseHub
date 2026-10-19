@extends('layouts.app')

@section('title', 'Employee Sharing Folder')

@section('content')

    <div class="container-fluid">

        <div class="mb-4">
            <h4 class="mb-1">Employee Sharing Folder</h4>
            <div class="text-muted">Employee Sharing Folder Request List</div>
        </div>

        <x-alert />

        <div class="card mb-3">
            <div class="card-body">

                <form method="GET" action="{{ route('employee-sharing-folder.index') }}" class="row g-2">

                    <div class="col-md-8">
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                            placeholder="Search anything...">
                    </div>

                    <div class="col-auto">
                        <button type="submit" class="btn btn-outline-primary">
                            <i class="bi bi-search me-1"></i>
                            Search
                        </button>
                    </div>

                    @if (request('search'))
                        <div class="col-auto">
                            <a href="{{ route('employee-sharing-folder.index') }}" class="btn btn-outline-secondary">
                                Clear
                            </a>
                        </div>
                    @endif

                </form>

            </div>
        </div>

        <div class="card">

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-hover align-middle sharing-folder-table">

                        <thead>
                            <tr>
                                <th class="text-center" width="55">#</th>
                                <th>Sharing Folder ID</th>
                                <th>Emp Form ID</th>
                                <th>Request User</th>
                                <th>Division</th>
                                <th>Request Type</th>
                                <th>Folder Request</th>
                                <th>Folder</th>
                                <th>Date From</th>
                                <th>Date Until</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($data as $item)

                                <tr class="sharing-folder-row" data-id="{{ $item->EmpSharingFolderID }}"
                                    data-emp-form-id="{{ $item->EmpFormID }}"
                                    data-status="{{ strtoupper((string) ($item->Status ?? 'DRAFT')) }}"
                                    style="cursor:pointer;">

                                    <td class="text-center">
                                        <span class="row-selector">
                                            <i class="bi bi-circle-fill"></i>
                                        </span>
                                    </td>

                                    <td>{{ $item->EmpSharingFolderID }}</td>

                                    <td>{{ $item->EmpFormID }}</td>

                                    <td>{{ $item->EmpFormID }}</td>

                                    <td>{{ $item->division?->Division ?? '-' }}</td>

                                    <td>{{ $item->ReqType }}</td>

                                    <td>{{ $item->FolderRequestType }}</td>

                                    <td>
                                        @if ($item->FolderRequestType === 'Existing')
                                            {{ $item->details->map(fn($d) => $d->folderPath?->FolderName ?? '-')->join(', ') }}
                                        @else
                                            @foreach ($item->details as $detail)
                                                <div class="fw-semibold">{{ $detail->FolderName ?? '-' }}</div>
                                                <div class="small text-muted font-monospace">
                                                    {{ $detail->RequestedPath ?? '-' }}</div>
                                            @endforeach
                                        @endif
                                    </td>

                                    <td>{{ $item->DateFrom?->format('d/m/Y') ?? '-' }}</td>

                                    <td>
                                        {{ $item->DateUntil?->format('Y-m-d') === '1900-01-01' ? '-' : $item->DateUntil?->format('d/m/Y') ?? '-' }}
                                    </td>

                                    <td class="text-center">
                                        <span class="badge bg-secondary status-badge">
                                            {{ $item->Status }}
                                        </span>
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="11" class="text-center text-muted py-5">
                                        No Employee Sharing Folder Request found.
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                <div class="mt-3">
                    {{ $data->links() }}
                </div>

            </div>

        </div>

        <div class="d-flex justify-content-end align-items-center gap-2 mt-3 mb-4">

            @canAdd('employee-sharing-folder.index')
            <a href="{{ route('employee-sharing-folder.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i>
                Create
            </a>
            @endcanAdd

            @canEdit('employee-sharing-folder.index')
            <a href="#" id="updateButton" class="btn btn-warning disabled" aria-disabled="true">
                <i class="bi bi-pencil me-1"></i>
                Update
            </a>
            @endcanEdit

            @canDelete('employee-sharing-folder.index')
            <form id="deleteForm" method="POST" action="#" class="d-inline">
                @csrf
                @method('DELETE')

                <button type="submit" id="deleteButton" class="btn btn-danger" disabled>
                    <i class="bi bi-trash me-1"></i>
                    Delete
                </button>
            </form>
            @endcanDelete

            <button type="button" id="btnDetail" class="btn btn-outline-primary" disabled>
                <i class="bi bi-eye me-1"></i>Detail
            </button>

            {{-- Workflow action: requester may submit draft/revision-required transactions. --}}
            @canEdit('employee-sharing-folder.index')
            <form method="POST" action="{{ route('workflow.request-approval') }}" id="requestApprovalForm"
                class="d-inline">
                @csrf
                <input type="hidden" name="process_id" value="EMPLOYEE_SHARING_FOLDER">
                <input type="hidden" name="module" value="EMPLOYEE_SHARING_FOLDER">
                <input type="hidden" name="transaction_id" id="approvalTransactionId">
                <button type="submit" id="btnRequestApproval" class="btn btn-success" disabled>
                    <i class="bi bi-send me-1"></i>Request Approval
                </button>
            </form>
            @endcanEdit

        </div>

    </div>




    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('requestApprovalForm');
            const idInput = document.getElementById('approvalTransactionId');
            const button = document.getElementById('btnRequestApproval');
            if (!form || !idInput || !button) return;
            const rows = document.querySelectorAll('.sharing-folder-row');
            const currentUser = @json(auth()->user()->EmpFormID ?? '');
            rows.forEach(row => row.addEventListener('click', function() {
                const id = row.dataset.id || row.dataset.transactionId || '';
                const status = (row.dataset.status || 'DRAFT').toUpperCase();
                const requester = row.dataset.empFormId || '';
                idInput.value = id;
                button.disabled = !(id && requester === currentUser && ['DRAFT', 'REVISION_REQUIRED']
                    .includes(status));
            }));
        });
    </script>


    <div class="modal fade" id="transactionRowDetailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content bg-white text-dark">
                <div class="modal-header">
                    <h5 class="modal-title">Transaction Detail</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <dl class="row mb-0" id="transactionRowDetailContent"></dl>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const rows = document.querySelectorAll('tbody tr[data-id], tbody tr[data-transaction-id]');
            const detailButton = document.getElementById('btnDetail');
            const modalElement = document.getElementById('transactionRowDetailModal');
            const content = document.getElementById('transactionRowDetailContent');
            let selectedRow = null;
            if (!detailButton || !modalElement || !content) return;
            rows.forEach(function(row) {
                row.addEventListener('click', function() {
                    selectedRow = row;
                    detailButton.disabled = false;
                });
            });
            detailButton.addEventListener('click', function() {
                if (!selectedRow) return;
                content.replaceChildren();
                const headers = Array.from(selectedRow.closest('table').querySelectorAll('thead th'));
                const cells = Array.from(selectedRow.querySelectorAll('td'));
                headers.forEach(function(header, index) {
                    if (!cells[index]) return;
                    const label = header.textContent.trim();
                    const value = cells[index].innerText.trim() || '-';
                    if (!label || label === '#') return;
                    const dt = document.createElement('dt');
                    dt.className = 'col-sm-4 text-muted mb-2';
                    dt.textContent = label;
                    const dd = document.createElement('dd');
                    dd.className = 'col-sm-8 mb-2';
                    dd.textContent = value;
                    content.append(dt, dd);
                });
                bootstrap.Modal.getOrCreateInstance(modalElement).show();
            });
        });
    </script>

@endsection

@push('styles')
    <style>
        .sharing-folder-table th,
        .sharing-folder-table td {
            vertical-align: middle;
        }

        .sharing-folder-table th.text-center,
        .sharing-folder-table td.text-center {
            text-align: center !important;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 52px;
            min-height: 22px;
            line-height: 1;
        }

        .sharing-folder-row.table-primary .row-selector i {
            color: #0d6efd;
        }

        .row-selector i {
            color: #adb5bd;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const rows = document.querySelectorAll('.sharing-folder-row');
            const updateButton = document.getElementById('updateButton');
            const deleteButton = document.getElementById('deleteButton');
            const deleteForm = document.getElementById('deleteForm');

            let selectedId = null;

            function setSelectedRow(row) {

                rows.forEach(function(item) {
                    item.classList.remove('table-primary');

                    const icon = item.querySelector('.row-selector i');

                    if (icon) {
                        icon.className = 'bi bi-circle-fill';
                    }
                });

                if (!row) {

                    selectedId = null;

                    if (updateButton) {
                        updateButton.classList.add('disabled');
                        updateButton.href = '#';
                        updateButton.setAttribute('aria-disabled', 'true');
                    }

                    if (deleteButton) {
                        deleteButton.disabled = true;
                    }

                    if (deleteForm) {
                        deleteForm.action = '#';
                    }

                    return;
                }

                selectedId = row.dataset.id;
                row.classList.add('table-primary');

                const icon = row.querySelector('.row-selector i');

                if (icon) {
                    icon.className = 'bi bi-check-circle-fill';
                }

                if (updateButton) {
                    updateButton.href =
                        "{{ url('/employee-sharing-folder') }}/" +
                        encodeURIComponent(selectedId) +
                        "/edit";

                    updateButton.classList.remove('disabled');
                    updateButton.setAttribute('aria-disabled', 'false');
                }

                if (deleteButton) {
                    deleteButton.disabled = false;
                }

                if (deleteForm) {
                    deleteForm.action =
                        "{{ url('/employee-sharing-folder') }}/" +
                        encodeURIComponent(selectedId);
                }
            }

            rows.forEach(function(row) {
                row.addEventListener('click', function() {

                    if (selectedId === row.dataset.id) {
                        setSelectedRow(null);
                    } else {
                        setSelectedRow(row);
                    }

                });
            });

            if (deleteForm) {
                deleteForm.addEventListener('submit', function(event) {

                    if (!selectedId) {
                        event.preventDefault();
                        return;
                    }

                    if (!confirm('Yakin ingin menghapus Employee Sharing Folder Request ini?')) {
                        event.preventDefault();
                    }

                });
            }

        });
    </script>
@endpush
