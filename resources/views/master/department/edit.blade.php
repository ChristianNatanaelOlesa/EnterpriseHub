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

            <form method="POST" action="{{ route('master.department.update', $department->DeptID) }}">

                @csrf
                @method('PUT')

                {{-- Company --}}

                <div class="mb-3">

                    <label for="CompID" class="form-label">
                        Company
                        <span class="text-danger">*</span>
                    </label>

                    <select name="CompID" id="CompID" class="form-select @error('CompID') is-invalid @enderror"
                        required>

                        <option value="">
                            -- Pilih Company --
                        </option>

                        @foreach ($companies as $company)
                            <option value="{{ $company->CompID }}" @selected(old('CompID', $department->division?->directorate?->CompID) == $company->CompID)>

                                {{ $company->CompID }}
                                -
                                {{ $company->Company }}

                            </option>
                        @endforeach

                    </select>

                    @error('CompID')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                {{-- Directorate --}}

                <div class="mb-3">

                    <label for="DirID" class="form-label">
                        Directorate
                        <span class="text-danger">*</span>
                    </label>

                    <select name="DirID" id="DirID"
                        class="form-select @error('DirID') is-invalid @enderror" required>

                        <option value="">
                            -- Pilih Directorate --
                        </option>

                    </select>

                    @error('DirID')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                {{-- Division --}}

                <div class="mb-3">

                    <label for="DivID" class="form-label">
                        Division
                        <span class="text-danger">*</span>
                    </label>

                    <select name="DivID" id="DivID" class="form-select @error('DivID') is-invalid @enderror"
                        required>

                        <option value="">
                            -- Pilih Division --
                        </option>

                    </select>

                    @error('DivID')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                {{-- Department Code --}}

                <x-form.input label="Department Code" name="DeptID" :value="old('DeptID', $department->DeptID)" required="true" />

                {{-- Department Name --}}

                <x-form.input label="Department Name" name="Department" :value="old('Department', $department->Department)" required="true" />

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
                document.getElementById('CompID');

            const directorateSelect =
                document.getElementById('DirID');

            const divisionSelect =
                document.getElementById('DivID');

            const selectedDirectorate =
                "{{ old('DirID', $department->division?->DirID) }}";

            const selectedDivision =
                "{{ old('DivID', $department->DivID) }}";

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
                        `{{ route('master.department.directorates') }}?CompID=${companyId}`, {
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
                            directorate.DirID;

                        option.textContent =
                            directorate.Directorate;

                        if (
                            String(directorate.DirID) ===
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
                        `{{ route('master.department.divisions') }}?DirID=${directorateId}`, {
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
                            division.DivID;

                        option.textContent =
                            division.Division;

                        if (
                            String(division.DivID) ===
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
