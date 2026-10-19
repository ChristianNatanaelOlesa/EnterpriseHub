@extends('layouts.app')

@section('title', 'Edit Company')

@section('content')

    <x-alert />

    <x-card>

        <div class="card-header">

            <h5 class="mb-0">
                Edit Company
            </h5>

        </div>

        <div class="card-body">

            <form method="POST" action="{{ route('master.company.update', $company->CompID) }}">

                @csrf

                @method('PUT')

                <x-form.input label="Company Code" name="CompID" :value="old('CompID', $company->CompID)" required="true" />

                <x-form.input label="Company Name" name="Company" :value="old('Company', $company->Company)" required="true" />

                <x-form.input label="Description" name="Description" :value="old('Description', $company->Description)" required="true" />

                <x-form.input label="Address" name="Address" :value="old('Address', $company->Address)" required="true" />

                <x-form.input label="Phone 1" name="Phone1" :value="old('Phone1', $company->Phone1)" required="true" />

                <x-form.input label="Phone 2" name="Phone2" :value="old('Phone2', $company->Phone2)" />

                <x-form.input label="Email" name="Email" :value="old('Email', $company->Email)" />

                <x-form.checkbox label="Active" name="IsActive" :checked="$company->IsActive" />

                <div class="mt-3">

                    <button type="submit" class="btn btn-primary">
                        Update
                    </button>

                    <a href="{{ route('master.company.index') }}" class="btn btn-secondary">
                        Cancel
                    </a>

                </div>

            </form>

        </div>

    </x-card>

@endsection
