@extends('layouts.app')

@section('title', 'Tambah Directorate')

@section('content')

    <x-alert />

    <x-card>

        <div class="card-header">

            <h5 class="mb-0">
                Tambah Directorate
            </h5>

        </div>

        <div class="card-body">

            <form method="POST" action="{{ route('master.directorate.store') }}">

                @csrf

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

                <x-form.input label="Directorate Code" name="DirID" :value="old('DirID')" required="true" />

                <x-form.input label="Directorate Name" name="Directorate" :value="old('Directorate')" required="true" />

                <x-form.checkbox label="Active" name="IsActive" checked="true" />

                <div class="mt-3">

                    <button type="submit" class="btn btn-primary">
                        Save
                    </button>

                    <a href="{{ route('master.directorate.index') }}" class="btn btn-secondary">
                        Cancel
                    </a>

                </div>

            </form>

        </div>

    </x-card>

@endsection
