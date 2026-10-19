@extends('layouts.app')

@section('title', 'My Approval')

@section('content')
<style>
    .workflow-page .card {
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(15, 23, 42, .04);
    }
    .workflow-page .table > :not(caption) > * > * {
        border-bottom-color: #eef0f3;
    }
    .workflow-page .table thead th {
        background: #f8fafc !important;
        color: #334155;
        font-weight: 600;
        white-space: nowrap;
    }
    .workflow-page .table tbody td {
        color: #334155;
    }
    .workflow-page .workflow-id {
        color: #94a3b8;
        font-size: .72rem;
    }
    .workflow-page .step-badge {
        display: inline-flex;
        align-items: center;
        padding: .35rem .65rem;
        border-radius: 999px;
        background: #fff7d6;
        color: #8a6200;
        border: 1px solid #f6d878;
        font-weight: 600;
        font-size: .75rem;
    }
    .workflow-page .review-btn {
        background: #2563eb !important;
        border-color: #2563eb !important;
        color: #ffffff !important;
        opacity: 1 !important;
        text-shadow: none !important;
        box-shadow: none;
    }
    .workflow-page .review-btn:hover,
    .workflow-page .review-btn:focus,
    .workflow-page .review-btn:active {
        background: #1d4ed8 !important;
        border-color: #1d4ed8 !important;
        color: #ffffff !important;
        opacity: 1 !important;
    }
    .workflow-page .review-btn i {
        color: #ffffff !important;
        opacity: 1 !important;
    }
</style>
<div class="container-fluid workflow-page">
    <div class="mb-4">
        <h4 class="mb-1">My Approval</h4>
        <div class="text-muted">Daftar transaksi yang sedang menunggu approval Anda.</div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('workflow.index') }}">
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control" value="{{ $search }}" placeholder="Search workflow, transaction, requester...">
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
                            <th>Process</th>
                            <th>Module</th>
                            <th>Transaction</th>
                            <th>Requester</th>
                            <th>Current Step</th>
                            <th>Started</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($approvals as $index => $workflow)
                        @php($active = $workflow->steps->first())
                        <tr>
                            <td class="text-center">{{ $approvals->firstItem() + $index }}</td>
                            <td>
                                <strong>{{ $workflow->process?->Process ?? $workflow->ProcessID }}</strong>
                                <div class="small text-muted">{{ $workflow->WorkflowInstanceID }}</div>
                            </td>
                            <td>{{ $workflow->Module }}</td>
                            <td><strong>{{ $workflow->TransactionID }}</strong></td>
                            <td>{{ $workflow->requester?->Username ?? $workflow->RequesterUserID }}</td>
                            <td>
                                <span class="step-badge"><i class="bi bi-hourglass-split me-1"></i>{{ $active?->StepName ?? 'Approval' }}</span>
                            </td>
                            <td>{{ optional($workflow->StartedAt)->format('d-m-Y H:i') }}</td>
                            <td class="text-center">
                                <a href="{{ route('workflow.show', $workflow->WorkflowInstanceID) }}" class="btn btn-sm review-btn">
                                    <i class="bi bi-eye me-1"></i>Review
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="bi bi-check2-circle fs-3 d-block mb-2"></i>
                                Tidak ada approval yang perlu diproses.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($approvals->hasPages())
            <div class="card-footer">{{ $approvals->links() }}</div>
        @endif
    </div>
</div>
@endsection
