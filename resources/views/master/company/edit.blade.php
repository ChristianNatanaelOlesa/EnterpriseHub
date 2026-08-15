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

            <form method="POST" action="{{ route('master.company.update', $company->CompanyID) }}">

                @csrf

                @method('PUT')

                <x-form.input label="Company Code" name="CompanyCode" :value="old('CompanyCode', $company->CompanyCode)" required="true" />

                <x-form.input label="Company Name" name="CompanyName" :value="old('CompanyName', $company->CompanyName)" required="true" />

                <x-form.input label="Address" name="Address" :value="old('Address', $company->Address)" />

                <x-form.input label="Phone" name="Phone" :value="old('Phone', $company->Phone)" />

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
