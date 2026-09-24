@extends('layouts.app')

@section('content')

<div class="container-fluid">

    {{-- ========================================================= --}}
    {{-- HEADER --}}
    {{-- ========================================================= --}}

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h4 class="mb-1">
                Employee Form Request
            </h4>

            <div class="text-muted">
                Employee Form Request List
            </div>
        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- FLASH MESSAGE --}}
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
                  action="{{ route('employee-form.index') }}">

                <div class="input-group">

                    <span class="input-group-text">
                        <i class="bi bi-search"></i>
                    </span>

                    <input type="text"
                           name="search"
                           value="{{ $search }}"
                           class="form-control"
                           placeholder="Search anything..."
                           autocomplete="off">

                    @if ($search !== '')
                        <a href="{{ route('employee-form.index') }}"
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
                    Search berdasarkan data apa saja yang tersedia pada Employee Form,
                    termasuk ID, nama, NIP, email, alamat, agama, organisasi,
                    job level, job title, status, dan tanggal.
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
                                Employee Form ID
                            </th>

                            <th>
                                Nama Lengkap
                            </th>

                            <th>
                                Directorate
                            </th>

                            <th>
                                Division
                            </th>

                            <th>
                                Department
                            </th>

                            <th>
                                Job Level
                            </th>

                            <th>
                                Job Title
                            </th>

                            <th class="text-center">
                                Status
                            </th>

                            <th>
                                Effective Date
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse ($employeeForms as $index => $employeeForm)

                            @php
                                $history = $employeeForm->histories->first();

                                $fullName = trim(
                                    $employeeForm->FirstName
                                    . ' '
                                    . ($employeeForm->LastName ?? '')
                                );

                                $modalId =
                                    'employeeDetailModal_' .
                                    preg_replace(
                                        '/[^A-Za-z0-9_-]/',
                                        '_',
                                        $employeeForm->EmpFormID
                                    );
                            @endphp

                            <tr class="employee-row"
                                data-emp-form-id="{{ $employeeForm->EmpFormID }}"
                                style="cursor: pointer;">

                                {{-- Row Number --}}
                                <td class="text-center">

                                    <input type="radio"
                                           name="selectedEmployeeForm"
                                           class="form-check-input employee-row-radio"
                                           value="{{ $employeeForm->EmpFormID }}"
                                           aria-label="Select {{ $employeeForm->EmpFormID }}">

                                </td>


                                {{-- Employee Form ID / DETAIL --}}
                                <td>

                                    <a href="#"
                                       class="employee-detail-link fw-semibold"
                                       data-bs-toggle="modal"
                                       data-bs-target="#{{ $modalId }}"
                                       onclick="event.stopPropagation();">

                                        {{ $employeeForm->EmpFormID }}

                                    </a>

                                </td>


                                {{-- Nama --}}
                                <td>
                                    {{ $fullName }}
                                </td>


                                {{-- Directorate --}}
                                <td>
                                    {{ $history?->directorate?->DirectorateName ?? '-' }}
                                </td>


                                {{-- Division --}}
                                <td>
                                    {{ $history?->division?->DivisionName ?? '-' }}
                                </td>


                                {{-- Department --}}
                                <td>
                                    {{ $history?->department?->DepartmentName ?? '-' }}
                                </td>


                                {{-- Job Level --}}
                                <td>
                                    {{ $history?->jobLevel?->JobLevel ?? '-' }}
                                </td>


                                {{-- Job Title --}}
                                <td>
                                    {{ $history?->jobTitle?->JobTitle ?? '-' }}
                                </td>


                                {{-- Status --}}
                                <td class="text-center">

                                    @if ($history?->EmpStatus === 'NEW')

                                        <span class="badge bg-primary">
                                            NEW
                                        </span>

                                    @elseif ($history?->EmpStatus)

                                        <span class="badge bg-secondary">
                                            {{ $history->EmpStatus }}
                                        </span>

                                    @else

                                        <span class="text-muted">
                                            -
                                        </span>

                                    @endif

                                </td>


                                {{-- Effective Date --}}
                                <td>
                                    {{ $history?->EffectiveDate?->format('d M Y') ?? '-' }}
                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="10"
                                    class="text-center text-muted py-5">

                                    <i class="bi bi-inbox fs-3 d-block mb-2"></i>

                                    @if ($search !== '')
                                        No Employee Form Request found
                                        for
                                        <strong>{{ $search }}</strong>.
                                    @else
                                        No Employee Form Request found.
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

            @if ($employeeForms->hasPages())

                <div class="mt-3">

                    {{ $employeeForms->links() }}

                </div>

            @endif

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- ACTION BAR --}}
    {{-- ========================================================= --}}

    <div class="d-flex justify-content-end align-items-center gap-2 mt-3">

        <a href="{{ route('employee-form.create') }}"
           class="btn btn-primary">

            <i class="bi bi-plus-lg me-1"></i>

            Create

        </a>


        <a href="#"
           id="updateButton"
           class="btn btn-warning disabled"
           aria-disabled="true">

            <i class="bi bi-pencil me-1"></i>

            Update

        </a>


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


    {{-- ========================================================= --}}
    {{-- DETAIL MODALS --}}
    {{-- ========================================================= --}}

    @foreach ($employeeForms as $employeeForm)

        @php
            $modalId =
                'employeeDetailModal_' .
                preg_replace(
                    '/[^A-Za-z0-9_-]/',
                    '_',
                    $employeeForm->EmpFormID
                );

            $history = $employeeForm->histories->first();
        @endphp

        <div class="modal fade"
             id="{{ $modalId }}"
             tabindex="-1"
             aria-labelledby="{{ $modalId }}Label"
             aria-hidden="true">

            <div class="modal-dialog modal-lg modal-dialog-scrollable">

                <div class="modal-content">

                    <div class="modal-header">

                        <div>

                            <h5 class="modal-title mb-1"
                                id="{{ $modalId }}Label">

                                Employee Information

                            </h5>

                            <small class="text-muted">
                                {{ $employeeForm->EmpFormID }}
                            </small>

                        </div>

                        <button type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"
                                aria-label="Close">
                        </button>

                    </div>


                    <div class="modal-body">

                        {{-- PERSONAL --}}
                        <h6 class="fw-bold mb-3">
                            <i class="bi bi-person me-1"></i>
                            Personal Information
                        </h6>

                        <div class="row mb-4">

                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">
                                    First Name
                                </label>
                                <div class="fw-semibold">
                                    {{ $employeeForm->FirstName ?: '-' }}
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">
                                    Last Name
                                </label>
                                <div class="fw-semibold">
                                    {{ $employeeForm->LastName ?: '-' }}
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">
                                    Mobile Number
                                </label>
                                <div>
                                    {{ $employeeForm->MobileNo ?: '-' }}
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">
                                    Birth Date
                                </label>
                                <div>
                                    {{ $employeeForm->BirthDate?->format('d M Y') ?? '-' }}
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">
                                    NIP
                                </label>
                                <div>
                                    {{ $employeeForm->NIP ?: '-' }}
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">
                                    Marital Status
                                </label>
                                <div>
                                    @switch($employeeForm->MaritalStatus)
                                        @case('S')
                                            Single
                                            @break
                                        @case('M')
                                            Married
                                            @break
                                        @case('D')
                                            Divorce
                                            @break
                                        @default
                                            {{ $employeeForm->MaritalStatus ?: '-' }}
                                    @endswitch
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">
                                    Religion
                                </label>
                                <div>
                                    {{ $employeeForm->religion?->Religion ?? '-' }}
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">
                                    Join Date
                                </label>
                                <div>
                                    {{ $employeeForm->JoinDate?->format('d M Y') ?? '-' }}
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="text-muted small">
                                    Email
                                </label>
                                <div class="text-break">
                                    {{ $employeeForm->Email ?: '-' }}
                                </div>
                            </div>

                        </div>


                        {{-- ADDRESS --}}
                        <h6 class="fw-bold mb-3">
                            <i class="bi bi-geo-alt me-1"></i>
                            Address
                        </h6>

                        <div class="row mb-4">

                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">
                                    Country
                                </label>
                                <div>
                                    {{ $employeeForm->detailCountry?->Country ?? '-' }}
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">
                                    Province
                                </label>
                                <div>
                                    {{ $employeeForm->detailProvince?->Province ?? '-' }}
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">
                                    City
                                </label>
                                <div>
                                    {{ $employeeForm->detailCity?->City ?? '-' }}
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">
                                    District
                                </label>
                                <div>
                                    {{ $employeeForm->detailDistrict?->District ?? '-' }}
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">
                                    Village
                                </label>
                                <div>
                                    {{ $employeeForm->detailVillage?->Village ?? '-' }}
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="text-muted small">
                                    Address
                                </label>
                                <div class="text-break">
                                    {{ $employeeForm->Address ?: '-' }}
                                </div>
                            </div>

                        </div>


                        {{-- EMPLOYMENT --}}
                        <h6 class="fw-bold mb-3">
                            <i class="bi bi-briefcase me-1"></i>
                            Employment Information
                        </h6>

                        <div class="row mb-4">

                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">
                                    Directorate
                                </label>
                                <div>
                                    {{ $history?->directorate?->DirectorateName ?? '-' }}
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">
                                    Division
                                </label>
                                <div>
                                    {{ $history?->division?->DivisionName ?? '-' }}
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">
                                    Department
                                </label>
                                <div>
                                    {{ $history?->department?->DepartmentName ?? '-' }}
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">
                                    Job Level
                                </label>
                                <div>
                                    {{ $history?->jobLevel?->JobLevel ?? '-' }}
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">
                                    Job Title
                                </label>
                                <div>
                                    {{ $history?->jobTitle?->JobTitle ?? '-' }}
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">
                                    Employee Status
                                </label>
                                <div>
                                    @if ($history?->EmpStatus === 'NEW')
                                        <span class="badge bg-primary">
                                            NEW
                                        </span>
                                    @elseif ($history?->EmpStatus)
                                        <span class="badge bg-secondary">
                                            {{ $history->EmpStatus }}
                                        </span>
                                    @else
                                        -
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">
                                    Report To
                                </label>
                                <div>
                                    {{ $history?->ReportTo ?: '-' }}
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">
                                    Effective Date
                                </label>
                                <div>
                                    {{ $history?->EffectiveDate?->format('d M Y') ?? '-' }}
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="text-muted small">
                                    Remarks
                                </label>
                                <div class="text-break">
                                    {{ $history?->Remarks ?: '-' }}
                                </div>
                            </div>

                        </div>


                        {{-- AUDIT --}}
                        <h6 class="fw-bold mb-3">
                            <i class="bi bi-clock-history me-1"></i>
                            Audit Information
                        </h6>

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">
                                    Input User
                                </label>
                                <div>
                                    {{ $employeeForm->InputUser ?: '-' }}
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">
                                    Input Date
                                </label>
                                <div>
                                    {{ $employeeForm->InputDate?->format('d M Y H:i:s') ?? '-' }}
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">
                                    Modified User
                                </label>
                                <div>
                                    {{ $employeeForm->ModifUser ?: '-' }}
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">
                                    Modified Date
                                </label>
                                <div>
                                    {{ $employeeForm->ModifDate?->format('d M Y H:i:s') ?? '-' }}
                                </div>
                            </div>

                        </div>

                    </div>


                    <div class="modal-footer">

                        <button type="button"
                                class="btn btn-secondary"
                                data-bs-dismiss="modal">

                            <i class="bi bi-x-lg me-1"></i>
                            Close

                        </button>

                    </div>

                </div>

            </div>

        </div>

    @endforeach

