@extends('layouts.app')

@section('title', 'Workflow Review')

@section('content')
    <style>
        .workflow-review-page .card {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(15, 23, 42, .04);
        }

        .workflow-review-page .card-header {
            background: #f8fafc !important;
            color: #1e293b;
            border-bottom: 1px solid #e5e7eb;
        }

        .workflow-review-page .transaction-value {
            color: #1e293b;
        }

        .workflow-review-page .timeline-item {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            color: #334155;
            margin-bottom: 8px;
            padding: 12px 14px;
        }

        .workflow-review-page .timeline-item.active {
            background: #fffbeb;
            border-color: #f4d06f;
        }

        .workflow-review-page .timeline-item.approved {
            background: #f0fdf4;
            border-color: #bbf7d0;
        }

        .workflow-review-page .timeline-item.rejected {
            background: #fef2f2;
            border-color: #fecaca;
        }

        .workflow-review-page .timeline-item.revision {
            background: #fff7ed;
            border-color: #fed7aa;
        }

        .workflow-review-page .timeline-step-title {
            color: #1e293b;
            font-weight: 600;
        }

        .workflow-review-page .timeline-approver {
            color: #64748b;
        }

        .workflow-review-page .status-badge {
            display: inline-flex;
            align-items: center;
            border-radius: 999px;
            padding: .3rem .6rem;
            font-size: .72rem;
            font-weight: 600;
            white-space: nowrap;
        }

        .workflow-review-page .status-waiting {
            background: #fff7d6;
            color: #8a6200;
            border: 1px solid #f6d878;
        }

        .workflow-review-page .status-approved {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .workflow-review-page .status-revision {
            background: #ffedd5;
            color: #9a3412;
            border: 1px solid #fed7aa;
        }

        .workflow-review-page .status-rejected {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .workflow-review-page .status-skipped {
            background: #f1f5f9;
            color: #475569;
            border: 1px solid #cbd5e1;
        }

        .workflow-review-page .status-pending {
            background: #f8fafc;
            color: #64748b;
            border: 1px solid #e2e8f0;
        }

        .workflow-review-page .action-alert {
            display: block;
            position: relative;
            width: 100%;
            box-sizing: border-box;
            margin: 0 0 1rem;
            padding: 0.85rem 1rem;
            overflow-wrap: anywhere;
            background: #eff6ff !important;
            border: 1px solid #93c5fd !important;
            color: #1e3a8a !important;
            border-radius: 10px;
        }

        .workflow-review-page .no-action-alert {
            display: flex;
            align-items: flex-start;
            gap: .75rem;
            background: #f8fafc !important;
            border: 1px solid #cbd5e1 !important;
            color: #334155 !important;
            border-radius: 10px;
            padding: .85rem 1rem;
        }

        .workflow-review-page .no-action-alert .alert-icon {
            color: #64748b;
            font-size: 1.05rem;
        }

        .workflow-review-page .no-action-alert strong {
            color: #1e293b;
        }

        /* Workflow action modals: always use a light/high-contrast theme. */
        .workflow-action-modal .modal-content {
            background: #ffffff !important;
            color: #1e293b !important;
            border: 1px solid #dbe3ee !important;
            border-radius: 10px !important;
            box-shadow: 0 16px 40px rgba(15, 23, 42, .18) !important;
        }

        .workflow-action-modal .modal-header {
            background: #ffffff !important;
            color: #1e293b !important;
            border-bottom: 1px solid #e2e8f0 !important;
        }

        .workflow-action-modal .modal-title {
            color: #1e293b !important;
            font-weight: 600;
        }

        .workflow-action-modal .modal-body {
            background: #ffffff !important;
            color: #334155 !important;
        }

        .workflow-action-modal .modal-footer {
            background: #ffffff !important;
            border-top: 1px solid #e2e8f0 !important;
        }

        .workflow-action-modal .form-label {
            color: #334155 !important;
            font-weight: 500;
        }

        .workflow-action-modal .form-control {
            background: #ffffff !important;
            color: #1e293b !important;
            border: 1px solid #cbd5e1 !important;
        }

        .workflow-action-modal .form-control::placeholder {
            color: #94a3b8 !important;
            opacity: 1 !important;
        }

        .workflow-action-modal .form-control:focus {
            background: #ffffff !important;
            color: #1e293b !important;
            border-color: #86b7fe !important;
            box-shadow: 0 0 0 .2rem rgba(13, 110, 253, .15) !important;
        }

        .workflow-action-modal .btn-close {
            opacity: .65 !important;
        }
    </style>
    <div class="container-fluid workflow-review-page">
        <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-3">
            <div>
                <h4 class="mb-1">Workflow Review</h4>
                <div class="text-muted small">{{ $workflow->WorkflowInstanceID }}</div>
            </div>
            <a href="{{ route('workflow.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i>Back to My Approval
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row g-3">
            <div class="col-lg-8">
                <div class="card mb-3">
                    <div class="card-header bg-white"><strong>Transaction</strong></div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="text-muted small">Process</div>
                                <strong>{{ $workflow->process?->Process ?? $workflow->ProcessID }}</strong>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="text-muted small">Module</div><strong>{{ $workflow->Module }}</strong>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="text-muted small">Transaction ID</div>
                                <strong>{{ $workflow->TransactionID }}</strong>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="text-muted small">Requester</div>
                                <strong>{{ $workflow->requester?->Username ?? $workflow->RequesterUserID }}</strong>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="text-muted small">Status</div><span
                                    class="badge text-bg-info">{{ $workflow->Status }}</span>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="text-muted small">Revision</div><strong>{{ $workflow->RevisionNo }}</strong>
                            </div>
                        </div>
                        @if ($transaction)
                            <hr>
                            <div class="text-muted small mb-2">Transaction Data</div>
                            <div class="row">
                                @foreach ($transaction->getAttributes() as $key => $value)
                                    @if (!in_array($key, ['InputDate', 'InputUser', 'ModifDate', 'ModifUser', 'DeletedDate', 'DeletedBy']))
                                        <div class="col-md-6 mb-2">
                                            <div class="small text-muted">{{ $key }}</div>
                                            <div class="text-break">
                                                {{ is_scalar($value) || $value === null ? $value ?? '-' : json_encode($value) }}
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card">
                    <div class="card-header bg-white"><strong>Approval Timeline</strong></div>
                    <div class="card-body">
                        @foreach ($workflow->steps->sortByDesc('RevisionNo')->groupBy('RevisionNo') as $revisionNo => $steps)
                            <div class="mb-4">
                                <div class="fw-semibold mb-2">Revision {{ $revisionNo }}</div>
                                <div class="timeline-list">
                                    @foreach ($steps->sortBy('StepNo') as $step)
                                        <div
                                            class="timeline-item @if ($step->Status === 'ACTIVE') active @elseif($step->Status === 'APPROVED') approved @elseif($step->Status === 'REVISION_REQUESTED') revision @elseif($step->Status === 'REJECTED') rejected @endif">
                                            <div class="d-flex justify-content-between gap-3">
                                                <div>
                                                    <div class="timeline-step-title">{{ $step->StepNo }}.
                                                        {{ $step->StepName }}</div>
                                                    <div class="small timeline-approver">
                                                        <i
                                                            class="bi bi-person me-1"></i>{{ $step->approver?->Username ?? ($step->ApproverUserID ? 'User ' . $step->ApproverUserID : 'Approver belum ditemukan') }}
                                                    </div>
                                                    @if ($step->Comments)
                                                        <div class="mt-1">{{ $step->Comments }}</div>
                                                    @endif
                                                    @if ($step->IsSkipped)
                                                        <div class="small text-muted mt-1">Skipped: {{ $step->SkipReason }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="text-end">
                                                    @if ($step->Status === 'APPROVED')
                                                        <span class="status-badge status-approved"><i
                                                                class="bi bi-check-circle me-1"></i>Approved</span>
                                                    @elseif($step->Status === 'ACTIVE')
                                                        <span class="status-badge status-waiting"><i
                                                                class="bi bi-hourglass-split me-1"></i>Waiting
                                                            Approval</span>
                                                    @elseif($step->Status === 'REVISION_REQUESTED')
                                                        <span class="status-badge status-revision"><i
                                                                class="bi bi-arrow-repeat me-1"></i>Revision</span>
                                                    @elseif($step->Status === 'REJECTED')
                                                        <span class="status-badge status-rejected"><i
                                                                class="bi bi-x-circle me-1"></i>Rejected</span>
                                                    @elseif($step->Status === 'SKIPPED')
                                                        <span class="status-badge status-skipped"><i
                                                                class="bi bi-skip-forward-circle me-1"></i>Skipped</span>
                                                    @else
                                                        <span
                                                            class="status-badge status-pending">{{ $step->Status }}</span>
                                                    @endif
                                                    @if ($step->CompletedAt)
                                                        <div class="small text-muted mt-1">
                                                            {{ $step->CompletedAt->format('d-m-Y H:i') }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header bg-white"><strong>Review Action</strong></div>
                    <div class="card-body">
                        @if ($canAct)
                            <div class="alert action-alert small">
                                <strong>{{ $activeStep->StepName }}</strong><br>
                                Anda adalah approver aktif untuk step ini.
                            </div>

                            <form method="POST" action="{{ route('workflow.approve', $workflow->WorkflowInstanceID) }}"
                                class="mb-2">
                                @csrf
                                <label class="form-label">Comment <span class="text-muted">(optional)</span></label>
                                <textarea name="Comments" class="form-control mb-2" rows="3" placeholder="Optional approval comment..."></textarea>
                                <button class="btn btn-success w-100" type="submit"><i
                                        class="bi bi-check-lg me-1"></i>Approve</button>
                            </form>

                            <button class="btn btn-warning w-100 mb-2" type="button" data-bs-toggle="modal"
                                data-bs-target="#revisionModal">
                                <i class="bi bi-arrow-repeat me-1"></i>Request Revision
                            </button>

                            <button class="btn btn-danger w-100" type="button" data-bs-toggle="modal"
                                data-bs-target="#rejectModal">
                                <i class="bi bi-x-lg me-1"></i>Reject
                            </button>
                        @else
                            <div class="no-action-alert mb-0">
                                <div class="alert-icon"><i class="bi bi-info-circle-fill"></i></div>
                                <div><strong>Tidak Ada Aksi Approval</strong>
                                    <div class="small mt-1">Anda tidak memiliki tindakan yang dapat diproses pada step aktif
                                        ini.</div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($canAct)
        <div class="modal fade workflow-action-modal" id="revisionModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" action="{{ route('workflow.revision', $workflow->WorkflowInstanceID) }}"
                    class="modal-content">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Request Revision</h5><button type="button" class="btn-close"
                            data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <label class="form-label">Reason <span class="text-danger">*</span></label>
                        <textarea name="Comments" class="form-control" rows="5" required
                            placeholder="Jelaskan data apa yang perlu diperbaiki..."></textarea>
                    </div>
                    <div class="modal-footer"><button type="button" class="btn btn-outline-secondary"
                            data-bs-dismiss="modal">Cancel</button><button class="btn btn-warning">Request
                            Revision</button></div>
                </form>
            </div>
        </div>
        <div class="modal fade workflow-action-modal" id="rejectModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" action="{{ route('workflow.reject', $workflow->WorkflowInstanceID) }}"
                    class="modal-content">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Reject Transaction</h5><button type="button" class="btn-close"
                            data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <label class="form-label">Reason <span class="text-danger">*</span></label>
                        <textarea name="Comments" class="form-control" rows="5" required placeholder="Jelaskan alasan reject..."></textarea>
                    </div>
                    <div class="modal-footer"><button type="button" class="btn btn-outline-secondary"
                            data-bs-dismiss="modal">Cancel</button><button class="btn btn-danger">Reject</button></div>
                </form>
            </div>
        </div>
    @endif
@endsection
