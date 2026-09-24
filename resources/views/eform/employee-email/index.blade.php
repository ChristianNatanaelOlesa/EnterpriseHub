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
                  action="{{ route('employee-email.index') }}">

                <div class="input-group">

                    <span class="input-group-text bg-white">
                        <i class="bi bi-search"></i>
                    </span>

                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        value="{{ request('search') }}"
                        placeholder="Search anything..."
                    >

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
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
                                style="width: 60px;">
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

                            <th class="text-center">
                                Status
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse ($employeeEmails as $index => $email)

                            <tr
                                class="employee-email-row"
                                data-id="{{ $email->EmpEmailID }}"
                                style="cursor: pointer;"
                            >

                                {{-- Selection --}}
                                <td class="text-center">

                                    <span
                                        class="row-selector"
                                        data-id="{{ $email->EmpEmailID }}"
                                    >
                                        <i class="bi bi-circle-fill"
                                           style="font-size: 13px;">
                                        </i>
                                    </span>

                                </td>


                                {{-- Employee Email ID --}}
                                <td>

                                    <strong>
                                        {{ $email->EmpEmailID }}
                                    </strong>

                                </td>


                                {{-- Employee Form ID --}}
                                <td>

                                    {{ $email->EmpFormID }}

                                </td>


                                {{-- Req User --}}
                                <td>

                                    {{ $email->ReqUser ?: '-' }}

                                </td>


                                {{-- Email Type --}}
                                <td>

                                    @if ($email->EmailType === 'Personal')

                                        <span class="badge bg-secondary">
                                            Personal
                                        </span>

                                    @elseif ($email->EmailType === 'Corporate')

                                        <span class="badge bg-primary">
                                            Corporate
                                        </span>

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

                                        {{ \Carbon\Carbon::parse(
                                            $email->DateFrom
                                        )->format('d M Y') }}

                                    @else

                                        -

                                    @endif

                                </td>


                                {{-- Date Until --}}
                                <td>

                                    @if ($email->DateUntil)

                                        @if (
                                            \Carbon\Carbon::parse(
                                                $email->DateUntil
                                            )->format('Y-m-d') === '1900-01-01'
                                        )

                                            -

                                        @else

                                            {{ \Carbon\Carbon::parse(
                                                $email->DateUntil
                                            )->format('d M Y') }}

                                        @endif

                                    @else

                                        -

                                    @endif

                                </td>


                                {{-- Status --}}
                                <td class="text-center">

                                    @switch($email->Status)

                                        @case('DRAFT')

                                            <span class="badge bg-secondary">
                                                DRAFT
                                            </span>

                                            @break

                                        @case('PROGRESS')

                                            <span class="badge bg-warning text-dark">
                                                PROGRESS
                                            </span>

                                            @break

                                        @case('APPROVED')

                                            <span class="badge bg-success">
                                                APPROVED
                                            </span>

                                            @break

                                        @case('REJECTED')

                                            <span class="badge bg-danger">
                                                REJECTED
                                            </span>

                                            @break

                                        @default

                                            <span class="badge bg-secondary">
                                                {{ $email->Status ?: 'DRAFT' }}
                                            </span>

                                    @endswitch

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="10"
                                    class="text-center text-muted py-4">

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

                    {{ $employeeEmails
                        ->appends(request()->query())
                        ->links()
                    }}

                </div>

            @endif

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- ACTION BUTTONS --}}
    {{-- ========================================================= --}}

    <div class="d-flex justify-content-end gap-2 mt-3">

        {{-- CREATE --}}
        <a
            href="{{ route('employee-email.create') }}"
            class="btn btn-primary"
        >

            <i class="bi bi-plus-lg me-1"></i>

            Create

        </a>


        {{-- UPDATE --}}
        <button
            type="button"
            id="btnUpdate"
            class="btn btn-warning"
            disabled
        >

            <i class="bi bi-pencil me-1"></i>

            Update

        </button>


        {{-- DELETE --}}
        <button
            type="button"
            id="btnDelete"
            class="btn btn-danger"
            disabled
        >

            <i class="bi bi-trash me-1"></i>

            Delete

        </button>

    </div>

</div>


{{-- ============================================================= --}}
{{-- JAVASCRIPT --}}
{{-- ============================================================= --}}

@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    let selectedId = null;


    const rows = document.querySelectorAll(
        '.employee-email-row'
    );

    const btnUpdate = document.getElementById(
        'btnUpdate'
    );

    const btnDelete = document.getElementById(
        'btnDelete'
    );


    // =========================================================
    // SELECT ROW
    // =========================================================

    rows.forEach(function (row) {

        row.addEventListener('click', function () {

            const id = this.dataset.id;

            // Deselect current row
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


            // Select clicked row
            this.classList.add(
                'table-primary'
            );


            const selector =
                this.querySelector(
                    '.row-selector i'
                );

            if (selector) {

                selector.className =
                    'bi bi-check-circle-fill';

            }


            selectedId = id;


            // Enable buttons
            btnUpdate.disabled = false;

            btnDelete.disabled = false;

        });

    });


    // =========================================================
    // UPDATE
    // =========================================================

    btnUpdate.addEventListener(
        'click',
        function () {

            if (!selectedId) {
                return;
            }

            window.location.href =
                "{{ url('/employee-email') }}/"
                + selectedId
                + "/edit";

        }
    );


    // =========================================================
    // DELETE
    // =========================================================

    btnDelete.addEventListener(
        'click',
        function () {

            if (!selectedId) {
                return;
            }


            if (
                !confirm(
                    'Are you sure you want to delete this Employee Email Request?'
                )
            ) {

                return;

            }


            const form =
                document.createElement('form');

            form.method = 'POST';

            form.action =
                "{{ url('/employee-email') }}/"
                + selectedId;


            const csrf =
                document.createElement('input');

            csrf.type = 'hidden';

            csrf.name = '_token';

            csrf.value =
                "{{ csrf_token() }}";


            const method =
                document.createElement('input');

            method.type = 'hidden';

            method.name = '_method';

            method.value = 'DELETE';


            form.appendChild(csrf);

            form.appendChild(method);

            document.body.appendChild(form);

            form.submit();

        }
    );

});

</script>

@endpush

@endsection