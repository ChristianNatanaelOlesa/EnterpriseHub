@extends('layouts.app')

@section('title', 'Tambah Company')

@section('content')

    <x-alert />

    <x-card>

        <div class="card-header">

            <h5 class="mb-0">
                Tambah Company
            </h5>

        </div>

        <div class="card-body">

            <form method="POST" action="{{ route('master.company.store') }}">

                @csrf

                <x-form.input label="Company Code" name="CompID" :value="old('CompID')" required="true" />

                <x-form.input label="Company Name" name="Company" :value="old('Company')" required="true" />

                <x-form.input label="Description" name="Description" :value="old('Description')" required="true" />

                <x-form.input label="Address" name="Address" :value="old('Address')" required="true" />

                <x-form.input label="Phone 1" name="Phone1" :value="old('Phone1')" required="true" />

                <x-form.input label="Phone 2" name="Phone2" :value="old('Phone2', '-')" />

                <x-form.input label="Email" name="Email" :value="old('Email')" />

                <x-form.checkbox label="Active" name="IsActive" checked="true" />

                <div class="mt-3">

                    <button type="submit" class="btn btn-primary">
                        Save
                    </button>

                    <a href="{{ route('master.company.index') }}" class="btn btn-secondary">
                        Cancel
                    </a>

                </div>

            </form>

        </div>

    </x-card>

@endsection
