@extends('layouts.app')

@section('title', 'Edit Department')

@section('content')

    <div class="card">

        <div class="card-header">

            <h5 class="mb-0">
                Edit Department
            </h5>

        </div>

        <div class="card-body">

            <form method="POST" action="{{ route('master.department.update', $department->DepartmentID) }}">

                @csrf
                @method('PUT')

                {{-- Company --}}

                <div class="mb-3">

                    <label for="CompanyID" class="form-label">
                        Company
                        <span class="text-danger">*</span>
                    </label>

                    <select name="CompanyID" id="CompanyID" class="form-select @error('CompanyID') is-invalid @enderror"
                        required>

                        <option value="">
                            -- Pilih Company --
                        </option>

                        @foreach ($companies as $company)
                            <option value="{{ $company->CompanyID }}" @selected(old('CompanyID', $department->division?->directorate?->CompanyID) == $company->CompanyID)>

                                {{ $company->CompanyCode }}
                                -
                                {{ $company->CompanyName }}

                            </option>
                        @endforeach

                    </select>

                    @error('CompanyID')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                {{-- Directorate --}}

                <div class="mb-3">

                    <label for="DirectorateID" class="form-label">
                        Directorate
                        <span class="text-danger">*</span>
                    </label>

                    <select name="DirectorateID" id="DirectorateID"
                        class="form-select @error('DirectorateID') is-invalid @enderror" required>

                        <option value="">
                            -- Pilih Directorate --
                        </option>

                    </select>

                    @error('DirectorateID')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                {{-- Division --}}

                <div class="mb-3">

                    <label for="DivisionID" class="form-label">
                        Division
                        <span class="text-danger">*</span>
                    </label>

                    <select name="DivisionID" id="DivisionID" class="form-select @error('DivisionID') is-invalid @enderror"
                        required>

                        <option value="">
                            -- Pilih Division --
                        </option>

                    </select>

                    @error('DivisionID')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                {{-- Department Code --}}

                <x-form.input label="Department Code" name="DepartmentCode" :value="old('DepartmentCode', $department->DepartmentCode)" required="true" />

                {{-- Department Name --}}

                <x-form.input label="Department Name" name="DepartmentName" :value="old('DepartmentName', $department->DepartmentName)" required="true" />

                {{-- Active --}}

                <x-form.checkbox label="Active" name="IsActive" :checked="$department->IsActive" />

                <div class="mt-3">

                    <button type="submit" class="btn btn-primary">

                        Update

                    </button>

                    <a href="{{ route('master.department.index') }}" class="btn btn-secondary">

                        Cancel

                    </a>

                </div>

            </form>

        </div>

    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const companySelect =
                document.getElementById('CompanyID');

            const directorateSelect =
                document.getElementById('DirectorateID');

            const divisionSelect =
                document.getElementById('DivisionID');

            const selectedDirectorate =
                "{{ old('DirectorateID', $department->division?->DirectorateID) }}";

            const selectedDivision =
                "{{ old('DivisionID', $department->DivisionID) }}";

            if (
                !companySelect ||
                !directorateSelect ||
                !divisionSelect
            ) {
                return;
            }

            async function loadDirectorates(
                companyId,
                selectedId = ''
            ) {

                directorateSelect.innerHTML = `
            <option value="">
                Loading...
            </option>
        `;

                directorateSelect.disabled = true;

                divisionSelect.innerHTML = `
            <option value="">
                -- Pilih Directorate Terlebih Dahulu --
            </option>
        `;

                divisionSelect.disabled = true;

                if (!companyId) {

                    directorateSelect.innerHTML = `
                <option value="">
                    -- Pilih Company Terlebih Dahulu --
                </option>
            `;

                    return;
                }

                try {

                    const response = await fetch(
                        `{{ route('master.department.directorates') }}?CompanyID=${companyId}`, {
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        }
                    );

                    if (!response.ok) {
                        throw new Error(
                            'Failed to load directorates.'
                        );
                    }

                    const directorates =
                        await response.json();

                    directorateSelect.innerHTML = `
                <option value="">
                    -- Pilih Directorate --
                </option>
            `;

                    directorates.forEach(function(directorate) {

                        const option =
                            document.createElement('option');

                        option.value =
                            directorate.DirectorateID;

                        option.textContent =
                            directorate.DirectorateName;

                        if (
                            String(directorate.DirectorateID) ===
                            String(selectedId)
                        ) {
                            option.selected = true;
                        }

                        directorateSelect.appendChild(option);

                    });

                    directorateSelect.disabled = false;

                } catch (error) {

                    console.error(error);

                    directorateSelect.innerHTML = `
                <option value="">
                    Gagal mengambil Directorate
                </option>
            `;

                }

            }

            async function loadDivisions(
                directorateId,
                selectedId = ''
            ) {

                divisionSelect.innerHTML = `
            <option value="">
                Loading...
            </option>
        `;

                divisionSelect.disabled = true;

                if (!directorateId) {

                    divisionSelect.innerHTML = `
                <option value="">
                    -- Pilih Directorate Terlebih Dahulu --
                </option>
            `;

                    return;
                }

                try {

                    const response = await fetch(
                        `{{ route('master.department.divisions') }}?DirectorateID=${directorateId}`, {
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        }
                    );

                    if (!response.ok) {
                        throw new Error(
                            'Failed to load divisions.'
                        );
                    }

                    const divisions =
                        await response.json();

                    divisionSelect.innerHTML = `
                <option value="">
                    -- Pilih Division --
                </option>
            `;

                    divisions.forEach(function(division) {

                        const option =
                            document.createElement('option');

                        option.value =
                            division.DivisionID;

                        option.textContent =
                            division.DivisionName;

                        if (
                            String(division.DivisionID) ===
                            String(selectedId)
                        ) {
                            option.selected = true;
                        }

                        divisionSelect.appendChild(option);

                    });

                    divisionSelect.disabled = false;

                } catch (error) {

                    console.error(error);

                    divisionSelect.innerHTML = `
                <option value="">
                    Gagal mengambil Division
                </option>
            `;

                }

            }

            companySelect.addEventListener(
                'change',
                function() {

                    loadDirectorates(
                        this.value,
                        ''
                    );

                }
            );

            directorateSelect.addEventListener(
                'change',
                function() {

                    loadDivisions(
                        this.value,
                        ''
                    );

                }
            );

            // Initial load saat Edit dibuka

            if (companySelect.value) {

                loadDirectorates(
                    companySelect.value,
                    selectedDirectorate
                ).then(function() {

                    if (directorateSelect.value) {

                        loadDivisions(
                            directorateSelect.value,
                            selectedDivision
                        );

                    }

                });

            }

        });
    </script>
@endpush
