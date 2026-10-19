@php
    $status = strtoupper((string) ($workflow->Status ?? ''));
    $statusClass = match ($status) {
        'APPROVED' => 'success',
        'REJECTED' => 'danger',
        'WAITING_APPROVAL' => 'warning',
        'REVISION_REQUIRED', 'REVISION_REQUESTED' => 'warning',
        default => 'secondary',
    };
@endphp

<style>
    .transaction-detail-modal .detail-card {
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        background: #fff;
    }
    .transaction-detail-modal .detail-card-title {
        color: #1e293b;
        font-weight: 600;
    }
    .transaction-detail-modal .detail-label {
        color: #64748b;
        font-size: .78rem;
        margin-bottom: .15rem;
    }
    .transaction-detail-modal .detail-value {
        color: #1e293b;
        word-break: break-word;
    }
    .transaction-detail-modal .timeline-item {
        position: relative;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 12px 14px;
        margin-bottom: 10px;
        background: #fff;
    }
    .transaction-detail-modal .timeline-item.active { background:#fffbeb; border-color:#f4d06f; }
    .transaction-detail-modal .timeline-item.approved { background:#f0fdf4; border-color:#bbf7d0; }
    .transaction-detail-modal .timeline-item.rejected { background:#fef2f2; border-color:#fecaca; }
    .transaction-detail-modal .timeline-item.revision { background:#fff7ed; border-color:#fed7aa; }
    .transaction-detail-modal .timeline-title { color:#1e293b; font-weight:600; }
    .transaction-detail-modal .timeline-approver { color:#64748b; }
    .transaction-detail-modal .timeline-comment {
        margin-top: .55rem;
        padding: .6rem .75rem;
        border-left: 3px solid #cbd5e1;
        background: #f8fafc;
        color: #334155;
        border-radius: 0 6px 6px 0;
        white-space: pre-wrap;
    }
</style>

<div class="transaction-detail-modal p-3 p-md-4">
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-2 mb-3">
        <div>
            <div class="text-muted small">{{ $workflow->process?->Process ?? $workflow->ProcessID }}</div>
            <h5 class="mb-1">{{ $workflow->TransactionID }}</h5>
            <div class="small text-muted">{{ $workflow->Module }}</div>
        </div>
        <span class="badge text-bg-{{ $statusClass }} px-3 py-2">
            {{ str_replace('_', ' ', $status) }}
        </span>
    </div>

    <div class="detail-card p-3 mb-3">
        <div class="detail-card-title mb-3">
            <i class="bi bi-file-earmark-text me-1"></i> Transaction Information
        </div>
        <div class="row g-3">
            <div class="col-md-6">
                <div class="detail-label">Requester</div>
                <div class="detail-value">{{ $workflow->requester?->Username ?? $workflow->RequesterUserID }}</div>
            </div>
            <div class="col-md-6">
                <div class="detail-label">Workflow Status</div>
                <div class="detail-value">{{ str_replace('_', ' ', $status) }}</div>
            </div>
            <div class="col-md-6">
                <div class="detail-label">Started At</div>
                <div class="detail-value">{{ $workflow->StartedAt?->format('d M Y H:i') ?? '-' }}</div>
            </div>
            <div class="col-md-6">
                <div class="detail-label">Completed At</div>
                <div class="detail-value">{{ $workflow->CompletedAt?->format('d M Y H:i') ?? '-' }}</div>
            </div>
        </div>
    </div>

    @foreach($sections as $section)
        <div class="detail-card p-3 mb-3">
            <div class="detail-card-title mb-3">{{ $section['title'] ?? 'Transaction Details' }}</div>
            <div class="row g-3">
                @foreach(($section['fields'] ?? []) as $field)
                    <div class="col-md-6">
                        <div class="detail-label">{{ $field['label'] ?? '-' }}</div>
                        <div class="detail-value">{{ is_scalar($field['value'] ?? null) || ($field['value'] ?? null) === null ? (($field['value'] ?? null) ?? '-') : json_encode($field['value'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach

    <div class="detail-card p-3">
        <div class="detail-card-title mb-3">
            <i class="bi bi-diagram-3 me-1"></i> Approval Timeline
        </div>

        @forelse($workflow->steps->sortByDesc('RevisionNo')->groupBy('RevisionNo') as $revisionNo => $steps)
            <div class="mb-3">
                <div class="small fw-semibold text-muted mb-2">Revision {{ $revisionNo }}</div>

                @foreach($steps->sortBy('StepNo') as $step)
                    @php
                        $itemClass = match ($step->Status) {
                            'ACTIVE' => 'active',
                            'APPROVED' => 'approved',
                            'REJECTED' => 'rejected',
                            'REVISION_REQUESTED' => 'revision',
                            default => '',
                        };
                        $stepStatusClass = match ($step->Status) {
                            'ACTIVE' => 'warning',
                            'APPROVED' => 'success',
                            'REJECTED' => 'danger',
                            'REVISION_REQUESTED' => 'warning',
                            default => 'secondary',
                        };
                    @endphp

                    <div class="timeline-item {{ $itemClass }}">
                        <div class="d-flex justify-content-between align-items-start gap-3">
                            <div>
                                <div class="timeline-title">{{ $step->StepNo }}. {{ $step->StepName }}</div>
                                <div class="small timeline-approver mt-1">
                                    <i class="bi bi-person me-1"></i>
                                    {{ $step->approver?->Username ?? ($step->ApproverUserID ? 'User '.$step->ApproverUserID : 'Approver belum ditemukan') }}
                                </div>
                            </div>
                            <span class="badge text-bg-{{ $stepStatusClass }} text-nowrap">
                                @if($step->Status === 'ACTIVE') Waiting Approval
                                @elseif($step->Status === 'APPROVED') Approved
                                @elseif($step->Status === 'REJECTED') Rejected
                                @elseif($step->Status === 'REVISION_REQUESTED') Revision
                                @elseif($step->Status === 'SKIPPED') Skipped
                                @else {{ str_replace('_', ' ', $step->Status) }}
                                @endif
                            </span>
                        </div>

                        @if($step->Comments)
                            <div class="timeline-comment">
                                <strong class="d-block mb-1">Comment</strong>
                                {{ $step->Comments }}
                            </div>
                        @endif

                        @if($step->IsSkipped && $step->SkipReason)
                            <div class="small text-muted mt-2">
                                <strong>Skip Reason:</strong> {{ $step->SkipReason }}
                            </div>
                        @endif

                        @if($step->CompletedAt)
                            <div class="small text-muted mt-2">
                                <i class="bi bi-clock me-1"></i>{{ $step->CompletedAt->format('d M Y H:i') }}
                            </div>
                        @elseif($step->StartedAt)
                            <div class="small text-muted mt-2">
                                <i class="bi bi-clock me-1"></i>Started {{ $step->StartedAt->format('d M Y H:i') }}
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @empty
            <div class="text-muted text-center py-3">No approval history found.</div>
        @endforelse

        @if($workflow->revisions->isNotEmpty())
            <div class="border-top pt-3 mt-2">
                <div class="small fw-semibold text-muted mb-2">Revision Requests</div>
                @foreach($workflow->revisions->sortByDesc('RevisionNo') as $revision)
                    <div class="small mb-2">
                        <span class="fw-semibold">Revision {{ $revision->RevisionNo }}</span>
                        <span class="text-muted">
                            — {{ $revision->requestedBy?->Username ?? ($revision->RequestedByUserID ? 'User '.$revision->RequestedByUserID : '-') }}
                            @if($revision->RequestedAt) on {{ $revision->RequestedAt->format('d M Y H:i') }} @endif
                        </span>
                        @if($revision->Reason)
                            <div class="timeline-comment mt-1">{{ $revision->Reason }}</div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
