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

            <form method="POST"
                  action="{{ route('master.directorate.update', $directorate->DirID) }}">

                @csrf
                @method('PUT')

                <div class="mb-3">

                    <label for="CompID" class="form-label">
                        Company
                        <span class="text-danger">*</span>
                    </label>

                    <select name="CompID"
                            id="CompID"
                            class="form-select @error('CompID') is-invalid @enderror"
                            required>

                        <option value="">
                            -- Pilih Company --
                        </option>

                        @foreach ($companies as $company)
                            <option value="{{ $company->CompID }}"
                                @selected(old('CompID', $directorate->CompID) == $company->CompID)>

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

                <x-form.input
                    label="Directorate Code"
                    name="DirID"
                    :value="old('DirID', $directorate->DirID)"
                    required="true"
                />

                <x-form.input
                    label="Directorate Name"
                    name="Directorate"
                    :value="old('Directorate', $directorate->Directorate)"
                    required="true"
                />

                <x-form.checkbox
                    label="Active"
                    name="IsActive"
                    :checked="$directorate->IsActive"
                />

                <div class="mt-3">

                    <button type="submit" class="btn btn-primary">
                        Update
                    </button>

                    <a href="{{ route('master.directorate.index') }}"
                       class="btn btn-secondary">
                        Cancel
                    </a>

                </div>

            </form>

        </div>

    </x-card>

@endsection