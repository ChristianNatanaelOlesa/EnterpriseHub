@extends('layouts.app')

@section('title', 'Employee Software')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Employee Software</h4>
            <div class="text-muted">Employee Software Request List</div>
        </div>
    </div>

    <x-alert />

    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('employee-software.index') }}" class="row g-2">
                <div class="col-md-8">
                    <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Search anything...">
                </div>
                <div class="col-md-auto">
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="bi bi-search me-1"></i> Search
                    </button>
                </div>
                @if(request('search'))
                    <div class="col-md-auto">
                        <a href="{{ route('employee-software.index') }}" class="btn btn-outline-secondary">Clear</a>
                    </div>
                @endif
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle employee-software-table">
                    <thead>
                        <tr>
                            <th class="text-center" style="width:55px;">#</th>
                            <th>Employee Software ID</th>
                            <th>Employee Form</th>
                            <th>Division</th>
                            <th>Request Type</th>
                            <th>Date From</th>
                            <th>Date Until</th>
                            <th>Software Type</th>
                            <th>Software / Application</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $item)
                            <tr class="transaction-row" data-transaction-id="{{ $item->EmpSoftwareID }}" style="cursor:pointer;">
                                <td class="text-center">
                                    <input type="radio" name="selectedTransaction" class="form-check-input transaction-row-radio" value="{{ $item->EmpSoftwareID }}" aria-label="Select {{ $item->EmpSoftwareID }}">
                                </td>
                                <td>{{ $item->EmpSoftwareID }}</td>
                                <td>
                                    {{ $item->empForm?->EmpFormID ?? $item->EmpFormID }}<br>
                                    <small class="text-muted">{{ trim(($item->empForm?->FirstName ?? '').' '.($item->empForm?->LastName ?? '')) }}</small>
                                </td>
                                <td>{{ $item->division?->DivisionName ?? '-' }}</td>
                                <td>{{ $item->ReqType }}</td>
                                <td>{{ $item->DateFrom?->format('d/m/Y') ?? '-' }}</td>
                                <td>{{ $item->DateUntil?->format('Y-m-d') === '1900-01-01' ? '-' : ($item->DateUntil?->format('d/m/Y') ?? '-') }}</td>
                                <td>{{ $item->SoftType }}</td>
                                <td>{{ $item->SoftTool }}</td>
                                <td class="text-center">
                                    <span class="badge {{ $item->Status === 'DRAFT' ? 'bg-secondary' : 'bg-primary' }} status-badge">
                                        {{ $item->Status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center py-5 text-muted">
                                    No Employee Software Request found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="small text-muted">
                    Showing {{ $data->firstItem() ?? 0 }} to {{ $data->lastItem() ?? 0 }} of {{ $data->total() }} results
                </div>
                {{ $data->links() }}
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end align-items-center gap-2 mt-3">
        @canAdd('employee-software.index')
            <a href="{{ route('employee-software.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i> Create
            </a>
        @endcanAdd

        @canEdit('employee-software.index')
            <a href="#" id="updateButton" class="btn btn-warning disabled" aria-disabled="true">
                <i class="bi bi-pencil me-1"></i> Update
            </a>
        @endcanEdit

        @canDelete('employee-software.index')
            <form id="deleteForm" method="POST" action="#" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" id="deleteButton" class="btn btn-danger" disabled>
                    <i class="bi bi-trash me-1"></i> Delete
                </button>
            </form>
        @endcanDelete
    </div>

</div>

@endsection

@push('styles')
<style>
    .employee-software-table th,
    .employee-software-table td { vertical-align: middle; }
    .employee-software-table th.text-center,
    .employee-software-table td.text-center { text-align: center !important; }
    .employee-software-table .status-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 52px;
        min-height: 22px;
        line-height: 1;
        vertical-align: middle;
        white-space: nowrap;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const rows = document.querySelectorAll('.transaction-row');
    const updateButton = document.getElementById('updateButton');
    const deleteButton = document.getElementById('deleteButton');
    const deleteForm = document.getElementById('deleteForm');
    let selectedId = null;

    function setSelectedRow(row) {
        rows.forEach(function (item) {
            item.classList.remove('table-primary');
            const radio = item.querySelector('.transaction-row-radio');
            if (radio) radio.checked = false;
        });

        if (!row) {
            selectedId = null;
            if (updateButton) {
                updateButton.classList.add('disabled');
                updateButton.setAttribute('aria-disabled', 'true');
                updateButton.href = '#';
            }
            if (deleteButton) deleteButton.disabled = true;
            if (deleteForm) deleteForm.action = '#';
            return;
        }

        selectedId = row.dataset.transactionId;
        row.classList.add('table-primary');
        const radio = row.querySelector('.transaction-row-radio');
        if (radio) radio.checked = true;

        if (updateButton) {
            updateButton.href = "{{ url('/employee-software') }}/" + encodeURIComponent(selectedId) + "/edit";
            updateButton.classList.remove('disabled');
            updateButton.setAttribute('aria-disabled', 'false');
        }

        if (deleteForm) {
            deleteForm.action = "{{ url('/employee-software') }}/" + encodeURIComponent(selectedId);
        }

        if (deleteButton) deleteButton.disabled = false;
    }

    rows.forEach(function (row) {
        row.addEventListener('click', function () {
            setSelectedRow(row);
        });

        const radio = row.querySelector('.transaction-row-radio');
        if (radio) {
            radio.addEventListener('click', function (event) {
                event.stopPropagation();
                setSelectedRow(row);
            });
        }
    });

    if (deleteForm) {
        deleteForm.addEventListener('submit', function (event) {
            if (!selectedId) {
                event.preventDefault();
                return;
            }
            if (!confirm('Are you sure you want to delete this Employee Software Request?')) {
                event.preventDefault();
            }
        });
    }
});
</script>
@endpush
