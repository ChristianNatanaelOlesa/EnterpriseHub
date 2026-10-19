@extends('layouts.app')

@section('title', 'Tambah Department')

@section('content')

    <div class="card">

        <div class="card-header">

            <h5 class="mb-0">
                Tambah Department
            </h5>

        </div>

        <div class="card-body">

            <form method="POST" action="{{ route('master.department.store') }}">

                @csrf

                {{-- Company --}}

                <div class="mb-3">

                    <label class="form-label">
                        Company
                        <span class="text-danger">*</span>
                    </label>

                    <select name="CompID" id="CompID" class="form-select @error('CompID') is-invalid @enderror">

                        <option value="">
                            -- Pilih Company --
                        </option>

                        @foreach ($companies as $company)
                            <option value="{{ $company->CompID }}" @selected(old('CompID') == $company->CompID)>
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

                    <label class="form-label">
                        Directorate
                        <span class="text-danger">*</span>
                    </label>

                    <select name="DirID" id="DirID"
                        class="form-select @error('DirID') is-invalid @enderror" disabled>

                        <option value="">
                            -- Pilih Company Terlebih Dahulu --
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

                    <label class="form-label">
                        Division
                        <span class="text-danger">*</span>
                    </label>

                    <select name="DivID" id="DivID" class="form-select @error('DivID') is-invalid @enderror"
                        disabled>

                        <option value="">
                            -- Pilih Directorate Terlebih Dahulu --
                        </option>

                    </select>

                    @error('DivID')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                {{-- Department Code --}}

                <div class="mb-3">

                    <label class="form-label">
                        Department Code
                        <span class="text-danger">*</span>
                    </label>

                    <input type="text" name="DeptID"
                        class="form-control @error('DeptID') is-invalid @enderror"
                        value="{{ old('DeptID') }}" maxlength="20">

                    @error('DeptID')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                {{-- Department Name --}}

                <div class="mb-3">

                    <label class="form-label">
                        Department Name
                        <span class="text-danger">*</span>
                    </label>

                    <input type="text" name="Department"
                        class="form-control @error('Department') is-invalid @enderror"
                        value="{{ old('Department') }}" maxlength="200">

                    @error('Department')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                {{-- Status --}}

                <div class="form-check mb-3">

                    <input type="hidden" name="IsActive" value="0">

                    <input class="form-check-input" type="checkbox" name="IsActive" value="1" id="IsActive"
                        @checked(old('IsActive', true))>

                    <label class="form-check-label" for="IsActive">
                        Active
                    </label>

                </div>

                <div class="d-flex gap-2">

                    <button type="submit" class="btn btn-primary">

                        <i class="bi bi-save"></i>

                        Save

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

            async function loadDirectorates(companyId) {

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
                        throw new Error('Failed to load directorates.');
                    }

                    const data = await response.json();

                    directorateSelect.innerHTML = `
                <option value="">
                    -- Pilih Directorate --
                </option>
            `;

                    data.forEach(function(item) {

                        const option =
                            document.createElement('option');

                        option.value =
                            item.DirID;

                        option.textContent =
                            item.Directorate;

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

            async function loadDivisions(directorateId) {

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
                        throw new Error('Failed to load divisions.');
                    }

                    const data = await response.json();

                    divisionSelect.innerHTML = `
                <option value="">
                    -- Pilih Division --
                </option>
            `;

                    data.forEach(function(item) {

                        const option =
                            document.createElement('option');

                        option.value =
                            item.DivID;

                        option.textContent =
                            item.Division;

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

                    loadDirectorates(this.value);

                }
            );

            directorateSelect.addEventListener(
                'change',
                function() {

                    loadDivisions(this.value);

                }
            );

            if (companySelect.value) {

                loadDirectorates(companySelect.value);

            }

        });
    </script>
@endpush
