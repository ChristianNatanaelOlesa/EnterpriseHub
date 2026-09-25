@extends('layouts.app')

@section('title', 'Employee IT Area')

@section('content')

    <div class="container-fluid">

        <div class="mb-4">
            <h4 class="mb-1">Employee IT Area</h4>
            <div class="text-muted">Employee IT Area Request List</div>
        </div>

        <x-alert />

        <div class="card mb-3">
            <div class="card-body">
                <form method="GET" action="{{ route('employee-it-area.index') }}" class="row g-2">
                    <div class="col-md-8">
                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            value="{{ request('search') }}"
                            placeholder="Search anything..."
                        >
                    </div>
                    <div class="col-md-auto">
                        <button type="submit" class="btn btn-outline-primary">
                            <i class="bi bi-search me-1"></i>
                            Search
                        </button>
                    </div>
                    @if (request('search'))
                        <div class="col-md-auto">
                            <a href="{{ route('employee-it-area.index') }}" class="btn btn-outline-secondary">
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
                    <table class="table table-hover align-middle employee-it-area-table">
                        <thead>
                            <tr>
                                <th class="text-center" style="width:55px;">#</th>
                                <th>Employee IT Area ID</th>
                                <th>Employee Form</th>
                                <th>Division</th>
                                <th>Request Type</th>
                                <th>Date From</th>
                                <th>Date Until</th>
                                <th class="text-center">Data Center</th>
                                <th class="text-center">Finger Print</th>
                                <th class="text-center">Firewall</th>
                                <th class="text-center">CCTV</th>
                                <th class="text-center">Ext. Drive</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $item)
                                <tr
                                    class="employee-it-area-row"
                                    data-id="{{ $item->EmpITAreaID }}"
                                    style="cursor:pointer;"
                                >
                                    <td class="text-center">
                                        <span class="row-selector">
                                            <i class="bi bi-circle-fill"></i>
                                        </span>
                                    </td>
                                    <td>{{ $item->EmpITAreaID }}</td>
                                    <td>
                                        {{ $item->EmpFormID }}
                                        <br>
                                        <small class="text-muted">
                                            {{ trim(($item->empForm?->FirstName ?? '') . ' ' . ($item->empForm?->LastName ?? '')) }}
                                        </small>
                                    </td>
                                    <td>{{ $item->division?->DivisionName ?? '-' }}</td>
                                    <td>{{ $item->ReqType }}</td>
                                    <td>{{ $item->DateFrom?->format('d/m/Y') ?? '-' }}</td>
                                    <td>
                                        @if ($item->DateUntil?->format('Y-m-d') === '1900-01-01')
                                            -
                                        @else
                                            {{ $item->DateUntil?->format('d/m/Y') ?? '-' }}
                                        @endif
                                    </td>
                                    @foreach (['DataCenter' => 'DataCenter', 'FingerPrint' => 'FingerPrint', 'Firewall' => 'Firewall', 'CCTV' => 'CCTV', 'ExtDrive' => 'ExtDrive'] as $field => $label)
                                        <td class="text-center">
                                            @if ($item->{$field})
                                                <span class="badge bg-success status-badge">Yes</span>
                                            @else
                                                <span class="badge bg-secondary status-badge">No</span>
                                            @endif
                                        </td>
                                    @endforeach
                                    <td class="text-center">
                                        <span class="badge {{ $item->Status === 'DRAFT' ? 'bg-secondary' : 'bg-primary' }} status-badge status-draft">
                                            {{ $item->Status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="13" class="text-center text-muted py-5">
                                        <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                        No Employee IT Area Request found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($data->hasPages())
                    <div class="mt-3">
                        {{ $data->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>

        <div class="d-flex justify-content-end align-items-center gap-2 mt-3">
            @canAdd('employee-it-area.index')
                <a href="{{ route('employee-it-area.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-1"></i> Create
                </a>
            @endcanAdd

            @canEdit('employee-it-area.index')
                <a href="#" id="updateButton" class="btn btn-warning disabled" aria-disabled="true">
                    <i class="bi bi-pencil me-1"></i> Update
                </a>
            @endcanEdit

            @canDelete('employee-it-area.index')
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
    .employee-it-area-table th,
    .employee-it-area-table td {
        vertical-align: middle;
    }

    .employee-it-area-table th.text-center,
    .employee-it-area-table td.text-center {
        text-align: center !important;
    }

    .employee-it-area-table .status-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 34px;
        min-height: 22px;
        line-height: 1;
        vertical-align: middle;
        white-space: nowrap;
    }

    .employee-it-area-table .status-draft {
        min-width: 52px;
    }

    .employee-it-area-row.table-primary .row-selector i {
        color: #0d6efd;
    }

    .row-selector i {
        color: #adb5bd;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const rows = document.querySelectorAll('.employee-it-area-row');
    const updateButton = document.getElementById('updateButton');
    const deleteButton = document.getElementById('deleteButton');
    const deleteForm = document.getElementById('deleteForm');
    let selectedId = null;

    function setSelectedRow(row) {
        rows.forEach(function (item) {
            item.classList.remove('table-primary');
            const icon = item.querySelector('.row-selector i');
            if (icon) icon.className = 'bi bi-circle-fill';
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

        selectedId = row.dataset.id;
        row.classList.add('table-primary');

        const icon = row.querySelector('.row-selector i');
        if (icon) icon.className = 'bi bi-check-circle-fill';

        if (updateButton) {
            updateButton.href = "{{ url('/employee-it-area') }}/" + encodeURIComponent(selectedId) + '/edit';
            updateButton.classList.remove('disabled');
            updateButton.setAttribute('aria-disabled', 'false');
        }

        if (deleteForm) {
            deleteForm.action = "{{ url('/employee-it-area') }}/" + encodeURIComponent(selectedId);
        }

        if (deleteButton) deleteButton.disabled = false;
    }

    rows.forEach(function (row) {
        row.addEventListener('click', function () {
            if (selectedId === row.dataset.id) {
                setSelectedRow(null);
            } else {
                setSelectedRow(row);
            }
        });
    });

    if (deleteForm) {
        deleteForm.addEventListener('submit', function (event) {
            if (!selectedId) {
                event.preventDefault();
                return;
            }
            if (!confirm('Yakin ingin menghapus Employee IT Area Request ini?')) {
                event.preventDefault();
            }
        });
    }
});
</script>
@endpush
