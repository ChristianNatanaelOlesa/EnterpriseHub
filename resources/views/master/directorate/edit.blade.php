@extends('layouts.app')

@section('title', 'Edit Directorate')

@section('content')

    <x-alert />

    <x-card>

        <div class="card-header">

            <h5 class="mb-0">
                Edit Directorate
            </h5>

        </div>

        <div class="card-body">

            <form method="POST" action="{{ route('master.directorate.update', $directorate->DirectorateID) }}">

                @csrf

                @method('PUT')

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
                            <option value="{{ $company->CompanyID }}" @selected(old('CompanyID', $directorate->CompanyID) == $company->CompanyID)>
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

                <x-form.input label="Directorate Code" name="DirectorateCode" :value="old('DirectorateCode', $directorate->DirectorateCode)" required="true" />

                <x-form.input label="Directorate Name" name="DirectorateName" :value="old('DirectorateName', $directorate->DirectorateName)" required="true" />

                <x-form.checkbox label="Active" name="IsActive" :checked="$directorate->IsActive" />

                <div class="mt-3">

                    <button type="submit" class="btn btn-primary">
                        Update
                    </button>

                    <a href="{{ route('master.directorate.index') }}" class="btn btn-secondary">
                        Cancel
                    </a>

                </div>

            </form>

        </div>

    </x-card>

@endsection
