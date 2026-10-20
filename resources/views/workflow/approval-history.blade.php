@extends('layouts.app')

@section('title', 'Approval History')

@section('content')
<style>
    .workflow-history-page .card {
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(15, 23, 42, .04);
    }
    .workflow-history-page .table > :not(caption) > * > * {
        border-bottom-color: #eef0f3;
    }
    .workflow-history-page .table thead th {
        background: #f8fafc !important;
        color: #334155;
        font-weight: 600;
        white-space: nowrap;
    }
    .workflow-history-page .table tbody td {
        color: #334155;
    }
    .workflow-history-page .workflow-id {
        color: #94a3b8;
        font-size: .72rem;
    }
    .workflow-history-page .status-badge {
        display: inline-flex;
        align-items: center;
        border-radius: 999px;
        padding: .3rem .6rem;
        font-size: .72rem;
        font-weight: 600;
        white-space: nowrap;
    }
    .workflow-history-page .status-approved {
        background: #dcfce7;
        color: #166534;
        border: 1px solid #bbf7d0;
    }
    .workflow-history-page .status-rejected {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }
    .workflow-history-page .status-revision {
        background: #ffedd5;
        color: #9a3412;
        border: 1px solid #fed7aa;
    }
    .workflow-history-page .status-skipped {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #cbd5e1;
    }
    .workflow-history-page .status-waiting {
        background: #fff7d6;
        color: #8a6200;
        border: 1px solid #f6d878;
    }
    .workflow-history-page .status-pending {
        background: #f8fafc;
        color: #64748b;
        border: 1px solid #e2e8f0;
    }
</style>
<div class="container-fluid workflow-history-page">
    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-3">
        <div>
            <h4 class="mb-1">Approval History</h4>
            <div class="text-muted">Riwayat seluruh aktivitas approval yang telah Anda lakukan.</div>
        </div>
        <a href="{{ route('workflow.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>Kembali ke My Approval
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('workflow.approval-history') }}">
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control" value="{{ $search }}"
                        placeholder="Cari transaksi, modul, requester, atau komentar...">
                    <button class="btn btn-primary" type="submit"><i class="bi bi-search me-1"></i>Search</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center" style="width:60px">#</th>
                            <th>Transaction Number</th>
                            <th>Module</th>
                            <th>Requester</th>
                            <th>Approval Date</th>
                            <th>Decision</th>
                            <th>Comment</th>
                            <th>Current Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($steps as $index => $step)
                        <tr>
                            <td class="text-center">{{ $steps->firstItem() + $index }}</td>
                            <td>
                                <strong>{{ $step->instance->TransactionID }}</strong>
                                <div class="workflow-id">{{ $step->instance->WorkflowInstanceID }}</div>
                            </td>
                            <td>{{ $step->instance->process?->Process ?? $step->instance->Module }}</td>
                            <td>{{ $step->instance->requester?->Username ?? $step->instance->RequesterUserID }}</td>
                            <td>{{ optional($step->CompletedAt)->format('d-m-Y H:i') }}</td>
                            <td>
                                @php
                                    $status = strtoupper(trim((string) ($step->Status ?? '')));
                                    $badgeClass = match ($status) {
                                        'APPROVED' => 'status-approved',
                                        'REJECTED' => 'status-rejected',
                                        'REVISION_REQUESTED' => 'status-revision',
                                        'SKIPPED' => 'status-skipped',
                                        'WAITING_APPROVAL' => 'status-waiting',
                                        'PENDING' => 'status-pending',
                                        default => 'status-pending',
                                    };
                                @endphp
                                <span class="status-badge {{ $badgeClass }}">
                                    @if ($status === 'APPROVED')
                                        <i class="bi bi-check-circle me-1"></i>Approved
                                    @elseif ($status === 'REJECTED')
                                        <i class="bi bi-x-circle me-1"></i>Rejected
                                    @elseif ($status === 'REVISION_REQUESTED')
                                        <i class="bi bi-arrow-repeat me-1"></i>Revision
                                    @elseif ($status === 'SKIPPED')
                                        <i class="bi bi-skip-forward-circle me-1"></i>Skipped
                                    @else
                                        {{ $step->Status }}
                                    @endif
                                </span>
                            </td>
                            <td>{{ $step->Comments ?? '-' }}</td>
                            <td>
                                <span class="badge text-bg-info">{{ $step->instance->Status }}</span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('workflow.detail', $step->instance->WorkflowInstanceID) }}"
                                    class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye me-1"></i>Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-5 text-muted">
                                <i class="bi bi-clock-history fs-3 d-block mb-2"></i>
                                Belum ada riwayat approval.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($steps->hasPages())
            <div class="card-footer">{{ $steps->links() }}</div>
        @endif
    </div>
</div>
@endsection
