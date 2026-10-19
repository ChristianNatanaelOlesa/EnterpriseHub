@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="mb-4">
            <h4 class="mb-1">Employee Equipment Request</h4>
            <div class="text-muted">Employee Equipment Request List</div>
        </div>
        <x-alert />
        <div class="card shadow-sm">
            <div class="card-body">
                <form method="GET" action="{{ route('employee-equipment.index') }}" class="mb-3">
                    <div class="input-group"><span class="input-group-text bg-white"><i
                                class="bi bi-search"></i></span><input type="text" name="search"
                            value="{{ $search }}" class="form-control" placeholder="Search anything...">
                        @if ($search !== '')
                            <a href="{{ route('employee-equipment.index') }}" class="btn btn-outline-secondary">Clear</a>
                        @endif
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="text-center" style="width:55px;">#</th>
                                <th>Emp Equipment ID</th>
                                <th>Emp Form ID</th>
                                <th>Asset ID</th>
                                <th>Asset Type</th>
                                <th>Brand / Model</th>
                                <th>Request Type</th>
                                <th>Date From</th>
                                <th>Date Until</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($employeeEquipments as $item)
                                @php
                                    $workflow = $item->workflowInstance;
                                    $status = strtoupper((string) ($item->Status ?: 'DRAFT'));
                                    $isRevision = $status === 'REVISION_REQUIRED';
                                    $latestRevision = $workflow?->revisions?->first();
                                @endphp
                                <tr class="employee-equipment-row {{ $isRevision ? 'revision-required-row' : '' }}"
                                    data-id="{{ $item->EmpEquipID }}" data-emp-form-id="{{ $item->EmpFormID }}"
                                    data-status="{{ $status }}"
                                    data-workflow-id="{{ $workflow?->WorkflowInstanceID ?? '' }}"
                                    data-revision-reason="{{ $latestRevision?->Reason ?? '' }}" style="cursor:pointer">
                                    <td class="text-center row-selector"><i class="bi bi-circle-fill text-secondary"></i>
                                    </td>
                                    <td>
                                        <strong>{{ $item->EmpEquipID }}</strong>
                                        @if ($isRevision)
                                            <span class="badge rounded-pill bg-warning text-dark ms-1"><i
                                                    class="bi bi-exclamation-circle me-1"></i>Revision Required</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->EmpFormID }}<small
                                            class="d-block text-muted">{{ trim(($item->empForm?->FirstName ?? '') . ' ' . ($item->empForm?->LastName ?? '')) }}</small>
                                    </td>
                                    <td>{{ $item->AssetID }}</td>
                                    <td>{{ $item->asset?->assetType?->AssetType ?? '-' }}</td>
                                    <td>{{ $item->asset?->Brand ?? '-' }}<small
                                            class="d-block text-muted">{{ $item->asset?->Model ?? '-' }}</small></td>
                                    <td>{{ $item->ReqType }}</td>
                                    <td>{{ $item->DateFrom?->format('d M Y') ?? '-' }}</td>
                                    <td>{{ $item->DateUntil && $item->DateUntil->format('Y-m-d') !== '1900-01-01' ? $item->DateUntil->format('d M Y') : '-' }}
                                    </td>
                                    <td>
                                        @if ($isRevision)
                                            <span class="badge bg-warning text-dark"><i
                                                    class="bi bi-pencil-square me-1"></i>REVISION REQUIRED</span>
                                            @if ($latestRevision?->Reason)
                                                <small class="d-block text-warning-emphasis mt-1"
                                                    title="{{ $latestRevision->Reason }}">Perlu diperbaiki</small>
                                            @endif
                                        @else
                                            <span
                                                class="badge bg-{{ $status === 'APPROVED' ? 'success' : ($status === 'REJECTED' ? 'danger' : ($status === 'WAITING_APPROVAL' ? 'secondary' : ($status === 'PROGRESS' ? 'warning text-dark' : 'light text-dark border'))) }}">{{ str_replace('_', ' ', $status) }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty<tr>
                                    <td colspan="10" class="text-center text-muted py-5"><i
                                            class="bi bi-inbox fs-3 d-block mb-2"></i>No Employee Equipment Request found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($employeeEquipments->hasPages())
                    <div class="mt-3">{{ $employeeEquipments->links() }}</div>
                @endif
            </div>
        </div>
        <div class="d-flex justify-content-end gap-2 mt-3">
            <a href="{{ route('employee-equipment.create') }}" class="btn btn-primary"><i
                    class="bi bi-plus-lg me-1"></i>Create</a>
            <button type="button" id="btnUpdate" class="btn btn-warning" disabled><i
                    class="bi bi-pencil me-1"></i>Update</button>
            <button type="button" id="btnDelete" class="btn btn-danger" disabled><i
                    class="bi bi-trash me-1"></i>Delete</button>
            <button type="button" id="btnDetail" class="btn btn-outline-primary" disabled><i
                    class="bi bi-eye me-1"></i>Detail</button>
            <form method="POST" action="{{ route('workflow.request-approval') }}" id="requestApprovalForm"
                class="d-inline">
                @csrf
                <input type="hidden" name="process_id" value="EMPLOYEE_EQUIPMENT">
                <input type="hidden" name="module" value="EMPLOYEE_EQUIPMENT">
                <input type="hidden" name="transaction_id" id="approvalTransactionId">
                <button type="submit" id="btnRequestApproval" class="btn btn-success" disabled><i
                        class="bi bi-send me-1"></i>Request Approval</button>
            </form>
        </div>
    </div>

    <div class="modal fade transaction-detail-modal-shell" id="transactionDetailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content transaction-detail-modal-content">
                <div class="modal-header transaction-detail-modal-header">
                    <div>
                        <h5 class="modal-title mb-0 transaction-detail-modal-title"><i
                                class="bi bi-file-earmark-text me-2"></i>Transaction Detail</h5>
                        <div id="transactionDetailModalSubtitle" class="small transaction-detail-modal-subtitle mt-1"></div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0 transaction-detail-modal-body" id="transactionDetailModalBody">
                    <div class="d-flex justify-content-center align-items-center py-5 text-muted">
                        <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                        Loading...
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('styles')
        <style>
            /* Keep Transaction Detail modal readable regardless of the application's theme. */
            #transactionDetailModal.transaction-detail-modal-shell .transaction-detail-modal-content {
                background: #ffffff !important;
                color: #1e293b !important;
                border: 1px solid #dee2e6 !important;
                box-shadow: 0 1rem 3rem rgba(15, 23, 42, .20);
            }

            #transactionDetailModal.transaction-detail-modal-shell .transaction-detail-modal-header {
                background: #ffffff !important;
                color: #0f172a !important;
                border-bottom: 1px solid #e2e8f0 !important;
            }

            #transactionDetailModal.transaction-detail-modal-shell .transaction-detail-modal-title {
                color: #0f172a !important;
            }

            #transactionDetailModal.transaction-detail-modal-shell .transaction-detail-modal-subtitle {
                color: #64748b !important;
            }

            #transactionDetailModal.transaction-detail-modal-shell .transaction-detail-modal-body {
                background: #f8fafc !important;
                color: #1e293b !important;
            }

            #transactionDetailModal.transaction-detail-modal-shell .btn-close {
                opacity: .65;
            }

            #transactionDetailModal.transaction-detail-modal-shell .btn-close:hover {
                opacity: 1;
            }

            .revision-required-row {
                background: #fffaf0 !important;
            }

            .revision-required-row:hover {
                background: #fff3cd !important;
            }

            .revision-required-row.table-primary {
                background: #e7f1ff !important;
            }
        </style>
    @endpush
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                let id = null;
                let selectedEmpFormId = '';
                let selectedStatus = '';
                let selectedWorkflowId = '';
                const currentEmpFormId = @json(auth()->user()->EmpFormID ?? '');
                const rows = document.querySelectorAll('.employee-equipment-row');
                const u = document.getElementById('btnUpdate');
                const d = document.getElementById('btnDelete');
                const approvalButton = document.getElementById('btnRequestApproval');
                const detailButton = document.getElementById('btnDetail');
                const approvalId = document.getElementById('approvalTransactionId');

                function refreshActions() {
                    const isRequester = selectedEmpFormId !== '' && selectedEmpFormId === currentEmpFormId;
                    const canModify = isRequester && ['DRAFT', 'REVISION_REQUIRED'].includes(selectedStatus);
                    const canRequestApproval = isRequester && ['DRAFT', 'REVISION_REQUIRED'].includes(selectedStatus);

                    u.disabled = !canModify;
                    d.disabled = !canModify;
                    approvalButton.disabled = !canRequestApproval;
                    detailButton.disabled = selectedWorkflowId === '';

                    if (selectedStatus === 'REVISION_REQUIRED') {
                        approvalButton.innerHTML = '<i class="bi bi-arrow-repeat me-1"></i>Request Approval Again';
                        approvalButton.classList.remove('btn-success');
                        approvalButton.classList.add('btn-warning', 'text-dark');
                    } else {
                        approvalButton.innerHTML = '<i class="bi bi-send me-1"></i>Request Approval';
                        approvalButton.classList.remove('btn-warning', 'text-dark');
                        approvalButton.classList.add('btn-success');
                    }
                }

                rows.forEach(function(row) {
                    row.addEventListener('click', function() {
                        rows.forEach(function(x) {
                            x.classList.remove('table-primary');
                            const icon = x.querySelector('.row-selector i');
                            if (icon) icon.className = 'bi bi-circle-fill text-secondary';
                        });

                        this.classList.add('table-primary');
                        const icon = this.querySelector('.row-selector i');
                        if (icon) icon.className = 'bi bi-check-circle-fill text-primary';

                        id = this.dataset.id || '';
                        selectedEmpFormId = this.dataset.empFormId || '';
                        selectedStatus = (this.dataset.status || 'DRAFT').toUpperCase();
                        selectedWorkflowId = this.dataset.workflowId || '';
                        approvalId.value = id;
                        refreshActions();
                    });
                });

                u.onclick = function() {
                    if (!id || u.disabled) return;
                    location.href = "{{ url('/employee-equipment') }}/" + id + '/edit';
                };

                const detailModalElement = document.getElementById('transactionDetailModal');
                const detailModalBody = document.getElementById('transactionDetailModalBody');
                const detailModalSubtitle = document.getElementById('transactionDetailModalSubtitle');
                const detailModal = detailModalElement && window.bootstrap ?
                    window.bootstrap.Modal.getOrCreateInstance(detailModalElement) :
                    null;

                detailButton.onclick = async function() {
                    if (!selectedWorkflowId || detailButton.disabled || !detailModal) return;

                    detailModalBody.innerHTML = `
            <div class="d-flex justify-content-center align-items-center py-5 text-muted">
                <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                Loading transaction detail...
            </div>`;
                    detailModalSubtitle.textContent = id || '';
                    detailModal.show();

                    try {
                        const response = await fetch("{{ url('/workflow/detail-modal') }}/" +
                            encodeURIComponent(selectedWorkflowId), {
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'Accept': 'text/html'
                                },
                                credentials: 'same-origin'
                            });

                        if (!response.ok) {
                            throw new Error(response.status === 403 ?
                                'You do not have permission to view this transaction.' :
                                'Failed to load transaction detail.');
                        }

                        detailModalBody.innerHTML = await response.text();
                    } catch (error) {
                        detailModalBody.innerHTML = `
                <div class="p-4">
                    <div class="alert alert-danger mb-0">
                        <i class="bi bi-exclamation-triangle me-2"></i>${escapeHtml(error.message)}
                    </div>
                </div>`;
                    }
                };

                function escapeHtml(value) {
                    const div = document.createElement('div');
                    div.textContent = value ?? '';
                    return div.innerHTML;
                }

                d.onclick = function() {
                    if (!id || d.disabled) return;
                    if (!confirm('Are you sure you want to delete this Employee Equipment Request?')) return;
                    const f = document.createElement('form');
                    f.method = 'POST';
                    f.action = "{{ url('/employee-equipment') }}/" + id;
                    f.innerHTML =
                        '<input type="hidden" name="_token" value="{{ csrf_token() }}"><input type="hidden" name="_method" value="DELETE">';
                    document.body.appendChild(f);
                    f.submit();
                };
            });
        </script>
    @endpush
@endsection
