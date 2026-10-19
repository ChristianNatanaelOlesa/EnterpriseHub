@extends('layouts.app')

@section('content')

    <div class="container-fluid">

        {{-- ========================================================= --}}
        {{-- HEADER --}}
        {{-- ========================================================= --}}

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h4 class="mb-1">
                    Edit Employee Form Request
                </h4>

                <div class="text-muted">
                    {{ $employeeForm->EmpFormID }}
                </div>

            </div>

            <a href="{{ route('employee-form.index') }}" class="btn btn-secondary">

                <i class="bi bi-arrow-left"></i>
                Back

            </a>

        </div>


        {{-- ========================================================= --}}
        {{-- VALIDATION --}}
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


        @php

            $effectiveDateValue = optional($history?->EffectiveDate)->format('Y-m-d');

            $mobileValue = $employeeForm->MobileNo ?? '';

            if (str_starts_with($mobileValue, '+62')) {
                $mobileValue = substr($mobileValue, 3);
            }

        @endphp


        <form action="{{ route('employee-form.update', $employeeForm->EmpFormID) }}" method="POST">

            @csrf
            @method('PUT')


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

                            <input type="text" class="form-control readonly-field"
                                value="{{ $history?->EmpFormHistID ?? '-' }}" readonly>

                        </div>


                        {{-- EmpFormID --}}
                        <div class="col-md-3 mb-3">

                            <label class="form-label">
                                EmpFormID
                            </label>

                            <input type="text" class="form-control readonly-field" value="{{ $employeeForm->EmpFormID }}"
                                readonly>

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

                            <input type="date" class="form-control readonly-field"
                                value="{{ optional($history?->ReqDate)->format('Y-m-d') }}" readonly>

                        </div>


                        {{-- Employee Form ID --}}
                        <div class="col-md-3 mb-3">

                            <label class="form-label">
                                Employee Form ID
                            </label>

                            <input type="text" class="form-control readonly-field"
                                value="{{ $history?->EmpFormID ?? '-' }}" readonly>

                        </div>


                        {{-- Employee Status --}}
                        <div class="col-md-3 mb-3">

                            <label class="form-label">
                                Employee Status
                            </label>

                            <input type="text" class="form-control readonly-field"
                                value="{{ $history?->EmpStatus ?? 'NEW' }}" readonly>

                            <input type="hidden" name="EmpStatus" value="{{ $history?->EmpStatus ?? 'NEW' }}">

                        </div>


                        {{-- Transaction Status --}}
                        <div class="col-md-3 mb-3">

                            <label class="form-label">
                                Transaction Status
                            </label>

                            <input type="text" class="form-control readonly-field"
                                value="{{ $history?->Status ?? 'DRAFT' }}" readonly>

                            <input type="hidden" name="Status" value="{{ $history?->Status ?? 'DRAFT' }}">

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
                                value="{{ old('FirstName', $employeeForm->FirstName) }}" maxlength="300" required>

                        </div>


                        {{-- Last Name --}}
                        <div class="col-md-3 mb-3">

                            <label class="form-label">
                                Last Name
                            </label>

                            <input type="text" name="LastName" id="LastName" class="form-control"
                                value="{{ old('LastName', $employeeForm->LastName) }}" maxlength="300">

                        </div>


                        {{-- Marital --}}
                        <div class="col-md-3 mb-3">

                            <label class="form-label">
                                Marital Status <span class="text-danger">*</span>
                            </label>

                            <select name="MaritalStatus" class="form-select" required>

                                <option value="">
                                    -- Select Marital Status --
                                </option>

                                <option value="S" @selected(old('MaritalStatus', $employeeForm->MaritalStatus) === 'S')>
                                    Single
                                </option>

                                <option value="M" @selected(old('MaritalStatus', $employeeForm->MaritalStatus) === 'M')>
                                    Married
                                </option>

                                <option value="D" @selected(old('MaritalStatus', $employeeForm->MaritalStatus) === 'D')>
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
                                    <option value="{{ $religion->ReligionID }}" @selected(old('ReligionID', $employeeForm->ReligionID) == $religion->ReligionID)>

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

                            <input type="text" name="NIP" class="form-control"
                                value="{{ old('NIP', $employeeForm->NIP) }}" inputmode="numeric" maxlength="30" required>

                        </div>


                        {{-- Birth Date --}}
                        <div class="col-md-3 mb-3">

                            <label class="form-label">
                                Birth Date <span class="text-danger">*</span>
                            </label>

                            <input type="date" name="BirthDate" class="form-control"
                                value="{{ old('BirthDate', optional($employeeForm->BirthDate)->format('Y-m-d')) }}"
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

                                @foreach ($countries as $country)
                                    <option value="{{ $country->CountryID }}" @selected($country->CountryID === ($province?->CountryID ?? 'IDN'))>

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

                                @foreach ($provinces as $provinceItem)
                                    <option value="{{ $provinceItem->ProvinceID }}" @selected(old('ProvinceID', $province?->ProvinceID) == $provinceItem->ProvinceID)>

                                        {{ $provinceItem->Province }}

                                    </option>
                                @endforeach

                            </select>

                        </div>


                        {{-- City --}}
                        <div class="col-md-3 mb-3">

                            <label class="form-label">
                                City <span class="text-danger">*</span>
                            </label>

                            <select id="CityID" class="form-select" required>

                                <option value="">
                                    -- Select City --
                                </option>

                                @foreach ($cities as $cityItem)
                                    <option value="{{ $cityItem->CityID }}" @selected(old('CityID', $city?->CityID) == $cityItem->CityID)>

                                        {{ $cityItem->City }}

                                    </option>
                                @endforeach

                            </select>

                        </div>


                        {{-- District --}}
                        <div class="col-md-3 mb-3">

                            <label class="form-label">
                                District <span class="text-danger">*</span>
                            </label>

                            <select id="DistrictID" class="form-select" required>

                                <option value="">
                                    -- Select District --
                                </option>

                                @foreach ($districts as $districtItem)
                                    <option value="{{ $districtItem->DistrictID }}" @selected(old('DistrictID', $district?->DistrictID) == $districtItem->DistrictID)>

                                        {{ $districtItem->District }}

                                    </option>
                                @endforeach

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

                            <select name="VillageID" id="VillageID" class="form-select" required>

                                <option value="">
                                    -- Select Village --
                                </option>

                                @foreach ($villages as $villageItem)
                                    <option value="{{ $villageItem->VillageID }}" @selected(old('VillageID', $employeeForm->VillageID) == $villageItem->VillageID)>

                                        {{ $villageItem->Village }}

                                    </option>
                                @endforeach

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
                                    value="{{ old('MobileNo', $mobileValue) }}" inputmode="numeric" maxlength="15"
                                    required>

                            </div>

                        </div>


                        {{-- Email --}}
                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Email Address <span class="text-danger">*</span>
                            </label>

                            <input type="email" name="Email" class="form-control"
                                value="{{ old('Email', $employeeForm->Email) }}" maxlength="200" required>

                        </div>

                    </div>


                    {{-- ROW 3 --}}
                    <div class="row">

                        <div class="col-md-12 mb-3">

                            <label class="form-label">
                                Address <span class="text-danger">*</span>
                            </label>

                            <textarea name="Address" class="form-control" rows="4" maxlength="1000" required>{{ old('Address', $employeeForm->Address) }}</textarea>

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
                                    <option value="{{ $directorate->DirID }}" @selected(old('DirID', $history?->DirID) == $directorate->DirID)>

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

                            <select name="DivID" id="DivID" class="form-select" required>

                                <option value="">
                                    -- Select Division --
                                </option>

                                @foreach ($divisions as $division)
                                    <option value="{{ $division->DivID }}" @selected(old('DivID', $history?->DivID) == $division->DivID)>

                                        {{ $division->Division }}

                                    </option>
                                @endforeach

                            </select>

                        </div>


                        {{-- Department --}}
                        <div class="col-md-3 mb-3">

                            <label class="form-label">
                                Department <span class="text-danger">*</span>
                            </label>

                            <select name="DeptID" id="DeptID" class="form-select" required>

                                <option value="">
                                    -- Select Department --
                                </option>

                                @foreach ($departments as $department)
                                    <option value="{{ $department->DeptID }}" @selected(old('DeptID', $history?->DeptID) == $department->DeptID)>

                                        {{ $department->Department }}

                                    </option>
                                @endforeach

                            </select>

                        </div>


                        {{-- Report To --}}
                        <div class="col-md-3 mb-3">

                            <label class="form-label">
                                Report To
                            </label>

                            <select name="ReportTo" id="ReportTo" class="form-select" disabled>

                                <option value="">
                                    -- Loading Report To --
                                </option>

                            </select>

                        </div>

                    </div>


                    {{-- ROW 2 --}}
                    <div class="row">

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
                                    <option value="{{ $jobTitle->JobTitleID }}" @selected(old('JobTitleID', $history?->JobTitleID) == $jobTitle->JobTitleID)>

                                        {{ $jobTitle->JobTitle }}

                                    </option>
                                @endforeach

                            </select>

                        </div>


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
                                    <option value="{{ $jobLevel->JobLevelID }}" @selected(old('JobLvlID', $history?->JobLvlID) == $jobLevel->JobLevelID)>

                                        {{ $jobLevel->JobLevel }}

                                    </option>
                                @endforeach

                            </select>

                        </div>


                        {{-- Effective Date --}}
                        <div class="col-md-3 mb-3">

                            <label class="form-label">
                                Effective Date <span class="text-danger">*</span>
                            </label>

                            <input type="date" class="form-control readonly-field" value="{{ $effectiveDateValue }}"
                                disabled>

                            <input type="hidden" name="EffectiveDate" value="{{ $effectiveDateValue }}">

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

                            <textarea name="Remarks" class="form-control" rows="3" maxlength="1000" required>{{ old('Remarks', $history?->Remarks) }}</textarea>

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
                    Update Employee Form

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

            document
                .getElementById('FirstName')
                ?.addEventListener('input', function() {

                    this.value =
                        capitalizeWords(this.value);

                });


            document
                .getElementById('LastName')
                ?.addEventListener('input', function() {

                    this.value =
                        capitalizeWords(this.value);

                });


            /*
            |--------------------------------------------------------------------------
            | MOBILE
            |--------------------------------------------------------------------------
            */

            const mobileInput =
                document.getElementById('MobileNo');

            mobileInput?.addEventListener(
                'input',
                function() {

                    let value =
                        this.value.replace(/\D/g, '');

                    value =
                        value.replace(/^0+/, '');

                    if (value.startsWith('62')) {
                        value =
                            value.substring(2);
                    }

                    this.value = value;

                }
            );


            /*
            |--------------------------------------------------------------------------
            | ADDRESS
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


            function resetSelect(
                select,
                placeholder
            ) {

                select.innerHTML =
                    `<option value="">${placeholder}</option>`;

                select.disabled = true;

            }


            async function loadAddressOptions(
                url,
                select,
                valueField,
                textField,
                selectedValue = null
            ) {

                const response =
                    await fetch(url);

                const data =
                    await response.json();

                select.innerHTML =
                    '<option value="">-- Select --</option>';

                data.forEach(function(item) {

                    const option =
                        document.createElement('option');

                    option.value =
                        item[valueField];

                    option.textContent =
                        item[textField];

                    if (
                        selectedValue !== null &&
                        String(item[valueField]) ===
                        String(selectedValue)
                    ) {

                        option.selected = true;

                    }

                    select.appendChild(option);

                });

                select.disabled = false;

            }


            country?.addEventListener(
                'change',
                async function() {

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

                    await loadAddressOptions(
                        `{{ url('/employee-form/provinces') }}/${this.value}`,
                        province,
                        'ProvinceID',
                        'Province'
                    );

                }
            );


            province?.addEventListener(
                'change',
                async function() {

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

                    await loadAddressOptions(
                        `{{ url('/employee-form/cities') }}/${this.value}`,
                        city,
                        'CityID',
                        'City'
                    );

                }
            );


            city?.addEventListener(
                'change',
                async function() {

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

                    await loadAddressOptions(
                        `{{ url('/employee-form/districts') }}/${this.value}`,
                        district,
                        'DistrictID',
                        'District'
                    );

                }
            );


            district?.addEventListener(
                'change',
                async function() {

                    resetSelect(
                        village,
                        '-- Select Village --'
                    );

                    if (!this.value) {
                        return;
                    }

                    await loadAddressOptions(
                        `{{ url('/employee-form/villages') }}/${this.value}`,
                        village,
                        'VillageID',
                        'Village'
                    );

                }
            );


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

                    const data =
                        await response.json();

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

                    const data =
                        await response.json();

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
                        `{{ url('/employee-form/report-to') }}?${params.toString()}`,
                        {
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
                    const currentReportTo = @json($history?->ReportTo);

                    reportTo.innerHTML =
                        `<option value="">-- Select Report To --</option>`;

                    data.forEach(function(item) {
                        const option = document.createElement('option');
                        option.value = item.UserID;
                        option.textContent = item.FullName;
                        option.selected =
                            String(item.UserID) === String(currentReportTo);
                        reportTo.appendChild(option);
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

            loadReportTo();

            }

        });
    </script>
@endpush
