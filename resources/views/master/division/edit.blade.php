@extends('layouts.app')

@section('title', 'Edit Division')

@section('content')

    <div class="card">

        <div class="card-header">

            <h5 class="mb-0">
                Edit Division
            </h5>

        </div>

        <div class="card-body">

            <form method="POST" action="{{ route('master.division.update', $division->DivisionID) }}">

                @csrf

                @method('PUT')

                {{-- Company --}}

                <div class="mb-3">

                    <label class="form-label">
                        Company
                        <span class="text-danger">*</span>
                    </label>

                    <select name="CompanyID" id="CompanyID" class="form-select @error('CompanyID') is-invalid @enderror">

                        <option value="">
                            -- Pilih Company --
                        </option>

                        @foreach ($companies as $company)
                            <option value="{{ $company->CompanyID }}" @selected(old('CompanyID', $division->CompanyID) == $company->CompanyID)>
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

                    <label class="form-label">
                        Directorate
                        <span class="text-danger">*</span>
                    </label>

                    <select name="DirectorateID" id="DirectorateID"
                        class="form-select @error('DirectorateID') is-invalid @enderror">

                        <option value="">
                            -- Pilih Directorate --
                        </option>

                        @foreach ($directorates as $directorate)
                            <option value="{{ $directorate->DirectorateID }}" @selected(old('DirectorateID', $division->DirectorateID) == $directorate->DirectorateID)>
                                {{ $directorate->DirectorateName }}
                            </option>
                        @endforeach

                    </select>

                    @error('DirectorateID')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                {{-- Division Code --}}

                <div class="mb-3">

                    <label class="form-label">
                        Division Code
                        <span class="text-danger">*</span>
                    </label>

                    <input type="text" name="DivisionCode"
                        class="form-control @error('DivisionCode') is-invalid @enderror"
                        value="{{ old('DivisionCode', $division->DivisionCode) }}" maxlength="20">

                    @error('DivisionCode')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                {{-- Division Name --}}

                <div class="mb-3">

                    <label class="form-label">
                        Division Name
                        <span class="text-danger">*</span>
                    </label>

                    <input type="text" name="DivisionName"
                        class="form-control @error('DivisionName') is-invalid @enderror"
                        value="{{ old('DivisionName', $division->DivisionName) }}" maxlength="200">

                    @error('DivisionName')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                {{-- Status --}}

                <div class="form-check mb-3">

                    <input type="hidden" name="IsActive" value="0">

                    <input class="form-check-input" type="checkbox" name="IsActive" value="1" id="IsActive"
                        @checked(old('IsActive', $division->IsActive))>

                    <label class="form-check-label" for="IsActive">
                        Active
                    </label>

                </div>

                <div class="d-flex gap-2">

                    <button type="submit" class="btn btn-primary">

                        <i class="bi bi-save"></i>

                        Update

                    </button>

                    <a href="{{ route('master.division.index') }}" class="btn btn-secondary">
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

            const selectedDirectorate =
                "{{ old('DirectorateID', $division->DirectorateID) }}";

            if (!companySelect || !directorateSelect) {
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
                        `{{ route('master.division.directorates') }}?CompanyID=${companyId}`, {
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        }
                    );

                    if (!response.ok) {
                        throw new Error('Failed to load directorates.');
                    }

                    const directorates = await response.json();

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

            companySelect.addEventListener(
                'change',
                function() {

                    loadDirectorates(
                        this.value,
                        ''
                    );

                }
            );

            if (companySelect.value) {

                loadDirectorates(
                    companySelect.value,
                    selectedDirectorate
                );

            }

        });
    </script>
@endpush
