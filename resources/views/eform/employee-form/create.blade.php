@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Employee Form Request</h4>
            <div class="text-muted">
                Create new employee form request
            </div>
        </div>

        <a href="{{ route('employee-form.index') }}"
           class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i>
            Back
        </a>
    </div>

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

    <form action="{{ route('employee-form.store') }}"
          method="POST">

        @csrf

        {{-- ========================================================= --}}
        {{-- PERSONAL INFORMATION --}}
        {{-- ========================================================= --}}

        <div class="card mb-4">
            <div class="card-header">
                <strong>Personal Information</strong>
            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            First Name <span class="text-danger">*</span>
                        </label>

                        <input type="text"
                               name="FirstName"
                               id="FirstName"
                               class="form-control"
                               value="{{ old('FirstName') }}"
                               maxlength="300"
                               required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Last Name
                        </label>

                        <input type="text"
                               name="LastName"
                               id="LastName"
                               class="form-control"
                               value="{{ old('LastName') }}"
                               maxlength="300">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Mobile No <span class="text-danger">*</span>
                        </label>

                        <div class="input-group">
                            <span class="input-group-text">+62</span>

                            <input type="text"
                                   name="MobileNo"
                                   id="MobileNo"
                                   class="form-control"
                                   value="{{ old('MobileNo') }}"
                                   inputmode="numeric"
                                   maxlength="15"
                                   placeholder="81234567890"
                                   required>
                        </div>

                        <small class="text-muted">
                            Enter the number without the leading 0.
                        </small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Birth Date <span class="text-danger">*</span>
                        </label>

                        <input type="date"
                               name="BirthDate"
                               class="form-control"
                               value="{{ old('BirthDate') }}"
                               required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            NIP <span class="text-danger">*</span>
                        </label>

                        <input type="text"
                               name="NIP"
                               class="form-control"
                               value="{{ old('NIP') }}"
                               inputmode="numeric"
                               required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Marital Status <span class="text-danger">*</span>
                        </label>

                        <select name="MaritalStatus"
                                class="form-select"
                                required>

                            <option value="">-- Select Marital Status --</option>

                            <option value="S"
                                @selected(old('MaritalStatus') === 'S')>
                                Single
                            </option>

                            <option value="M"
                                @selected(old('MaritalStatus') === 'M')>
                                Married
                            </option>

                            <option value="D"
                                @selected(old('MaritalStatus') === 'D')>
                                Divorce
                            </option>

                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Religion <span class="text-danger">*</span>
                        </label>

                        <select name="ReligionID"
                                class="form-select"
                                required>

                            <option value="">-- Select Religion --</option>

                            @foreach ($religions as $religion)
                                <option value="{{ $religion->ReligionID }}"
                                    @selected(old('ReligionID') === $religion->ReligionID)>
                                    {{ $religion->Religion }}
                                </option>
                            @endforeach

                        </select>
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

                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Country <span class="text-danger">*</span>
                        </label>

                        <select id="CountryID"
                                class="form-select"
                                required>

                            <option value="">-- Select Country --</option>

                            @foreach ($countries as $country)
                                <option value="{{ $country->CountryID }}"
                                    @selected($country->CountryID === 'IDN')>
                                    {{ $country->Country }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Province <span class="text-danger">*</span>
                        </label>

                        <select id="ProvinceID"
                                class="form-select"
                                required>

                            <option value="">-- Select Province --</option>

                            @foreach ($provinces as $province)
                                <option value="{{ $province->ProvinceID }}">
                                    {{ $province->Province }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            City <span class="text-danger">*</span>
                        </label>

                        <select id="CityID"
                                class="form-select"
                                required
                                disabled>

                            <option value="">-- Select City --</option>

                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            District <span class="text-danger">*</span>
                        </label>

                        <select id="DistrictID"
                                class="form-select"
                                required
                                disabled>

                            <option value="">-- Select District --</option>

                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Village <span class="text-danger">*</span>
                        </label>

                        <select name="VillageID"
                                id="VillageID"
                                class="form-select"
                                required
                                disabled>

                            <option value="">-- Select Village --</option>

                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Email <span class="text-danger">*</span>
                        </label>

                        <input type="email"
                               name="Email"
                               class="form-control"
                               value="{{ old('Email') }}"
                               placeholder="example@company.com"
                               maxlength="200"
                               required>

                        <small class="text-muted">
                            Please enter a valid email address.
                        </small>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">
                            Address <span class="text-danger">*</span>
                        </label>

                        <textarea name="Address"
                                  class="form-control"
                                  rows="4"
                                  maxlength="1000"
                                  required>{{ old('Address') }}</textarea>
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

                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Directorate <span class="text-danger">*</span>
                        </label>

                        <select name="DirID"
                                id="DirectorateID"
                                class="form-select"
                                required>

                            <option value="">-- Select Directorate --</option>

                            @foreach ($directorates as $directorate)
                                <option value="{{ $directorate->DirectorateID }}"
                                    @selected(old('DirID') == $directorate->DirectorateID)>
                                    {{ $directorate->DirectorateName }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Division <span class="text-danger">*</span>
                        </label>

                        <select name="DivID"
                                id="DivisionID"
                                class="form-select"
                                required
                                disabled>

                            <option value="">-- Select Division --</option>

                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Department <span class="text-danger">*</span>
                        </label>

                        <select name="DeptID"
                                id="DepartmentID"
                                class="form-select"
                                required
                                disabled>

                            <option value="">-- Select Department --</option>

                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Job Level <span class="text-danger">*</span>
                        </label>

                        <select name="JobLvlID"
                                class="form-select"
                                required>

                            <option value="">-- Select Job Level --</option>

                            @foreach ($jobLevels as $jobLevel)
                                <option value="{{ $jobLevel->JobLevelID }}"
                                    @selected(old('JobLvlID') == $jobLevel->JobLevelID)>
                                    {{ $jobLevel->JobLevel }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Job Title <span class="text-danger">*</span>
                        </label>

                        <select name="JobTitleID"
                                class="form-select"
                                required>

                            <option value="">-- Select Job Title --</option>

                            @foreach ($jobTitles as $jobTitle)
                                <option value="{{ $jobTitle->JobTitleID }}"
                                    @selected(old('JobTitleID') == $jobTitle->JobTitleID)>
                                    {{ $jobTitle->JobTitle }}
                                </option>
                            @endforeach

                        </select>
                    </div>

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

                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Report To
                        </label>

                        <input type="text"
                               name="ReportTo"
                               class="form-control"
                               value="{{ old('ReportTo') }}"
                               maxlength="3"
                               placeholder="Enter Report To">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Effective Date <span class="text-danger">*</span>
                        </label>

                        <input type="date"
                               name="EffectiveDate"
                               class="form-control"
                               value="{{ old('EffectiveDate', now()->format('Y-m-d')) }}"
                               required>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">
                            Remarks <span class="text-danger">*</span>
                        </label>

                        <textarea name="Remarks"
                                  class="form-control"
                                  rows="3"
                                  maxlength="1000"
                                  required>{{ old('Remarks') }}</textarea>
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
                Save Employee Form
            </button>

        </div>

    </form>

</div>
@endsection


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // =========================================================
    // Capitalize every word
    // =========================================================

    function capitalizeWords(value) {
        return value
            .toLowerCase()
            .replace(/\b\w/g, function (char) {
                return char.toUpperCase();
            });
    }

    document.getElementById('FirstName')
        .addEventListener('input', function () {
            this.value = capitalizeWords(this.value);
        });

    document.getElementById('LastName')
        .addEventListener('input', function () {
            this.value = capitalizeWords(this.value);
        });


    // =========================================================
    // Mobile Number
    // =========================================================

    const mobileInput = document.getElementById('MobileNo');

    mobileInput.addEventListener('input', function () {

        let value = this.value.replace(/\D/g, '');

        if (value.startsWith('0')) {
            value = value.replace(/^0+/, '');
        }

        if (value.startsWith('62')) {
            value = value.substring(2);
        }

        this.value = value;
    });


    // =========================================================
    // Generic dependent dropdown
    // =========================================================

    async function loadOptions(url, target, placeholder) {

        target.innerHTML = '';

        target.disabled = true;

        target.innerHTML = `
            <option value="">Loading...</option>
        `;

        try {

            const response = await fetch(url);

            if (!response.ok) {
                throw new Error('Failed to load data.');
            }

            const data = await response.json();

            target.innerHTML = `
                <option value="">${placeholder}</option>
            `;

            data.forEach(function (item) {

                const option = document.createElement('option');

                option.value = item.id ?? item.ID;

                option.textContent =
                    item.name ??
                    item.Name;

                target.appendChild(option);
            });

            target.disabled = false;

        } catch (error) {

            console.error(error);

            target.innerHTML = `
                <option value="">Failed to load data</option>
            `;
        }
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

    country.addEventListener('change', async function () {

        resetSelect(province, '-- Select Province --');
        resetSelect(city, '-- Select City --');
        resetSelect(district, '-- Select District --');
        resetSelect(village, '-- Select Village --');

        if (!this.value) {
            return;
        }

        const response = await fetch(
            `{{ url('/employee-form/provinces') }}/${this.value}`
        );

        const data = await response.json();

        province.disabled = false;

        data.forEach(function (item) {

            province.insertAdjacentHTML(
                'beforeend',
                `<option value="${item.ProvinceID}">
                    ${item.Province}
                </option>`
            );

        });
    });


    province.addEventListener('change', async function () {

        resetSelect(city, '-- Select City --');
        resetSelect(district, '-- Select District --');
        resetSelect(village, '-- Select Village --');

        if (!this.value) {
            return;
        }

        const response = await fetch(
            `{{ url('/employee-form/cities') }}/${this.value}`
        );

        const data = await response.json();

        city.disabled = false;

        data.forEach(function (item) {

            city.insertAdjacentHTML(
                'beforeend',
                `<option value="${item.CityID}">
                    ${item.City}
                </option>`
            );

        });
    });


    city.addEventListener('change', async function () {

        resetSelect(district, '-- Select District --');
        resetSelect(village, '-- Select Village --');

        if (!this.value) {
            return;
        }

        const response = await fetch(
            `{{ url('/employee-form/districts') }}/${this.value}`
        );

        const data = await response.json();

        district.disabled = false;

        data.forEach(function (item) {

            district.insertAdjacentHTML(
                'beforeend',
                `<option value="${item.DistrictID}">
                    ${item.District}
                </option>`
            );

        });
    });


    district.addEventListener('change', async function () {

        resetSelect(village, '-- Select Village --');

        if (!this.value) {
            return;
        }

        const response = await fetch(
            `{{ url('/employee-form/villages') }}/${this.value}`
        );

        const data = await response.json();

        village.disabled = false;

        data.forEach(function (item) {

            village.insertAdjacentHTML(
                'beforeend',
                `<option value="${item.VillageID}">
                    ${item.Village}
                </option>`
            );

        });
    });


    // =========================================================
    // ORGANIZATION
    // =========================================================

    const directorate = document.getElementById('DirectorateID');
    const division = document.getElementById('DivisionID');
    const department = document.getElementById('DepartmentID');

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

        /*
         * IMPORTANT:
         * Tr_EmpFormHist stores DirID / DivID / DeptID
         * as business codes, not numeric PK.
         *
         * Therefore the API returns DivisionID,
         * while later we will map it to DivisionCode.
         */
        const response = await fetch(
            `{{ url('/employee-form/divisions') }}/${this.value}`
        );

        const data = await response.json();

        division.disabled = false;

        data.forEach(function (item) {

            division.insertAdjacentHTML(
                'beforeend',
                `<option value="${item.DivisionID}">
                    ${item.DivisionName}
                </option>`
            );

        });
    });


    division.addEventListener('change', async function () {

        resetSelect(
            department,
            '-- Select Department --'
        );

        if (!this.value) {
            return;
        }

        const response = await fetch(
            `{{ url('/employee-form/departments') }}/${this.value}`
        );

        const data = await response.json();

        department.disabled = false;

        data.forEach(function (item) {

            department.insertAdjacentHTML(
                'beforeend',
                `<option value="${item.DepartmentID}">
                    ${item.DepartmentName}
                </option>`
            );

        });
    });

});
</script>
@endpush