</div>


{{-- ========================================================= --}}
{{-- ROW SELECTION SCRIPT --}}
{{-- ========================================================= --}}

<script>
document.addEventListener('DOMContentLoaded', function () {

    const rows = document.querySelectorAll('.employee-row');
    const updateButton = document.getElementById('updateButton');
    const deleteButton = document.getElementById('deleteButton');
    const deleteForm = document.getElementById('deleteForm');

    let selectedId = null;


    function setSelectedRow(row) {

        rows.forEach(function (item) {
            item.classList.remove('table-primary');

            const radio = item.querySelector(
                '.employee-row-radio'
            );

            if (radio) {
                radio.checked = false;
            }
        });


        if (!row) {

            selectedId = null;

            updateButton.classList.add('disabled');
            updateButton.setAttribute(
                'aria-disabled',
                'true'
            );

            deleteButton.disabled = true;

            deleteForm.setAttribute(
                'action',
                '#'
            );

            return;
        }


        selectedId = row.dataset.empFormId;

        row.classList.add('table-primary');


        const radio = row.querySelector(
            '.employee-row-radio'
        );

        if (radio) {
            radio.checked = true;
        }


        /*
        |--------------------------------------------------------------------------
        | Update
        |--------------------------------------------------------------------------
        */

        updateButton.href =
            "{{ url('/employee-form') }}/"
            + encodeURIComponent(selectedId)
            + "/edit";

        updateButton.classList.remove('disabled');

        updateButton.setAttribute(
            'aria-disabled',
            'false'
        );


        /*
        |--------------------------------------------------------------------------
        | Delete
        |--------------------------------------------------------------------------
        */

        deleteForm.action =
            "{{ url('/employee-form') }}/"
            + encodeURIComponent(selectedId);

        deleteButton.disabled = false;
    }


    /*
    |--------------------------------------------------------------------------
    | Row Click
    |--------------------------------------------------------------------------
    */

    rows.forEach(function (row) {

        row.addEventListener('click', function (event) {

            /*
            |--------------------------------------------------------------------------
            | Jangan select row ketika user click hyperlink ID.
            | ID digunakan untuk membuka Detail.
            |--------------------------------------------------------------------------
            */

            if (
                event.target.closest(
                    '.employee-detail-link'
                )
            ) {
                return;
            }


            setSelectedRow(row);
        });


        const radio = row.querySelector(
            '.employee-row-radio'
        );

        if (radio) {

            radio.addEventListener(
                'click',
                function (event) {

                    event.stopPropagation();

                    setSelectedRow(row);
                }
            );
        }
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


            const confirmed = confirm(
                'Are you sure you want to delete Employee Form '
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
