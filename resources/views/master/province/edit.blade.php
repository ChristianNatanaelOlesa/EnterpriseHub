@extends('layouts.app')

@section('title', 'Edit Province')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Edit Province</h4>

        <a
            href="{{ route('master.province.index') }}"
            class="btn btn-secondary"
        >
            <i class="bi bi-arrow-left"></i>
            Back
        </a>
    </div>

    <x-alert />

    <x-card>
        <form
            action="{{ route('master.province.update', $province->ProvinceID) }}"
            method="POST"
        >
            @csrf
            @method('PUT')

            <div class="row">

                <div class="col-md-6">
                    <x-form.input
                        name="ProvinceID"
                        label="Province ID"
                        value="{{ old('ProvinceID', $province->ProvinceID) }}"
                        required
                    />
                </div>

                <div class="col-md-6">
                    <x-form.input
                        name="Province"
                        label="Province"
                        value="{{ old('Province', $province->Province) }}"
                        required
                    />
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="CountryID" class="form-label">
                            Country <span class="text-danger">*</span>
                        </label>

                        <select
                            name="CountryID"
                            id="CountryID"
                            class="form-select @error('CountryID') is-invalid @enderror"
                            required
                        >
                            <option value="">-- Select Country --</option>

                            @foreach ($countries as $country)
                                <option
                                    value="{{ $country->CountryID }}"
                                    @selected(
                                        old('CountryID', $province->CountryID)
                                        == $country->CountryID
                                    )
                                >
                                    {{ $country->Country }}
                                </option>
                            @endforeach
                        </select>

                        @error('CountryID')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <x-form.checkbox
                        name="IsActive"
                        label="Active"
                        value="1"
                        :checked="$province->IsActive"
                    />
                </div>

            </div>

            <div class="d-flex justify-content-end gap-2">
                <a
                    href="{{ route('master.province.index') }}"
                    class="btn btn-secondary"
                >
                    Cancel
                </a>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i>
                    Update
                </button>
            </div>

        </form>
    </x-card>

</div>
@endsection