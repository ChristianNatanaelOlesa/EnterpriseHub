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
                            <option value="{{ $company->CompanyID }}" @selected(old('CompanyID') == $company->CompanyID)>
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

                <x-form.input label="Directorate Code" name="DirectorateCode" :value="old('DirectorateCode')" required="true" />

                <x-form.input label="Directorate Name" name="DirectorateName" :value="old('DirectorateName')" required="true" />

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
