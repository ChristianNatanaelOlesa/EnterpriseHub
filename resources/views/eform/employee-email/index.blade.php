@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        {{-- ========================================================= --}}
        {{-- HEADER --}}
        {{-- ========================================================= --}}
        <div class="mb-4">
            <h4 class="mb-1">
                Employee Email Request
            </h4>
            <div class="text-muted">
                Employee Email Request List
            </div>
        </div>
        {{-- ========================================================= --}}
        {{-- SUCCESS MESSAGE --}}
        {{-- ========================================================= --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-1"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert">
                </button>
            </div>
        @endif
        {{-- ========================================================= --}}
        {{-- ERROR MESSAGE --}}
        {{-- ========================================================= --}}
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle me-1"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert">
                </button>
            </div>
        @endif
        {{-- ========================================================= --}}
        {{-- SEARCH --}}
        {{-- ========================================================= --}}
        <div class="card mb-3">
            <div class="card-body">
                <form method="GET" action="{{ route('employee-email.index') }}">
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" name="search" class="form-control" value="{{ request('search') }}"
                            placeholder="Search anything...">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search me-1"></i>
                            Search
                        </button>
                    </div>
                    <div class="form-text mt-2">
                        Search berdasarkan data apa saja yang tersedia pada Employee Email,
                        termasuk Employee Email ID, Employee Form ID, user, email,
                        request type, email type, purpose, notes, status, dan tanggal.
                    </div>
                </form>
            </div>
        </div>
        <style>
            .badge-email-personal {
                background-color: #7c3aed;
                color: #ffffff;
            }

            .badge-status-draft {
                background-color: #6c757d;
                color: #ffffff;
            }

            .badge-status-waiting {
                background-color: #f59e0b;
                color: #212529;
            }

            .badge-status-revision {
                background-color: #0891b2;
                color: #ffffff;
            }

            .badge-status-approved {
                background-color: #15803d;
                color: #ffffff;
            }

            .badge-status-rejected {
                background-color: #dc2626;
                color: #ffffff;
            }

            .badge-status-cancelled {
                background-color: #dc2626;
                color: #ffffff;
            }

            .employee-email-table-wrapper {
                position: relative;
                width: 100%;
                max-width: 100%;
                height: auto;
                max-height: none;
                overflow: visible;
            }

            .employee-email-table-wrapper .dropdown-menu {
                z-index: 1080;
            }

            .employee-email-table-wrapper table {
                width: 100%;
                min-width: 1200px;
                margin-bottom: 0;
                table-layout: auto;
            }

            .employee-email-table-wrapper th,
            .employee-email-table-wrapper td {
                vertical-align: middle;
                white-space: nowrap;
            }
        </style>
        {{-- ========================================================= --}}
        {{-- TABLE --}}
        {{-- ========================================================= --}}
        <div class="card">
            <div class="card-body">
                <div class="employee-email-table-wrapper">
                    <table class="table table-bordered table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" style="width: 60px;">
                                    #
                                </th>
                                <th>
                                    Employee Email ID
                                </th>
                                <th>
                                    Employee ID
                                </th>
                                <th>
                                    Req User
                                </th>
                                <th>
                                    Email Type
                                </th>
                                <th>
                                    Email
                                </th>
                                <th>
                                    Request Type
                                </th>
                                <th>
                                    Date From
                                </th>
                                <th>
                                    Date Until
                                </th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Given</th>
                                <th class="text-center">Take Out</th>
                                <th class="text-center" style="width: 190px;">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($employeeEmails as $index => $email)
                                <tr class="employee-email-row" data-id="{{ $email->EmpEmailID }}"
                                    data-emp-form-id="{{ $email->EmpFormID }}"
                                    data-status="{{ strtoupper((string) ($email->Status ?? 'DRAFT')) }}"
                                    data-workflow-instance-id="{{ $workflowInstances[$email->EmpEmailID]->WorkflowInstanceID ?? '' }}"
                                    data-employee-email-detail="{{ json_encode($employeeEmailDetails[$email->EmpEmailID] ?? []) }}"
                                    style="cursor: pointer;">
                                    {{-- Selection --}}
                                    <td class="text-center">
                                        <span class="row-selector" data-id="{{ $email->EmpEmailID }}">
                                            <i class="bi bi-circle-fill" style="font-size: 13px;">
                                            </i>
                                        </span>
                                    </td>
                                    {{-- Employee Email ID --}}
                                    <td>
                                        <a href="#"
                                            class="employee-email-detail-link fw-semibold text-primary text-decoration-none"
                                            data-id="{{ $email->EmpEmailID }}"
                                            aria-label="Lihat detail Employee Email {{ $email->EmpEmailID }}">
                                            {{ $email->EmpEmailID }}
                                        </a>
                                    </td>
                                    {{-- Employee Form ID --}}
                                    <td>
                                        {{ $email->EmpFormID }}
                                    </td>
                                    {{-- Req User --}}
                                    <td>
                                        {{ $email->ReqUser ?: $email->EmpFormID }}
                                    </td>
                                    {{-- Email Type --}}
                                    <td>
                                        @if (strtoupper((string) $email->EmailType) === 'PERSONAL')
                                            <span class="badge badge-email-personal">Personal</span>
                                        @elseif (strtoupper((string) $email->EmailType) === 'CORPORATE')
                                            <span class="badge bg-primary">Corporate</span>
                                        @else
                                            {{ $email->EmailType ?: '-' }}
                                        @endif
                                    </td>
                                    {{-- Email --}}
                                    <td>
                                        {{ $email->Email ?: '-' }}
                                    </td>
                                    {{-- Request Type --}}
                                    <td>
                                        {{ $email->ReqType ?: '-' }}
                                    </td>
                                    {{-- Date From --}}
                                    <td>
                                        @if ($email->DateFrom)
                                            {{ \Carbon\Carbon::parse($email->DateFrom)->format('d M Y') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    {{-- Date Until --}}
                                    <td>
                                        @if ($email->DateUntil)
                                            @if (\Carbon\Carbon::parse($email->DateUntil)->format('Y-m-d') === '1900-01-01')
                                                -
                                            @else
                                                {{ \Carbon\Carbon::parse($email->DateUntil)->format('d M Y') }}
                                            @endif
                                        @else
                                            -
                                        @endif
                                    </td>
                                    {{-- Status --}}
                                    <td class="text-center">
                                        @php
                                            $status = strtoupper(trim((string) ($email->Status ?? 'DRAFT')));
                                            $statusBadges = [
                                                'DRAFT' => 'badge-status-draft',
                                                'PROGRESS' => 'badge-status-waiting',
                                                'WAITING_APPROVAL' => 'badge-status-waiting',
                                                'REVISION_REQUIRED' => 'badge-status-revision',
                                                'APPROVED' => 'badge-status-approved',
                                                'COMPLETED' => 'badge-status-approved',
                                                'REJECTED' => 'badge-status-rejected',
                                                'CANCELLED' => 'badge-status-cancelled',
                                            ];
                                            $badgeClass = $statusBadges[$status] ?? 'bg-dark';
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">
                                            {{ $status ?: 'DRAFT' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge {{ $email->IsGiven ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $email->IsGiven ? 'Given' : 'Not Given' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span
                                            class="badge {{ $email->IsTakeOut ? 'bg-warning text-dark' : 'bg-secondary' }}">
                                            {{ $email->IsTakeOut ? 'Taken Out' : 'Not Taken Out' }}
                                        </span>
                                    </td>
                                    {{-- Per-row actions --}}
                                    <td class="text-center">
                                        @php
                                            $canFulfillRow =
                                                in_array(
                                                    strtoupper(trim((string) ($email->Status ?? 'DRAFT'))),
                                                    ['APPROVED', 'COMPLETED'],
                                                    true,
                                                ) &&
                                                auth()->user() instanceof \App\Models\Security\ScUser &&
                                                app(\App\Services\EForm\EmpEmailService::class)->canFulfill(
                                                    auth()->user(),
                                                    $email,
                                                );
                                        @endphp
                                        @if ($canFulfillRow && \App\Support\Permission::can('IT Fulfillment', 'employee-email.index'))
                                            <button type="button"
                                                class="btn btn-sm btn-outline-primary mb-1 btn-it-fulfillment"
                                                data-bs-toggle="modal" data-bs-target="#itFulfillmentModal"
                                                data-action="{{ route('employee-email.fulfillment', $email->EmpEmailID) }}"
                                                data-id="{{ $email->EmpEmailID }}" data-email="{{ $email->Email }}"
                                                data-email-type="{{ $email->EmailType }}"
                                                data-is-given="{{ (int) $email->IsGiven }}"
                                                data-given-date="{{ $email->GivenDate && \Carbon\Carbon::parse($email->GivenDate)->format('Y-m-d') !== '1900-01-01' ? \Carbon\Carbon::parse($email->GivenDate)->format('Y-m-d') : '' }}"
                                                data-given-note="{{ $email->GivenNote === '-' ? '' : $email->GivenNote }}"
                                                data-is-take-out="{{ (int) $email->IsTakeOut }}"
                                                data-take-out-date="{{ $email->TakeOutDate && \Carbon\Carbon::parse($email->TakeOutDate)->format('Y-m-d') !== '1900-01-01' ? \Carbon\Carbon::parse($email->TakeOutDate)->format('Y-m-d') : '' }}"
                                                data-take-out-note="{{ $email->TakeOutNote === '-' ? '' : $email->TakeOutNote }}">
                                                <i class="bi bi-pc-display me-1"></i>IT Fulfillment
                                            </button>
                                        @endif
                                        @php
                                            $rowStatus = strtoupper(trim((string) ($email->Status ?? 'DRAFT')));
                                            $isRequester =
                                                (string) $email->EmpFormID ===
                                                (string) (auth()->user()->EmpFormID ?? '');
                                            $canEditRow =
                                                $isRequester &&
                                                in_array($rowStatus, ['DRAFT', 'REJECTED', 'REVISION_REQUIRED'], true);
                                            $rowWorkflowInstanceId =
                                                $workflowInstances[$email->EmpEmailID]->WorkflowInstanceID ?? null;
                                            $rowWorkflow = $workflowInstances[$email->EmpEmailID] ?? null;

                                            $rowWorkflowInstanceId = $rowWorkflow?->WorkflowInstanceID;

                                            $hasApproverAction = $rowWorkflow
                                                ? $rowWorkflow->steps->contains(function ($step) {
                                                    $status = strtoupper(trim((string) $step->Status));
                                                    $action = strtoupper(trim((string) $step->Action));

                                                    return in_array(
                                                        $status,
                                                        ['APPROVED', 'REJECTED', 'REVISION_REQUESTED'],
                                                        true,
                                                    ) || !in_array($action, ['', '-'], true);
                                                })
                                                : false;

                                            $canCancelRow =
                                                $isRequester &&
                                                $rowStatus === 'WAITING_APPROVAL' &&
                                                !empty($rowWorkflowInstanceId) &&
                                                !$hasApproverAction;
                                        @endphp
                                        @if ($canEditRow || $canCancelRow)
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                                    type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Actions
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    @if ($canEditRow)
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ url('/employee-email/' . $email->EmpEmailID . '/edit') }}">
                                                                <i class="bi bi-pencil me-2"></i>Update
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <form method="POST"
                                                                action="{{ url('/employee-email/' . $email->EmpEmailID) }}"
                                                                onsubmit="return confirm('Yakin ingin menghapus Employee Email ini?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item text-danger">
                                                                    <i class="bi bi-trash me-2"></i>Delete
                                                                </button>
                                                            </form>
                                                        </li>
                                                    @endif
                                                    @if ($canCancelRow)
                                                        @canEdit('employee-email.index')
                                                        @if ($canEditRow)
                                                            <li>
                                                                <hr class="dropdown-divider">
                                                            </li>
                                                        @endif
                                                        <li>
                                                            <form method="POST"
                                                                action="{{ route('workflow.cancel', ['instance' => $rowWorkflowInstanceId]) }}"
                                                                onsubmit="return confirm('Yakin ingin membatalkan pengajuan Employee Email ini?')">
                                                                @csrf
                                                                <button type="submit" class="dropdown-item text-danger">
                                                                    <i class="bi bi-x-circle me-2"></i>Cancel
                                                                </button>
                                                            </form>
                                                        </li>
                                                        @endcanEdit
                                                    @endif
                                                </ul>
                                            </div>
                                        @elseif (!$canFulfillRow)
                                            <button type="button" class="btn btn-sm btn-outline-secondary" disabled
                                                title="Tidak ada tindakan yang tersedia">
                                                Actions <i class="bi bi-chevron-down"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="13" class="text-center text-muted py-4">
                                        <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                        No Employee Email Request found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{-- ========================================================= --}}
                {{-- PAGINATION --}}
                {{-- ========================================================= --}}
                @if ($employeeEmails->hasPages())
                    <div class="mt-3">
                        {{ $employeeEmails->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
        {{-- ========================================================= --}}
        {{-- PAGE ACTIONS --}}
        {{-- ========================================================= --}}
        <div class="d-flex justify-content-end gap-2 mt-3">
            <a href="{{ route('employee-email.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i>Create
            </a>
            @canEdit('employee-email.index')
            <form method="POST" action="{{ route('workflow.request-approval') }}" id="requestApprovalForm"
                class="d-inline">
                @csrf
                <input type="hidden" name="process_id" value="EMPLOYEE_EMAIL">
                <input type="hidden" name="module" value="EMPLOYEE_EMAIL">
                <input type="hidden" name="transaction_id" id="approvalTransactionId">
                <button type="submit" id="btnRequestApproval" class="btn btn-success" disabled>
                    <i class="bi bi-send me-1"></i>Request Approval
                </button>
            </form>
            @endcanEdit
        </div>
    </div>
    {{-- ============================================================= --}}
    {{-- JAVASCRIPT --}}
    {{-- ============================================================= --}}
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const detailLinks = document.querySelectorAll(
                    '.employee-email-detail-link'
                );

                const modalElement = document.getElementById(
                    'transactionRowDetailModal'
                );

                const content = document.getElementById(
                    'transactionRowDetailContent'
                );

                if (!modalElement || !content) return;

                function addSection(title) {
                    const heading = document.createElement('div');
                    heading.className = 'col-12 fw-semibold mt-3 mb-2';
                    heading.textContent = title;
                    content.appendChild(heading);
                }

                function addField(label, value) {
                    const dt = document.createElement('dt');
                    dt.className = 'col-sm-4 text-muted mb-2';
                    dt.textContent = label;

                    const dd = document.createElement('dd');
                    dd.className = 'col-sm-8 mb-2 text-break';
                    dd.textContent = value ?? '-';

                    content.append(dt, dd);
                }

                function addTimeline(timeline) {
                    if (!timeline.length) {
                        const empty = document.createElement('div');
                        empty.className = 'col-12 text-muted mb-2';
                        empty.textContent = 'Belum ada data approval timeline.';
                        content.appendChild(empty);
                        return;
                    }

                    let currentRevision = null;

                    timeline.forEach(function(step) {
                        if (currentRevision !== step.revision) {
                            currentRevision = step.revision;

                            const revision = document.createElement('div');
                            revision.className = 'col-12 fw-semibold mt-2 mb-1';
                            revision.textContent = 'Revision ' + currentRevision;
                            content.appendChild(revision);
                        }

                        const wrapper = document.createElement('div');
                        wrapper.className = 'col-12 mb-2';

                        const card = document.createElement('div');
                        card.className = 'border rounded p-3';

                        const header = document.createElement('div');
                        header.className =
                            'd-flex justify-content-between flex-wrap gap-2';

                        const title = document.createElement('strong');
                        title.textContent =
                            step.stepNo + '. ' + step.stepName;

                        const badge = document.createElement('span');
                        badge.className = 'badge';

                        const status = (step.status || 'PENDING').toUpperCase();

                        const statusClasses = {
                            APPROVED: 'text-bg-success',
                            ACTIVE: 'text-bg-warning',
                            REVISION_REQUESTED: 'text-bg-warning',
                            REJECTED: 'text-bg-danger',
                            SKIPPED: 'text-bg-secondary',
                            PENDING: 'text-bg-light'
                        };

                        badge.classList.add(
                            statusClasses[status] || 'text-bg-secondary'
                        );

                        badge.textContent = status === 'ACTIVE' ?
                            'Waiting Approval' :
                            status.replaceAll('_', ' ');

                        header.append(title, badge);
                        card.appendChild(header);

                        const approver = document.createElement('div');
                        approver.className = 'small text-muted mt-2';
                        approver.textContent = 'Approver: ' + (step.approver || '-');
                        card.appendChild(approver);

                        if (step.completedAt) {
                            const completed = document.createElement('div');
                            completed.className = 'small text-muted mt-1';
                            completed.textContent =
                                'Action Date: ' + step.completedAt;
                            card.appendChild(completed);
                        }

                        if (step.comments) {
                            const comments = document.createElement('div');
                            comments.className = 'mt-2';
                            comments.textContent = 'Comment: ' + step.comments;
                            card.appendChild(comments);
                        }

                        if (step.isSkipped && step.skipReason) {
                            const skipped = document.createElement('div');
                            skipped.className = 'small text-muted mt-1';
                            skipped.textContent = 'Skip Reason: ' + step.skipReason;
                            card.appendChild(skipped);
                        }

                        wrapper.appendChild(card);
                        content.appendChild(wrapper);
                    });
                }

                detailLinks.forEach(function(link) {
                    link.addEventListener('click', function(event) {
                        event.preventDefault();
                        event.stopPropagation();

                        const row = link.closest('tr');
                        if (!row) return;

                        content.replaceChildren();

                        const headers = Array.from(
                            row.closest('table').querySelectorAll('thead th')
                        );

                        const cells = Array.from(row.querySelectorAll('td'));

                        addSection('Transaction Information');

                        headers.forEach(function(header, index) {
                            if (!cells[index]) return;

                            const label = header.textContent.trim();

                            if (!label || label === '#' || label === 'Actions') {
                                return;
                            }

                            addField(
                                label,
                                cells[index].innerText.trim() || '-'
                            );
                        });

                        let detail = {};

                        try {
                            detail = JSON.parse(
                                row.dataset.employeeEmailDetail || '{}'
                            );
                        } catch (error) {
                            console.error(
                                'Gagal membaca detail Employee Email:',
                                error
                            );
                        }

                        addSection('Access Information');
                        addField('Given Date', detail.givenDate);
                        addField('Given Note', detail.givenNote);
                        addField('Take Out Date', detail.takeOutDate);
                        addField('Take Out Note', detail.takeOutNote);

                        addSection('Approval Timeline');
                        addTimeline(
                            Array.isArray(detail.timeline) ?
                            detail.timeline : []
                        );

                        bootstrap.Modal
                            .getOrCreateInstance(modalElement)
                            .show();
                    });
                });
            });
        </script>
    @endpush
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const rows = document.querySelectorAll('.employee-email-row');
            const btnRequestApproval = document.getElementById('btnRequestApproval');
            const approvalTransactionId = document.getElementById('approvalTransactionId');
            const currentUser = @json(auth()->user()->EmpFormID ?? '');

            function selectRow(row) {
                rows.forEach(function(item) {
                    item.classList.remove('table-primary');
                    const icon = item.querySelector('.row-selector i');
                    if (icon) icon.className = 'bi bi-circle-fill';
                });
                row.classList.add('table-primary');
                const icon = row.querySelector('.row-selector i');
                if (icon) icon.className = 'bi bi-check-circle-fill';
                const id = row.dataset.id || '';
                const status = (row.dataset.status || 'DRAFT').toUpperCase();
                const requester = row.dataset.empFormId || '';
                const isOwner = requester === currentUser;
                if (btnRequestApproval && approvalTransactionId) {
                    approvalTransactionId.value = id;
                    btnRequestApproval.disabled = !(
                        isOwner && id && ['DRAFT', 'REVISION_REQUIRED'].includes(status)
                    );
                }
            }
            rows.forEach(function(row) {
                row.addEventListener('click', function(event) {
                    // Klik detail ID atau menu tindakan tidak memilih baris.
                    if (event.target.closest(
                            '.employee-email-detail-link, .dropdown, form, button, a')) {
                        return;
                    }
                    selectRow(row);
                });
            });
        });
    </script>
    <div class="modal fade" id="itFulfillmentModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <form method="POST" id="itFulfillmentForm" action="">
                @csrf
                @method('PUT')
                <input type="hidden" name="IsGiven" id="fulfillmentIsGiven" value="0">
                <input type="hidden" name="IsTakeOut" id="fulfillmentIsTakeOut" value="0">
                <div class="modal-content bg-white text-dark">
                    <div class="modal-header">
                        <h5 class="modal-title">IT Fulfillment — <span id="fulfillmentTransactionId"></span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="fulfillmentEmail" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="fulfillmentEmail" name="Email"
                                maxlength="255" required>
                            <div class="form-text">Untuk Personal Email, ganti placeholder dengan alamat email yang valid
                                sebelum menandai Given.</div>
                        </div>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="fulfillmentGivenToggle">
                            <label class="form-check-label fw-semibold" for="fulfillmentGivenToggle">Email sudah diberikan
                                (Given)</label>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-4"><label for="fulfillmentGivenDate" class="form-label">Given
                                    Date</label><input type="date" class="form-control" name="GivenDate"
                                    id="fulfillmentGivenDate"></div>
                            <div class="col-md-8"><label for="fulfillmentGivenNote" class="form-label">Given
                                    Note</label><input type="text" class="form-control" name="GivenNote"
                                    id="fulfillmentGivenNote" maxlength="1000"></div>
                        </div>
                        <hr>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="fulfillmentTakeOutToggle">
                            <label class="form-check-label fw-semibold" for="fulfillmentTakeOutToggle">Akses email sudah
                                dicabut (Take Out)</label>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-4"><label for="fulfillmentTakeOutDate" class="form-label">Take Out
                                    Date</label><input type="date" class="form-control" name="TakeOutDate"
                                    id="fulfillmentTakeOutDate"></div>
                            <div class="col-md-8"><label for="fulfillmentTakeOutNote" class="form-label">Take Out
                                    Note</label><input type="text" class="form-control" name="TakeOutNote"
                                    id="fulfillmentTakeOutNote" maxlength="1000"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Save
                            Fulfillment</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('itFulfillmentModal');
            if (!modal) return;
            const form = document.getElementById('itFulfillmentForm');
            const email = document.getElementById('fulfillmentEmail');
            const givenToggle = document.getElementById('fulfillmentGivenToggle');
            const takeOutToggle = document.getElementById('fulfillmentTakeOutToggle');
            const givenHidden = document.getElementById('fulfillmentIsGiven');
            const takeOutHidden = document.getElementById('fulfillmentIsTakeOut');
            const givenDate = document.getElementById('fulfillmentGivenDate');
            const givenNote = document.getElementById('fulfillmentGivenNote');
            const takeOutDate = document.getElementById('fulfillmentTakeOutDate');
            const takeOutNote = document.getElementById('fulfillmentTakeOutNote');
            let lockedGiven = false;
            let lockedTakeOut = false;

            function syncFields() {
                givenHidden.value = givenToggle.checked ? '1' : '0';
                takeOutHidden.value = takeOutToggle.checked ? '1' : '0';
                givenToggle.disabled = lockedGiven;
                takeOutToggle.disabled = lockedTakeOut || !givenToggle.checked;
                givenDate.disabled = lockedTakeOut;
                givenNote.disabled = lockedTakeOut;
                takeOutDate.disabled = !givenToggle.checked;
                takeOutNote.disabled = !givenToggle.checked;
                if (!givenToggle.checked) takeOutToggle.checked = false;
                takeOutHidden.value = takeOutToggle.checked ? '1' : '0';
                email.readOnly = email.dataset.corporate === '1';
            }
            modal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                if (!button) return;
                form.action = button.dataset.action;
                document.getElementById('fulfillmentTransactionId').textContent = button.dataset.id || '';
                email.value = button.dataset.email || '';
                email.dataset.corporate = (button.dataset.emailType || '').toLowerCase() === 'corporate' ?
                    '1' : '0';
                givenToggle.checked = button.dataset.isGiven === '1';
                takeOutToggle.checked = button.dataset.isTakeOut === '1';
                givenDate.value = button.dataset.givenDate || '';
                givenNote.value = button.dataset.givenNote || '';
                takeOutDate.value = button.dataset.takeOutDate || '';
                takeOutNote.value = button.dataset.takeOutNote || '';
                lockedGiven = button.dataset.isTakeOut === '1';
                lockedTakeOut = button.dataset.isTakeOut === '1';
                syncFields();
            });
            givenToggle.addEventListener('change', syncFields);
            takeOutToggle.addEventListener('change', syncFields);
            form.addEventListener('submit', function() {
                givenHidden.value = givenToggle.checked ? '1' : '0';
                takeOutHidden.value = takeOutToggle.checked ? '1' : '0';
            });
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
@endsection
