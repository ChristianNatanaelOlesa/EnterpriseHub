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
                    Create new employee form request
                </div>
            </div>

            <a href="{{ route('employee-form.index') }}" class="btn btn-secondary">

                <i class="bi bi-arrow-left"></i>
                Back

            </a>

        </div>


        {{-- ========================================================= --}}
        {{-- VALIDATION ERROR --}}
        {{-- ========================================================= --}}

        @if ($errors->any())
            <div class="alert alert-danger">

                <strong>Please check the following:</strong>

                <ul class="mb-0 mt-2">

                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach

                </ul>

            </div>
        @endif


        <form action="{{ route('employee-form.store') }}" method="POST">

            @csrf


            {{-- ========================================================= --}}
            {{-- TRANSACTION INFORMATION --}}
            {{-- ========================================================= --}}

            <div class="card mb-4">

                <div class="card-header">
                    <strong>Transaction Information</strong>
                </div>

                <div class="card-body">

                    {{-- ROW 1 --}}
                    <div class="row">

                        {{-- EmpFormHistID --}}
                        <div class="col-md-3 mb-3">

                            <label class="form-label">
                                EmpFormHistID
                            </label>

                            <input type="text" class="form-control readonly-field" value="AUTO" readonly>

                        </div>


                        {{-- EmpFormID --}}
                        <div class="col-md-3 mb-3">

                            <label class="form-label">
                                EmpFormID
                            </label>

                            <input type="text" class="form-control readonly-field" value="AUTO" readonly>

                        </div>


                        {{-- EMPTY --}}
                        <div class="col-md-3 mb-3"></div>

                        {{-- EMPTY --}}
                        <div class="col-md-3 mb-3"></div>

                    </div>


                    {{-- ROW 2 --}}
                    <div class="row">

                        {{-- Request Date --}}
                        <div class="col-md-3 mb-3">

                            <label class="form-label">
                                Request Date
                            </label>

                            <input type="date" name="ReqDate" class="form-control readonly-field"
                                value="{{ old('ReqDate', now()->format('Y-m-d')) }}" readonly>

                        </div>


                        {{-- Employee Form ID --}}
                        <div class="col-md-3 mb-3">

                            <label class="form-label">
                                Employee Form ID
                            </label>

                            <input type="text" class="form-control readonly-field" value="{{ auth()->user()?->EmpFormID ?? '-' }}" readonly>

                        </div>


                        {{-- Employee Status --}}
                        <div class="col-md-3 mb-3">

                            <label class="form-label">
                                Employee Status
                            </label>

                            <input type="text" class="form-control readonly-field" value="NEW" readonly>

                            <input type="hidden" name="EmpStatus" value="NEW">

                        </div>


                        {{-- Transaction Status --}}
                        <div class="col-md-3 mb-3">

                            <label class="form-label">
                                Transaction Status
                            </label>

                            <input type="text" class="form-control readonly-field" value="DRAFT" readonly>

                            <input type="hidden" name="Status" value="DRAFT">

                        </div>

                    </div>

                </div>

            </div>


            {{-- ========================================================= --}}
            {{-- USER INFORMATION --}}
            {{-- ========================================================= --}}

            <div class="card mb-4">

                <div class="card-header">
                    <strong>User Information</strong>
                </div>

                <div class="card-body">

                    {{-- ROW 1 --}}
                    <div class="row">

                        {{-- First Name --}}
                        <div class="col-md-3 mb-3">

                            <label class="form-label">
                                First Name <span class="text-danger">*</span>
                            </label>

                            <input type="text" name="FirstName" id="FirstName" class="form-control"
                                value="{{ old('FirstName') }}" maxlength="300" required>

                        </div>


                        {{-- Last Name --}}
                        <div class="col-md-3 mb-3">

                            <label class="form-label">
                                Last Name
                            </label>

                            <input type="text" name="LastName" id="LastName" class="form-control"
                                value="{{ old('LastName') }}" maxlength="300">

                        </div>


                        {{-- Marital Status --}}
                        <div class="col-md-3 mb-3">

                            <label class="form-label">
                                Marital Status <span class="text-danger">*</span>
                            </label>

                            <select name="MaritalStatus" class="form-select" required>

                                <option value="">
                                    -- Select Marital Status --
                                </option>

                                <option value="S" @selected(old('MaritalStatus') === 'S')>
                                    Single
                                </option>

                                <option value="M" @selected(old('MaritalStatus') === 'M')>
                                    Married
                                </option>

                                <option value="D" @selected(old('MaritalStatus') === 'D')>
                                    Divorce
                                </option>

                            </select>

                        </div>


                        {{-- Religion --}}
                        <div class="col-md-3 mb-3">

                            <label class="form-label">
                                Religion <span class="text-danger">*</span>
                            </label>

                            <select name="ReligionID" class="form-select" required>

                                <option value="">
                                    -- Select Religion --
                                </option>

                                @foreach ($religions as $religion)
                                    <option value="{{ $religion->ReligionID }}" @selected(old('ReligionID') === $religion->ReligionID)>

                                        {{ $religion->Religion }}

                                    </option>
                                @endforeach

                            </select>

                        </div>

                    </div>


                    {{-- ROW 2 --}}
                    <div class="row">

                        {{-- NIP --}}
                        <div class="col-md-3 mb-3">

                            <label class="form-label">
                                NIP <span class="text-danger">*</span>
                            </label>

                            <input type="text" name="NIP" class="form-control" value="{{ old('NIP') }}"
                                inputmode="numeric" maxlength="30" required>

                        </div>


                        {{-- Birth Date --}}
                        <div class="col-md-3 mb-3">

                            <label class="form-label">
                                Birth Date <span class="text-danger">*</span>
                            </label>

                            <input type="date" name="BirthDate" class="form-control" value="{{ old('BirthDate') }}"
                                required>

                        </div>


                        {{-- EMPTY --}}
                        <div class="col-md-3 mb-3"></div>

                        {{-- EMPTY --}}
                        <div class="col-md-3 mb-3"></div>

                    </div>

                </div>

            </div>


            {{-- ========================================================= --}}
            {{-- CONTACT INFORMATION --}}
            {{-- ========================================================= --}}

            <div class="card mb-4">

                <div class="card-header">
                    <strong>Contact Information</strong>
                </div>

                <div class="card-body">

                    {{-- ROW 1 --}}
                    <div class="row">

                        {{-- Country --}}
                        <div class="col-md-3 mb-3">

                            <label class="form-label">
                                Country <span class="text-danger">*</span>
                            </label>

                            <select id="CountryID" class="form-select" required>

                                <option value="">
                                    -- Select Country --
                                </option>

                                @foreach ($countries as $country)
                                    <option value="{{ $country->CountryID }}" @selected(old('CountryID', 'IDN') === $country->CountryID)>

                                        {{ $country->Country }}

                                    </option>
                                @endforeach

                            </select>

                        </div>


                        {{-- Province --}}
                        <div class="col-md-3 mb-3">

                            <label class="form-label">
                                Province <span class="text-danger">*</span>
                            </label>

                            <select id="ProvinceID" class="form-select" required>

                                <option value="">
                                    -- Select Province --
                                </option>

                                @foreach ($provinces as $province)
                                    <option value="{{ $province->ProvinceID }}">
                                        {{ $province->Province }}
                                    </option>
                                @endforeach

                            </select>

                        </div>


                        {{-- City --}}
                        <div class="col-md-3 mb-3">

                            <label class="form-label">
                                City <span class="text-danger">*</span>
                            </label>

                            <select id="CityID" class="form-select" required disabled>

                                <option value="">
                                    -- Select City --
                                </option>

                            </select>

                        </div>


                        {{-- District --}}
                        <div class="col-md-3 mb-3">

                            <label class="form-label">
                                District <span class="text-danger">*</span>
                            </label>

                            <select id="DistrictID" class="form-select" required disabled>

                                <option value="">
                                    -- Select District --
                                </option>

                            </select>

                        </div>

                    </div>


                    {{-- ROW 2 --}}
                    <div class="row">

                        {{-- Village --}}
                        <div class="col-md-3 mb-3">

                            <label class="form-label">
                                Village <span class="text-danger">*</span>
                            </label>

                            <select name="VillageID" id="VillageID" class="form-select" required disabled>

                                <option value="">
                                    -- Select Village --
                                </option>

                            </select>

                        </div>


                        {{-- Mobile --}}
                        <div class="col-md-3 mb-3">

                            <label class="form-label">
                                Mobile No <span class="text-danger">*</span>
                            </label>

                            <div class="input-group">

                                <span class="input-group-text">
                                    +62
                                </span>

                                <input type="text" name="MobileNo" id="MobileNo" class="form-control"
                                    value="{{ old('MobileNo') }}" inputmode="numeric" maxlength="15"
                                    placeholder="81234567890" required>

                            </div>

                        </div>


                        {{-- Email --}}
                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Email Address <span class="text-danger">*</span>
                            </label>

                            <input type="email" name="Email" class="form-control" value="{{ old('Email') }}"
                                placeholder="example@company.com" maxlength="200" required>

                        </div>

                    </div>


                    {{-- ROW 3 --}}
                    <div class="row">

                        <div class="col-md-12 mb-3">

                            <label class="form-label">
                                Address <span class="text-danger">*</span>
                            </label>

                            <textarea name="Address" class="form-control" rows="4" maxlength="1000" required>{{ old('Address') }}</textarea>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ========================================================= --}}
            {{-- EMPLOYMENT INFORMATION --}}
            {{-- ========================================================= --}}

            <div class="card mb-4">

                <div class="card-header">
                    <strong>Employment Information</strong>
                </div>

                <div class="card-body">

                    {{-- ROW 1 --}}
                    <div class="row">

                        {{-- Directorate --}}
                        <div class="col-md-3 mb-3">

                            <label class="form-label">
                                Directorate <span class="text-danger">*</span>
                            </label>

                            <select name="DirID" id="DirID" class="form-select" required>

                                <option value="">
                                    -- Select Directorate --
                                </option>

                                @foreach ($directorates as $directorate)
                                    <option value="{{ $directorate->DirID }}" @selected(old('DirID') == $directorate->DirID)>

                                        {{ $directorate->Directorate }}

                                    </option>
                                @endforeach

                            </select>

                        </div>


                        {{-- Division --}}
                        <div class="col-md-3 mb-3">

                            <label class="form-label">
                                Division <span class="text-danger">*</span>
                            </label>

                            <select name="DivID" id="DivID" class="form-select" required disabled>

                                <option value="">
                                    -- Select Division --
                                </option>

                            </select>

                        </div>


                        {{-- Department --}}
                        <div class="col-md-3 mb-3">

                            <label class="form-label">
                                Department <span class="text-danger">*</span>
                            </label>

                            <select name="DeptID" id="DeptID" class="form-select" required disabled>

                                <option value="">
                                    -- Select Department --
                                </option>

                            </select>

                        </div>

                        {{-- Job Title --}}
                        <div class="col-md-3 mb-3">

                            <label class="form-label">
                                Job Title <span class="text-danger">*</span>
                            </label>

                            <select name="JobTitleID" id="JobTitleID" class="form-select" required>

                                <option value="">
                                    -- Select Job Title --
                                </option>

                                @foreach ($jobTitles as $jobTitle)
                                    <option value="{{ $jobTitle->JobTitleID }}" @selected(old('JobTitleID') == $jobTitle->JobTitleID)>

                                        {{ $jobTitle->JobTitle }}

                                    </option>
                                @endforeach

                            </select>

                        </div>

                    </div>


                    {{-- ROW 2 --}}
                    <div class="row">

                        {{-- Job Level --}}
                        <div class="col-md-3 mb-3">

                            <label class="form-label">
                                Job Level <span class="text-danger">*</span>
                            </label>

                            <select name="JobLvlID" class="form-select" required>

                                <option value="">
                                    -- Select Job Level --
                                </option>

                                @foreach ($jobLevels as $jobLevel)
                                    <option value="{{ $jobLevel->JobLevelID }}" @selected(old('JobLvlID') == $jobLevel->JobLevelID)>

                                        {{ $jobLevel->JobLevel }}

                                    </option>
                                @endforeach

                            </select>

                        </div>

                        {{-- Report To --}}
                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Report To
                            </label>

                            <select name="ReportTo" id="ReportTo" class="form-select" disabled>

                                <option value="">
                                    -- Select Directorate, Division & Department --
                                </option>

                            </select>

                        </div>


                        {{-- Effective Date --}}
                        <div class="col-md-3 mb-3">

                            <label class="form-label">
                                Effective Date <span class="text-danger">*</span>
                            </label>

                            <input type="date" name="EffectiveDate" class="form-control"
                                value="{{ old('EffectiveDate', now()->format('Y-m-d')) }}" required>

                        </div>


                        {{-- EMPTY --}}
                        <div class="col-md-3 mb-3"></div>

                    </div>


                    {{-- ROW 3 --}}
                    <div class="row">

                        <div class="col-md-12 mb-3">

                            <label class="form-label">
                                Remarks <span class="text-danger">*</span>
                            </label>

                            <textarea name="Remarks" class="form-control" rows="3" maxlength="1000" required>{{ old('Remarks') }}</textarea>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ========================================================= --}}
            {{-- ACTION --}}
            {{-- ========================================================= --}}

            <div class="d-flex justify-content-end gap-2">

                <a href="{{ route('employee-form.index') }}" class="btn btn-secondary">

                    Cancel

                </a>

                <button type="submit" class="btn btn-primary">

                    <i class="bi bi-save"></i>
                    Save Employee Form

                </button>

            </div>

        </form>

    </div>

