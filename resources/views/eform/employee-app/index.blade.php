@extends('layouts.app')

@section('content')

<div class="container-fluid">

    {{-- ========================================================= --}}
    {{-- HEADER --}}
    {{-- ========================================================= --}}

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="mb-1">
                Employee Application
            </h4>

            <div class="text-muted">
                Employee Application Request List
            </div>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- SUCCESS MESSAGE --}}
    {{-- ========================================================= --}}

    @if (session('success'))

        <div class="alert alert-success alert-dismissible fade show"
             role="alert">

            <i class="bi bi-check-circle me-1"></i>

            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    {{-- ========================================================= --}}
    {{-- ERROR MESSAGE --}}
    {{-- ========================================================= --}}

    @if (session('error'))

        <div class="alert alert-danger alert-dismissible fade show"
             role="alert">

            <i class="bi bi-exclamation-circle me-1"></i>

            {{ session('error') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    {{-- ========================================================= --}}
    {{-- SEARCH --}}
    {{-- ========================================================= --}}

    <div class="card mb-3">

        <div class="card-body">

            <form method="GET"
                  action="{{ route('employee-app.index') }}">

                <div class="input-group">

                    <span class="input-group-text">

                        <i class="bi bi-search"></i>

                    </span>

                    <input
                        type="text"
                        name="search"
                        value="{{ $search ?? request('search') }}"
                        class="form-control"
                        placeholder="Search anything..."
                        autocomplete="off"
                    >

                    @if (($search ?? request('search')) !== '')

                        <a href="{{ route('employee-app.index') }}"
                           class="btn btn-outline-secondary">

                            <i class="bi bi-x-lg"></i>

                            Clear

                        </a>

                    @endif

                    <button type="submit"
                            class="btn btn-primary">

                        <i class="bi bi-search"></i>

                        Search

                    </button>

                </div>

                <div class="form-text">

                    Search berdasarkan data apa saja yang tersedia pada
                    Employee Application, termasuk Employee Application ID,
                    Employee Form ID, request user, request type, purpose,
                    user login, access type, application type, application name,
                    URL, notes, status, dan tanggal.

                </div>

            </form>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- TABLE --}}
    {{-- ========================================================= --}}

    <div class="card">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>

                            <th class="text-center"
                                style="width: 55px;">
                                #
                            </th>

                            <th style="width: 170px;">
                                Employee Application ID
                            </th>

                            <th>
                                Employee Form ID
                            </th>

                            <th>
                                Req User
                            </th>

                            <th>
                                Req Type
                            </th>

                            <th>
                                Purpose
                            </th>

                            <th>
                                Date From
                            </th>

                            <th>
                                Date Until
                            </th>

                            <th>
                                Access Type
                            </th>

                            <th>
                                Application Type
                            </th>

                            <th>
                                Application Name
                            </th>

                            <th>
                                URL
                            </th>

                            <th class="text-center">
                                Status
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse ($employeeApps as $index => $employeeApp)

                            <tr
                                class="employee-app-row"
                                data-id="{{ $employeeApp->EmpAppID }}"
                                style="cursor: pointer;"
                            >

                                {{-- ================================================= --}}
                                {{-- SELECTION --}}
                                {{-- ================================================= --}}

                                <td class="text-center">

                                    <span
                                        class="row-selector"
                                        data-id="{{ $employeeApp->EmpAppID }}"
                                    >

                                        <i class="bi bi-circle-fill"
                                           style="font-size: 13px;">
                                        </i>

                                    </span>

                                </td>


                                {{-- ================================================= --}}
                                {{-- EMP APP ID --}}
                                {{-- ================================================= --}}

                                <td>

                                    <strong>
                                        {{ $employeeApp->EmpAppID }}
                                    </strong>

                                </td>


                                {{-- ================================================= --}}
                                {{-- EMP FORM ID --}}
                                {{-- ================================================= --}}

                                <td>

                                    {{ $employeeApp->EmpFormID ?? '-' }}

                                </td>


                                {{-- ================================================= --}}
                                {{-- REQUEST USER --}}
                                {{-- ================================================= --}}

                                <td>

                                    {{ $employeeApp->ReqUser ?? '-' }}

                                </td>


                                {{-- ================================================= --}}
                                {{-- REQUEST TYPE --}}
                                {{-- ================================================= --}}

                                <td>

                                    {{ $employeeApp->ReqType ?? '-' }}

                                </td>


                                {{-- ================================================= --}}
                                {{-- PURPOSE --}}
                                {{-- ================================================= --}}

                                <td>

                                    {{ $employeeApp->Purpose ?? '-' }}

                                </td>


                                {{-- ================================================= --}}
                                {{-- DATE FROM --}}
                                {{-- ================================================= --}}

                                <td>

                                    {{ $employeeApp->DateFrom?->format('d M Y') ?? '-' }}

                                </td>


                                {{-- ================================================= --}}
                                {{-- DATE UNTIL --}}
                                {{-- ================================================= --}}

                                <td>

                                    @if (
                                        $employeeApp->DateUntil &&
                                        $employeeApp->DateUntil->format('Y-m-d') === '1900-01-01'
                                    )

                                        -

                                    @else

                                        {{ $employeeApp->DateUntil?->format('d M Y') ?? '-' }}

                                    @endif

                                </td>


                                {{-- ================================================= --}}
                                {{-- ACCESS TYPE --}}
                                {{-- ================================================= --}}

                                <td>

                                    {{ $employeeApp->AccessType ?? '-' }}

                                </td>


                                {{-- ================================================= --}}
                                {{-- APPLICATION TYPE --}}
                                {{-- ================================================= --}}

                                <td>

                                    {{ $employeeApp->AppType ?? '-' }}

                                </td>


                                {{-- ================================================= --}}
                                {{-- APPLICATION NAME --}}
                                {{-- ================================================= --}}

                                <td>

                                    {{ $employeeApp->AppName ?? '-' }}

                                </td>


                                {{-- ================================================= --}}
                                {{-- URL --}}
                                {{-- ================================================= --}}

                                <td>

                                    @if (
                                        !empty($employeeApp->URL) &&
                                        $employeeApp->URL !== '-'
                                    )

                                        <a href="{{ $employeeApp->URL }}"
                                           target="_blank"
                                           rel="noopener noreferrer"
                                           onclick="event.stopPropagation();">

                                            {{ $employeeApp->URL }}

                                        </a>

                                    @else

                                        -

                                    @endif

                                </td>


                                {{-- ================================================= --}}
                                {{-- STATUS --}}
                                {{-- ================================================= --}}

                                <td class="text-center">

                                    @if ($employeeApp->Status === 'DRAFT')

                                        <span class="badge bg-secondary">
                                            DRAFT
                                        </span>

                                    @elseif ($employeeApp->Status === 'SUBMITTED')

                                        <span class="badge bg-primary">
                                            SUBMITTED
                                        </span>

                                    @elseif ($employeeApp->Status === 'APPROVED')

                                        <span class="badge bg-success">
                                            APPROVED
                                        </span>

                                    @elseif ($employeeApp->Status === 'REJECTED')

                                        <span class="badge bg-danger">
                                            REJECTED
                                        </span>

                                    @elseif ($employeeApp->Status)

                                        <span class="badge bg-secondary">
                                            {{ $employeeApp->Status }}
                                        </span>

                                    @else

                                        <span class="text-muted">
                                            -
                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="13"
                                    class="text-center text-muted py-5">

                                    <i class="bi bi-inbox fs-3 d-block mb-2"></i>

                                    @if (($search ?? request('search')) !== '')

                                        No Employee Application found
                                        for
                                        <strong>
                                            {{ $search ?? request('search') }}
                                        </strong>.

                                    @else

                                        No Employee Application found.

                                    @endif

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- ========================================================= --}}
            {{-- PAGINATION --}}
            {{-- ========================================================= --}}

            @if ($employeeApps->hasPages())

                <div class="mt-3">

                    {{ $employeeApps->appends(request()->query())->links() }}

                </div>

            @endif

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- ACTION BAR --}}
    {{-- ========================================================= --}}

    <div class="d-flex justify-content-end align-items-center gap-2 mt-3">

        {{-- CREATE --}}

        <a href="{{ route('employee-app.create') }}"
           class="btn btn-primary">

            <i class="bi bi-plus-lg me-1"></i>

            Create

        </a>


        {{-- UPDATE --}}

        <a href="#"
           id="updateButton"
           class="btn btn-warning disabled"
           aria-disabled="true">

            <i class="bi bi-pencil me-1"></i>

            Update

        </a>


        {{-- DELETE --}}

        <form id="deleteForm"
              method="POST"
              action="#"
              class="d-inline">

            @csrf

            @method('DELETE')

            <button type="submit"
                    id="deleteButton"
                    class="btn btn-danger"
                    disabled>

                <i class="bi bi-trash me-1"></i>

                Delete

            </button>

        </form>

    </div>

