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

        <a href="{{ route('employee-form.index') }}"
           class="btn btn-secondary">

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


    <form action="{{ route(
        'employee-form.update',
        $employeeForm->EmpFormID
    ) }}"
          method="POST">

        @csrf
        @method('PUT')


        {{-- ========================================================= --}}
        {{-- PERSONAL INFORMATION --}}
        {{-- ========================================================= --}}

        <div class="card mb-4">

            <div class="card-header">
                <strong>Personal Information</strong>
            </div>

            <div class="card-body">

                <div class="row">

                    {{-- First Name --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            First Name <span class="text-danger">*</span>
                        </label>

                        <input type="text"
                               name="FirstName"
                               id="FirstName"
                               class="form-control"
                               value="{{ old(
                                   'FirstName',
                                   $employeeForm->FirstName
                               ) }}"
                               maxlength="300"
                               required>

                    </div>


                    {{-- Last Name --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Last Name
                        </label>

                        <input type="text"
                               name="LastName"
                               id="LastName"
                               class="form-control"
                               value="{{ old(
                                   'LastName',
                                   $employeeForm->LastName
                               ) }}"
                               maxlength="300">

                    </div>


                    {{-- Mobile --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Mobile No <span class="text-danger">*</span>
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                +62
                            </span>

                            @php
                                $mobileValue = $employeeForm->MobileNo ?? '';

                                if (str_starts_with($mobileValue, '+62')) {
                                    $mobileValue = substr($mobileValue, 3);
                                }
                            @endphp

                            <input type="text"
                                   name="MobileNo"
                                   id="MobileNo"
                                   class="form-control"
                                   value="{{ old(
                                       'MobileNo',
                                       $mobileValue
                                   ) }}"
                                   inputmode="numeric"
                                   maxlength="15"
                                   placeholder="81234567890"
                                   required>

                        </div>

                        <small class="text-muted">
                            Enter the number without the leading 0.
                        </small>

                    </div>


                    {{-- Birth Date --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Birth Date <span class="text-danger">*</span>
                        </label>

                        <input type="date"
                               name="BirthDate"
                               class="form-control"
                               value="{{ old(
                                   'BirthDate',
                                   optional($employeeForm->BirthDate)
                                       ->format('Y-m-d')
                               ) }}"
                               required>

                    </div>


                    {{-- NIP --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            NIP <span class="text-danger">*</span>
                        </label>

                        <input type="text"
                               name="NIP"
                               class="form-control"
                               value="{{ old(
                                   'NIP',
                                   $employeeForm->NIP
                               ) }}"
                               inputmode="numeric"
                               maxlength="30"
                               required>

                    </div>


                    {{-- Marital Status --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Marital Status <span class="text-danger">*</span>
                        </label>

                        <select name="MaritalStatus"
                                class="form-select"
                                required>

                            <option value="">
                                -- Select Marital Status --
                            </option>

                            <option value="S"
                                @selected(
                                    old(
                                        'MaritalStatus',
                                        $employeeForm->MaritalStatus
                                    ) === 'S'
                                )>
                                Single
                            </option>

                            <option value="M"
                                @selected(
                                    old(
                                        'MaritalStatus',
                                        $employeeForm->MaritalStatus
                                    ) === 'M'
                                )>
                                Married
                            </option>

                            <option value="D"
                                @selected(
                                    old(
                                        'MaritalStatus',
                                        $employeeForm->MaritalStatus
                                    ) === 'D'
                                )>
                                Divorce
                            </option>

                        </select>

                    </div>


                    {{-- Religion --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Religion <span class="text-danger">*</span>
                        </label>

                        <select name="ReligionID"
                                class="form-select"
                                required>

                            <option value="">
                                -- Select Religion --
                            </option>

                            @foreach ($religions as $religion)

                                <option value="{{ $religion->ReligionID }}"
                                    @selected(
                                        old(
                                            'ReligionID',
                                            $employeeForm->ReligionID
                                        ) == $religion->ReligionID
                                    )>

                                    {{ $religion->Religion }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Join Date --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Join Date <span class="text-danger">*</span>
                        </label>

                        <input type="date"
                               name="JoinDate"
                               class="form-control"
                               value="{{ old(
                                   'JoinDate',
                                   optional($employeeForm->JoinDate)
                                       ->format('Y-m-d')
                               ) }}"
                               required>

                    </div>

                </div>

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- ADDRESS --}}
        {{-- ========================================================= --}}

        <div class="card mb-4">

            <div class="card-header">
                <strong>Address</strong>
            </div>

            <div class="card-body">

                <div class="row">

                    {{-- Country --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Country <span class="text-danger">*</span>
                        </label>

                        <select id="CountryID"
                                class="form-select"
                                required>

                            <option value="">
                                -- Select Country --
                            </option>

                            @foreach ($countries as $country)

                                <option value="{{ $country->CountryID }}"
                                    @selected(
                                        $country->CountryID === 'IDN'
                                    )>

                                    {{ $country->Country }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Province --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Province <span class="text-danger">*</span>
                        </label>

                        <select id="ProvinceID"
                                class="form-select"
                                required>

                            <option value="">
                                -- Select Province --
                            </option>

                            @foreach ($provinces as $provinceItem)

                                <option value="{{ $provinceItem->ProvinceID }}"
                                    @selected(
                                        old(
                                            'ProvinceID',
                                            $province?->ProvinceID
                                        ) == $provinceItem->ProvinceID
                                    )>

                                    {{ $provinceItem->Province }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- City --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            City <span class="text-danger">*</span>
                        </label>

                        <select id="CityID"
                                class="form-select"
                                required>

                            <option value="">
                                -- Select City --
                            </option>

                            @foreach ($cities as $cityItem)

                                <option value="{{ $cityItem->CityID }}"
                                    @selected(
                                        old(
                                            'CityID',
                                            $city?->CityID
                                        ) == $cityItem->CityID
                                    )>

                                    {{ $cityItem->City }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- District --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            District <span class="text-danger">*</span>
                        </label>

                        <select id="DistrictID"
                                class="form-select"
                                required>

                            <option value="">
                                -- Select District --
                            </option>

                            @foreach ($districts as $districtItem)

                                <option value="{{ $districtItem->DistrictID }}"
                                    @selected(
                                        old(
                                            'DistrictID',
                                            $district?->DistrictID
                                        ) == $districtItem->DistrictID
                                    )>

                                    {{ $districtItem->District }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Village --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Village <span class="text-danger">*</span>
                        </label>

                        <select name="VillageID"
                                id="VillageID"
                                class="form-select"
                                required>

                            <option value="">
                                -- Select Village --
                            </option>

                            @foreach ($villages as $villageItem)

                                <option value="{{ $villageItem->VillageID }}"
                                    @selected(
                                        old(
                                            'VillageID',
                                            $employeeForm->VillageID
                                        ) == $villageItem->VillageID
                                    )>

                                    {{ $villageItem->Village }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Email --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Email <span class="text-danger">*</span>
                        </label>

                        <input type="email"
                               name="Email"
                               class="form-control"
                               value="{{ old(
                                   'Email',
                                   $employeeForm->Email
                               ) }}"
                               placeholder="example@company.com"
                               maxlength="200"
                               required>

                    </div>


                    {{-- Address --}}
                    <div class="col-12 mb-3">

                        <label class="form-label">
                            Address <span class="text-danger">*</span>
                        </label>

                        <textarea name="Address"
                                  class="form-control"
                                  rows="4"
                                  maxlength="1000"
                                  required>{{ old(
                                      'Address',
                                      $employeeForm->Address
                                  ) }}</textarea>

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

                <div class="row">

                    {{-- Directorate --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Directorate <span class="text-danger">*</span>
                        </label>

                        <select name="DirID"
                                id="DirectorateID"
                                class="form-select"
                                required>

                            <option value="">
                                -- Select Directorate --
                            </option>

                            @foreach ($directorates as $directorate)

                                <option value="{{ $directorate->DirectorateID }}"
                                    @selected(
                                        old(
                                            'DirID',
                                            $history?->DirID
                                        ) == $directorate->DirectorateID
                                    )>

                                    {{ $directorate->DirectorateName }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Division --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Division <span class="text-danger">*</span>
                        </label>

                        <select name="DivID"
                                id="DivisionID"
                                class="form-select"
                                required>

                            <option value="">
                                -- Select Division --
                            </option>

                            @foreach ($divisions as $division)

                                <option value="{{ $division->DivisionID }}"
                                    @selected(
                                        old(
                                            'DivID',
                                            $history?->DivID
                                        ) == $division->DivisionID
                                    )>

                                    {{ $division->DivisionName }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Department --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Department <span class="text-danger">*</span>
                        </label>

                        <select name="DeptID"
                                id="DepartmentID"
                                class="form-select"
                                required>

                            <option value="">
                                -- Select Department --
                            </option>

                            @foreach ($departments as $department)

                                <option value="{{ $department->DepartmentID }}"
                                    @selected(
                                        old(
                                            'DeptID',
                                            $history?->DeptID
                                        ) == $department->DepartmentID
                                    )>

                                    {{ $department->DepartmentName }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Job Level --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Job Level <span class="text-danger">*</span>
                        </label>

                        <select name="JobLvlID"
                                class="form-select"
                                required>

                            <option value="">
                                -- Select Job Level --
                            </option>

                            @foreach ($jobLevels as $jobLevel)

                                <option value="{{ $jobLevel->JobLevelID }}"
                                    @selected(
                                        old(
                                            'JobLvlID',
                                            $history?->JobLvlID
                                        ) == $jobLevel->JobLevelID
                                    )>

                                    {{ $jobLevel->JobLevel }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Job Title --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Job Title <span class="text-danger">*</span>
                        </label>

                        <select name="JobTitleID"
                                class="form-select"
                                required>

                            <option value="">
                                -- Select Job Title --
                            </option>

                            @foreach ($jobTitles as $jobTitle)

                                <option value="{{ $jobTitle->JobTitleID }}"
                                    @selected(
                                        old(
                                            'JobTitleID',
                                            $history?->JobTitleID
                                        ) == $jobTitle->JobTitleID
                                    )>

                                    {{ $jobTitle->JobTitle }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Employee Status --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Employee Status
                        </label>

                        <input type="text"
                               class="form-control"
                               value="NEW"
                               readonly>

                        <input type="hidden"
                               name="EmpStatus"
                               value="NEW">

                    </div>


                    {{-- Report To --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Report To
                        </label>

                        <input type="text"
                               name="ReportTo"
                               class="form-control"
                               value="{{ old(
                                   'ReportTo',
                                   $history?->ReportTo
                               ) }}"
                               maxlength="3"
                               placeholder="Enter Report To">

                    </div>


                    {{-- Effective Date --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Effective Date <span class="text-danger">*</span>
                        </label>

                        @php
                            $effectiveDateValue = optional(
                                $history?->EffectiveDate
                            )->format('Y-m-d');
                        @endphp

                        <input type="date"
                               class="form-control"
                               value="{{ $effectiveDateValue }}"
                               disabled>

                        <input type="hidden"
                               name="EffectiveDate"
                               value="{{ $effectiveDateValue }}">

                    </div>


                    {{-- Remarks --}}
                    <div class="col-12 mb-3">

                        <label class="form-label">
                            Remarks <span class="text-danger">*</span>
                        </label>

                        <textarea name="Remarks"
                                  class="form-control"
                                  rows="3"
                                  maxlength="1000"
                                  required>{{ old(
                                      'Remarks',
                                      $history?->Remarks
                                  ) }}</textarea>

                    </div>

                </div>

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- ACTION --}}
        {{-- ========================================================= --}}

        <div class="d-flex justify-content-end gap-2">

            <a href="{{ route('employee-form.index') }}"
               class="btn btn-secondary">

                Cancel

            </a>

            <button type="submit"
                    class="btn btn-primary">

                <i class="bi bi-save"></i>

                Update Employee Form

            </button>

        </div>

    </form>

</div>
@endsection


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // =========================================================
    // NAME
    // =========================================================

    function capitalizeWords(value) {
        return value
            .toLowerCase()
            .replace(/\b\w/g, function (char) {
                return char.toUpperCase();
            });
    }

    const firstName = document.getElementById('FirstName');
    const lastName = document.getElementById('LastName');

    if (firstName) {
        firstName.addEventListener('input', function () {
            this.value = capitalizeWords(this.value);
        });
    }

    if (lastName) {
        lastName.addEventListener('input', function () {
            this.value = capitalizeWords(this.value);
        });
    }


    // =========================================================
    // MOBILE
    // =========================================================

    const mobileInput = document.getElementById('MobileNo');

    if (mobileInput) {

        mobileInput.addEventListener('input', function () {

            let value = this.value.replace(/\D/g, '');

            value = value.replace(/^0+/, '');

            if (value.startsWith('62')) {
                value = value.substring(2);
            }

            this.value = value;
        });
    }


    // =========================================================
    // ADDRESS
    // =========================================================

    const country = document.getElementById('CountryID');
    const province = document.getElementById('ProvinceID');
    const city = document.getElementById('CityID');
    const district = document.getElementById('DistrictID');
    const village = document.getElementById('VillageID');


    function resetSelect(select, placeholder) {

        select.innerHTML = `
            <option value="">${placeholder}</option>
        `;

        select.disabled = true;
    }


    async function loadAddressOptions(
        url,
        select,
        valueField,
        textField,
        selectedValue = null
    ) {

        try {

            const response = await fetch(url);

            if (!response.ok) {
                throw new Error('Failed to load data.');
            }

            const data = await response.json();

            data.forEach(function (item) {

                const option = document.createElement('option');

                option.value = item[valueField];
                option.textContent = item[textField];

                if (
                    selectedValue !== null &&
                    String(item[valueField]) === String(selectedValue)
                ) {
                    option.selected = true;
                }

                select.appendChild(option);
            });

            select.disabled = false;

        } catch (error) {

            console.error(error);

            select.innerHTML = `
                <option value="">Failed to load data</option>
            `;
        }
    }


    // =========================================================
    // COUNTRY -> PROVINCE
    // =========================================================

    country.addEventListener('change', async function () {

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
    });


    // =========================================================
    // PROVINCE -> CITY
    // =========================================================

    province.addEventListener('change', async function () {

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
    });


    // =========================================================
    // CITY -> DISTRICT
    // =========================================================

    city.addEventListener('change', async function () {

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
    });


    // =========================================================
    // DISTRICT -> VILLAGE
    // =========================================================

    district.addEventListener('change', async function () {

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
    });


    // =========================================================
    // ORGANIZATION
    // =========================================================

    const directorate = document.getElementById('DirectorateID');
    const division = document.getElementById('DivisionID');
    const department = document.getElementById('DepartmentID');


    async function loadOrganizationOptions(
        url,
        select,
        valueField,
        textField,
        selectedValue = null
    ) {

        try {

            const response = await fetch(url);

            if (!response.ok) {
                throw new Error('Failed to load organization data.');
            }

            const data = await response.json();

            data.forEach(function (item) {

                const option = document.createElement('option');

                option.value = item[valueField];
                option.textContent = item[textField];

                if (
                    selectedValue !== null &&
                    String(item[valueField]) === String(selectedValue)
                ) {
                    option.selected = true;
                }

                select.appendChild(option);
            });

            select.disabled = false;

        } catch (error) {

            console.error(error);

            select.innerHTML = `
                <option value="">Failed to load data</option>
            `;
        }
    }


    // =========================================================
    // DIRECTORATE -> DIVISION
    // =========================================================

    directorate.addEventListener('change', async function () {

        resetSelect(
            division,
            '-- Select Division --'
        );

        resetSelect(
            department,
            '-- Select Department --'
        );

        if (!this.value) {
            return;
        }

        await loadOrganizationOptions(
            `{{ url('/employee-form/divisions') }}/${this.value}`,
            division,
            'DivisionID',
            'DivisionName'
        );
    });


    // =========================================================
    // DIVISION -> DEPARTMENT
    // =========================================================

    division.addEventListener('change', async function () {

        resetSelect(
            department,
            '-- Select Department --'
        );

        if (!this.value) {
            return;
        }

        await loadOrganizationOptions(
            `{{ url('/employee-form/departments') }}/${this.value}`,
            department,
            'DepartmentID',
            'DepartmentName'
        );
    });

});
</script>
@endpush