@endsection


@push('styles')
    <style>
        .readonly-field {
            background-color: #e9ecef !important;
            color: #495057 !important;
            cursor: not-allowed;
        }
    </style>
@endpush


@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            /*
            |--------------------------------------------------------------------------
            | NAME
            |--------------------------------------------------------------------------
            */

            function capitalizeWords(value) {

                return value
                    .toLowerCase()
                    .replace(/\b\w/g, function(char) {
                        return char.toUpperCase();
                    });

            }

            const firstName = document.getElementById('FirstName');
            const lastName = document.getElementById('LastName');

            firstName?.addEventListener('input', function() {
                this.value = capitalizeWords(this.value);
            });

            lastName?.addEventListener('input', function() {
                this.value = capitalizeWords(this.value);
            });


            /*
            |--------------------------------------------------------------------------
            | MOBILE
            |--------------------------------------------------------------------------
            */

            const mobileInput =
                document.getElementById('MobileNo');

            mobileInput?.addEventListener('input', function() {

                let value =
                    this.value.replace(/\D/g, '');

                value = value.replace(/^0+/, '');

                if (value.startsWith('62')) {
                    value = value.substring(2);
                }

                this.value = value;

            });


            /*
            |--------------------------------------------------------------------------
            | ADDRESS CASCADING
            |--------------------------------------------------------------------------
            */

            const country =
                document.getElementById('CountryID');

            const province =
                document.getElementById('ProvinceID');

            const city =
                document.getElementById('CityID');

            const district =
                document.getElementById('DistrictID');

            const village =
                document.getElementById('VillageID');


            function resetSelect(select, placeholder) {

                select.innerHTML =
                    `<option value="">${placeholder}</option>`;

                select.disabled = true;

            }


            country?.addEventListener('change', async function() {

                resetSelect(
                    province,
                    '-- Select Province --'
                );

                resetSelect(
                    city,
                    '-- Select City --'
                );

                resetSelect(
                    district,
                    '-- Select District --'
                );

                resetSelect(
                    village,
                    '-- Select Village --'
                );

                if (!this.value) {
                    return;
                }

                const response = await fetch(
                    `{{ url('/employee-form/provinces') }}/${this.value}`
                );

                const data = await response.json();

                province.disabled = false;

                data.forEach(function(item) {

                    province.insertAdjacentHTML(
                        'beforeend',
                        `<option value="${item.ProvinceID}">
                    ${item.Province}
                </option>`
                    );

                });

            });


            province?.addEventListener('change', async function() {

                resetSelect(
                    city,
                    '-- Select City --'
                );

                resetSelect(
                    district,
                    '-- Select District --'
                );

                resetSelect(
                    village,
                    '-- Select Village --'
                );

                if (!this.value) {
                    return;
                }

                const response = await fetch(
                    `{{ url('/employee-form/cities') }}/${this.value}`
                );

                const data = await response.json();

                city.disabled = false;

                data.forEach(function(item) {

                    city.insertAdjacentHTML(
                        'beforeend',
                        `<option value="${item.CityID}">
                    ${item.City}
                </option>`
                    );

                });

            });


            city?.addEventListener('change', async function() {

                resetSelect(
                    district,
                    '-- Select District --'
                );

                resetSelect(
                    village,
                    '-- Select Village --'
                );

                if (!this.value) {
                    return;
                }

                const response = await fetch(
                    `{{ url('/employee-form/districts') }}/${this.value}`
                );

                const data = await response.json();

                district.disabled = false;

                data.forEach(function(item) {

                    district.insertAdjacentHTML(
                        'beforeend',
                        `<option value="${item.DistrictID}">
                    ${item.District}
                </option>`
                    );

                });

            });


            district?.addEventListener('change', async function() {

                resetSelect(
                    village,
                    '-- Select Village --'
                );

                if (!this.value) {
                    return;
                }

                const response = await fetch(
                    `{{ url('/employee-form/villages') }}/${this.value}`
                );

                const data = await response.json();

                village.disabled = false;

                data.forEach(function(item) {

                    village.insertAdjacentHTML(
                        'beforeend',
                        `<option value="${item.VillageID}">
                    ${item.Village}
                </option>`
                    );

                });

            });


            /*
            |--------------------------------------------------------------------------
            | ORGANIZATION
            |--------------------------------------------------------------------------
            */

            const directorate =
                document.getElementById('DirID');

            const division =
                document.getElementById('DivID');

            const department =
                document.getElementById('DeptID');

            const reportTo =
                document.getElementById('ReportTo');


            function resetOrganizationSelect(
                select,
                placeholder
            ) {

                select.innerHTML =
                    `<option value="">${placeholder}</option>`;

                select.disabled = true;

            }


            directorate?.addEventListener(
                'change',
                async function() {

                    resetOrganizationSelect(
                        division,
                        '-- Select Division --'
                    );

                    resetOrganizationSelect(
                        department,
                        '-- Select Department --'
                    );

                    resetOrganizationSelect(
                        reportTo,
                        '-- Select Directorate, Division & Department --'
                    );

                    if (!this.value) {
                        return;
                    }

                    const response = await fetch(
                        `{{ url('/employee-form/divisions') }}/${this.value}`
                    );

                    const data = await response.json();

                    division.disabled = false;

                    data.forEach(function(item) {

                        division.insertAdjacentHTML(
                            'beforeend',
                            `<option value="${item.DivID}">
                        ${item.Division}
                    </option>`
                        );

                    });

                }
            );


            division?.addEventListener(
                'change',
                async function() {

                    resetOrganizationSelect(
                        department,
                        '-- Select Department --'
                    );

                    resetOrganizationSelect(
                        reportTo,
                        '-- Select Directorate, Division & Department --'
                    );

                    if (!this.value) {
                        return;
                    }

                    const response = await fetch(
                        `{{ url('/employee-form/departments') }}/${this.value}`
                    );

                    const data = await response.json();

                    department.disabled = false;

                    data.forEach(function(item) {

                        department.insertAdjacentHTML(
                            'beforeend',
                            `<option value="${item.DeptID}">
                        ${item.Department}
                    </option>`
                        );

                    });

                }
            );


            /*
            |--------------------------------------------------------------------------
            | REPORT TO
            |--------------------------------------------------------------------------
            */

            async function loadReportTo() {

                resetOrganizationSelect(
                    reportTo,
                    '-- Loading Report To --'
                );

                const jobTitle =
                    document.getElementById('JobTitleID');

                if (
                    !directorate?.value ||
                    !jobTitle?.value
                ) {
                    reportTo.innerHTML =
                        `<option value="">-- Select Job Title --</option>`;
                    reportTo.disabled = true;
                    return;
                }

                const params = new URLSearchParams({
                    directorateId: directorate.value,
                    divisionId: division?.value || '',
                    departmentId: department?.value || '',
                    jobTitleId: jobTitle.value,
                });

                try {
                    const response = await fetch(
                        `{{ url('/employee-form/report-to') }}?${params.toString()}`, {
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest',
                            },
                        }
                    );

                    if (!response.ok) {
                        throw new Error(`HTTP ${response.status}`);
                    }

                    const data = await response.json();

                    reportTo.innerHTML =
                        `<option value="">-- Select Report To --</option>`;

                    data.forEach(function(item) {
                        reportTo.insertAdjacentHTML(
                            'beforeend',
                            `<option value="${item.UserID}">${item.FullName + ' (' + item.JobTitle + ')'}</option>`
                        );
                    });

                    reportTo.disabled = data.length === 0;

                    if (data.length === 0) {
                        reportTo.innerHTML =
                            `<option value="">-- No Report To Available --</option>`;
                    }

                } catch (error) {
                    console.error('Failed to load Report To:', error);
                    reportTo.innerHTML =
                        `<option value="">-- Failed to load Report To --</option>`;
                    reportTo.disabled = true;
                }
            }

            department?.addEventListener('change', loadReportTo);

            document
                .getElementById('JobTitleID')
                ?.addEventListener('change', loadReportTo);
        });
    </script>
@endpush
