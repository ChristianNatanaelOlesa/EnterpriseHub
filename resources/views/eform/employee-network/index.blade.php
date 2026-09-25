@extends('layouts.app')

@section('title', 'Employee Network')

@section('content')

    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h4 class="mb-1">
                    Employee Network
                </h4>

                <div class="text-muted">
                    Employee Network Request List
                </div>

            </div>

        </div>


        <x-alert />


        {{-- =========================================================
            SEARCH
        ========================================================== --}}

        <div class="card mb-3">

            <div class="card-body">

                <form method="GET" action="{{ route('employee-network.index') }}" class="row g-2">

                    <div class="col-md-8">

                        <input type="text" name="search" class="form-control" value="{{ request('search') }}"
                            placeholder="Search anything...">

                    </div>


                    <div class="col-md-auto">

                        <button type="submit" class="btn btn-outline-primary">

                            <i class="bi bi-search me-1"></i>

                            Search

                        </button>

                    </div>


                    @if (request('search'))
                        <div class="col-md-auto">

                            <a href="{{ route('employee-network.index') }}" class="btn btn-outline-secondary">
                                Clear
                            </a>

                        </div>
                    @endif

                </form>

            </div>

        </div>


        {{-- =========================================================
            TABLE
        ========================================================== --}}

        <div class="card">

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-hover align-middle employee-network-table">

                        <thead>

                            <tr>

                                <th class="text-center" style="width: 55px;">
                                    #
                                </th>


                                <th>
                                    Employee Network ID
                                </th>


                                <th>
                                    Employee Form
                                </th>


                                <th>
                                    Division
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


                                <th class="text-center">
                                    Internet
                                </th>


                                <th class="text-center">
                                    WLAN
                                </th>


                                <th class="text-center">
                                    VPN
                                </th>


                                <th class="text-center">
                                    Status
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse ($data as $item)
                                <tr class="employee-network-row" data-id="{{ $item->EmpNetworkID }}"
                                    style="cursor: pointer;">


                                    {{-- # --}}

                                    <td class="text-center">

                                        <span class="row-selector">

                                            <i class="bi bi-circle-fill"></i>

                                        </span>

                                    </td>


                                    {{-- Employee Network ID --}}

                                    <td>

                                        {{ $item->EmpNetworkID }}

                                    </td>


                                    {{-- Employee Form --}}

                                    <td>

                                        {{ $item->EmpFormID }}

                                        <br>

                                        <small class="text-muted">

                                            {{ trim(($item->empForm?->FirstName ?? '') . ' ' . ($item->empForm?->LastName ?? '')) }}

                                        </small>

                                    </td>


                                    {{-- Division --}}

                                    <td>

                                        {{ $item->division?->DivisionName ?? '-' }}

                                    </td>


                                    {{-- Request Type --}}

                                    <td>

                                        {{ $item->ReqType }}

                                    </td>


                                    {{-- Date From --}}

                                    <td>

                                        {{ $item->DateFrom?->format('d/m/Y') ?? '-' }}

                                    </td>


                                    {{-- Date Until --}}

                                    <td>

                                        @if ($item->DateUntil?->format('Y-m-d') === '1900-01-01')
                                            -
                                        @else
                                            {{ $item->DateUntil?->format('d/m/Y') ?? '-' }}
                                        @endif

                                    </td>


                                    {{-- Internet --}}

                                    <td class="text-center">

                                        @if ($item->InternetAccess)
                                            <span class="badge bg-success status-badge">
                                                Yes
                                            </span>
                                        @else
                                            <span class="badge bg-secondary status-badge">
                                                No
                                            </span>
                                        @endif

                                    </td>


                                    {{-- WLAN --}}

                                    <td class="text-center">

                                        @if ($item->WLANAccess)
                                            <span class="badge bg-success status-badge">
                                                Yes
                                            </span>
                                        @else
                                            <span class="badge bg-secondary status-badge">
                                                No
                                            </span>
                                        @endif

                                    </td>


                                    {{-- VPN --}}

                                    <td class="text-center">

                                        @if ($item->VPNAccess)
                                            <span class="badge bg-success status-badge">
                                                Yes
                                            </span>
                                        @else
                                            <span class="badge bg-secondary status-badge">
                                                No
                                            </span>
                                        @endif

                                    </td>


                                    {{-- Status --}}

                                    <td class="text-center">

                                        @if ($item->Status === 'DRAFT')
                                            <span class="badge bg-secondary status-badge status-draft">
                                                DRAFT
                                            </span>
                                        @else
                                            <span class="badge bg-primary status-badge">
                                                {{ $item->Status }}
                                            </span>
                                        @endif

                                    </td>

                                </tr>


                            @empty

                                <tr>

                                    <td colspan="11" class="text-center text-muted py-5">

                                        <i class="bi bi-inbox fs-3 d-block mb-2"></i>

                                        No Employee Network Request found.

                                    </td>

                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>


                {{-- =================================================
                    PAGINATION
                ================================================== --}}

                @if ($data->hasPages())
                    <div class="mt-3">

                        {{ $data->appends(request()->query())->links() }}

                    </div>
                @endif

            </div>

        </div>


        {{-- =========================================================
            ACTION BUTTONS
        ========================================================== --}}

        <div class="d-flex justify-content-end align-items-center gap-2 mt-3">


            @canAdd('employee-network.index')

            <a href="{{ route('employee-network.create') }}" class="btn btn-primary">

                <i class="bi bi-plus-lg me-1"></i>

                Create

            </a>

            @endcanAdd


            @canEdit('employee-network.index')

            <a href="#" id="updateButton" class="btn btn-warning disabled" aria-disabled="true">

                <i class="bi bi-pencil me-1"></i>

                Update

            </a>

            @endcanEdit


            @canDelete('employee-network.index')

            <form id="deleteForm" method="POST" action="#" class="d-inline">

                @csrf

                @method('DELETE')

                <button type="submit" id="deleteButton" class="btn btn-danger" disabled>

                    <i class="bi bi-trash me-1"></i>

                    Delete

                </button>

            </form>

            @endcanDelete

        </div>

    </div>

@endsection


{{-- =============================================================
    STYLES
============================================================= --}}

@push('styles')
    <style>
        /* =========================================================
                   TABLE
                ========================================================= */

        .employee-network-table th,
        .employee-network-table td {

            vertical-align: middle;

        }


        .employee-network-table th.text-center,
        .employee-network-table td.text-center {

            text-align: center !important;

        }


        /* =========================================================
                   STATUS BADGE
                ========================================================= */

        .employee-network-table .status-badge {

            display: inline-flex;

            align-items: center;

            justify-content: center;

            min-width: 34px;

            min-height: 22px;

            line-height: 1;

            vertical-align: middle;

            white-space: nowrap;

        }


        .employee-network-table .status-draft {

            min-width: 52px;

        }


        /* =========================================================
                   ROW SELECTOR
                ========================================================= */

        .employee-network-row.table-primary .row-selector i {

            color: #0d6efd;

        }


        .row-selector i {

            color: #adb5bd;

        }
    </style>
@endpush


{{-- =============================================================
    SCRIPTS
============================================================= --}}

@push('scripts')
    <script>
        document.addEventListener(
            'DOMContentLoaded',
            function() {

                const rows =
                    document.querySelectorAll(
                        '.employee-network-row'
                    );


                const updateButton =
                    document.getElementById(
                        'updateButton'
                    );


                const deleteButton =
                    document.getElementById(
                        'deleteButton'
                    );


                const deleteForm =
                    document.getElementById(
                        'deleteForm'
                    );


                let selectedId = null;


                function setSelectedRow(row) {

                    rows.forEach(
                        function(item) {

                            item.classList.remove(
                                'table-primary'
                            );


                            const icon =
                                item.querySelector(
                                    '.row-selector i'
                                );


                            if (icon) {

                                icon.className =
                                    'bi bi-circle-fill';

                            }

                        }
                    );


                    if (!row) {

                        selectedId = null;


                        if (updateButton) {

                            updateButton.classList.add(
                                'disabled'
                            );

                            updateButton.setAttribute(
                                'aria-disabled',
                                'true'
                            );

                            updateButton.href = '#';

                        }


                        if (deleteButton) {

                            deleteButton.disabled = true;

                        }


                        if (deleteForm) {

                            deleteForm.action = '#';

                        }


                        return;

                    }


                    selectedId =
                        row.dataset.id;


                    row.classList.add(
                        'table-primary'
                    );


                    const icon =
                        row.querySelector(
                            '.row-selector i'
                        );


                    if (icon) {

                        icon.className =
                            'bi bi-check-circle-fill';

                    }


                    if (updateButton) {

                        updateButton.href =
                            "{{ url('/employee-network') }}/" +
                            encodeURIComponent(
                                selectedId
                            ) +
                            '/edit';


                        updateButton.classList.remove(
                            'disabled'
                        );


                        updateButton.setAttribute(
                            'aria-disabled',
                            'false'
                        );

                    }


                    if (deleteForm) {

                        deleteForm.action =
                            "{{ url('/employee-network') }}/" +
                            encodeURIComponent(
                                selectedId
                            );

                    }


                    if (deleteButton) {

                        deleteButton.disabled = false;

                    }

                }


                rows.forEach(
                    function(row) {

                        row.addEventListener(
                            'click',
                            function() {

                                if (
                                    selectedId ===
                                    row.dataset.id
                                ) {

                                    setSelectedRow(null);

                                } else {

                                    setSelectedRow(row);

                                }

                            }
                        );

                    }
                );


                if (deleteForm) {

                    deleteForm.addEventListener(
                        'submit',
                        function(event) {

                            if (!selectedId) {

                                event.preventDefault();

                                return;

                            }


                            if (
                                !confirm(
                                    'Yakin ingin menghapus Employee Network Request ini?'
                                )
                            ) {

                                event.preventDefault();

                            }

                        }
                    );

                }

            }
        );
    </script>
@endpush
