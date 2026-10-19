@extends('layouts.app')

@section('title', 'Tambah Division')

@section('content')

    <div class="card">

        <div class="card-header">

            <h5 class="mb-0">
                Tambah Division
            </h5>

        </div>

        <div class="card-body">

            <form method="POST" action="{{ route('master.division.store') }}">

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

                {{-- Division Code --}}

                <div class="mb-3">

                    <label class="form-label">
                        Division Code
                        <span class="text-danger">*</span>
                    </label>

                    <input type="text" name="DivID"
                        class="form-control @error('DivID') is-invalid @enderror" value="{{ old('DivID') }}"
                        maxlength="20">

                    @error('DivID')
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

                    <input type="text" name="Division"
                        class="form-control @error('Division') is-invalid @enderror" value="{{ old('Division') }}"
                        maxlength="200">

                    @error('Division')
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
                document.getElementById('CompID');

            const directorateSelect =
                document.getElementById('DirID');

            if (!companySelect || !directorateSelect) {
                return;
            }

            async function loadDirectorates(companyId) {

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
                        `{{ route('master.division.directorates') }}?CompID=${companyId}`, {
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
                            directorate.DirID;

                        option.textContent =
                            directorate.Directorate;

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
                    loadDirectorates(this.value);
                }
            );

            /*
             * Jika validation gagal dan Company
             * sebelumnya sudah dipilih.
             */
            if (companySelect.value) {

                loadDirectorates(companySelect.value);

            }

        });
    </script>
@endpush