</div>


{{-- ============================================================= --}}
{{-- ROW SELECTION SCRIPT --}}
{{-- ============================================================= --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

    const rows = document.querySelectorAll(
        '.employee-app-row'
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


    /*
    |--------------------------------------------------------------------------
    | Set Selected Row
    |--------------------------------------------------------------------------
    */

    function setSelectedRow(row) {

        /*
        |--------------------------------------------------------------------------
        | Reset All Rows
        |--------------------------------------------------------------------------
        */

        rows.forEach(function (item) {

            item.classList.remove(
                'table-primary'
            );


            const selector =
                item.querySelector(
                    '.row-selector i'
                );


            if (selector) {

                selector.className =
                    'bi bi-circle-fill';

            }

        });


        /*
        |--------------------------------------------------------------------------
        | No Selection
        |--------------------------------------------------------------------------
        */

        if (!row) {

            selectedId = null;


            updateButton.classList.add(
                'disabled'
            );

            updateButton.setAttribute(
                'aria-disabled',
                'true'
            );


            updateButton.href = '#';


            deleteButton.disabled = true;


            deleteForm.setAttribute(
                'action',
                '#'
            );


            return;

        }


        /*
        |--------------------------------------------------------------------------
        | Set Selected ID
        |--------------------------------------------------------------------------
        */

        selectedId =
            row.dataset.id;


        /*
        |--------------------------------------------------------------------------
        | Highlight Row
        |--------------------------------------------------------------------------
        */

        row.classList.add(
            'table-primary'
        );


        /*
        |--------------------------------------------------------------------------
        | Change Selector Icon
        |--------------------------------------------------------------------------
        */

        const selector =
            row.querySelector(
                '.row-selector i'
            );


        if (selector) {

            selector.className =
                'bi bi-check-circle-fill';

        }


        /*
        |--------------------------------------------------------------------------
        | Update Button
        |--------------------------------------------------------------------------
        */

        updateButton.href =
            "{{ url('/employee-app') }}/"
            + encodeURIComponent(
                selectedId
            )
            + "/edit";


        updateButton.classList.remove(
            'disabled'
        );


        updateButton.setAttribute(
            'aria-disabled',
            'false'
        );


        /*
        |--------------------------------------------------------------------------
        | Delete Button
        |--------------------------------------------------------------------------
        */

        deleteForm.action =
            "{{ url('/employee-app') }}/"
            + encodeURIComponent(
                selectedId
            );


        deleteButton.disabled = false;

    }


    /*
    |--------------------------------------------------------------------------
    | Row Click
    |--------------------------------------------------------------------------
    */

    rows.forEach(function (row) {

        row.addEventListener(
            'click',
            function () {

                /*
                |--------------------------------------------------------------------------
                | Toggle Selection
                |--------------------------------------------------------------------------
                */

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

    });


    /*
    |--------------------------------------------------------------------------
    | Delete Confirmation
    |--------------------------------------------------------------------------
    */

    deleteForm.addEventListener(
        'submit',
        function (event) {

            if (!selectedId) {

                event.preventDefault();

                return;

            }


            const confirmed =
                confirm(
                    'Are you sure you want to delete Employee Application '
                    + selectedId
                    + '?'
                );


            if (!confirmed) {

                event.preventDefault();

            }

        }
    );

});

</script>

@endsection