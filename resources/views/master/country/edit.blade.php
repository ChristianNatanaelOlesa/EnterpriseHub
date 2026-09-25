@extends('layouts.app')

@section('title', 'Edit Country')

@section('content')

    <x-alert />

    <x-card>

        <div class="card-header">
            <h5 class="mb-0">Edit Country</h5>
        </div>

        <div class="card-body">

            <form method="POST" action="{{ route('master.country.update', $country->CountryID) }}">

                @csrf
                @method('PUT')

                <x-form.input label="Country ID" name="CountryID" :value="old('CountryID', $country->CountryID)" required="true" />

                <x-form.input label="Country" name="Country" :value="old('Country', $country->Country)" required="true" />

                <x-form.checkbox label="Active" name="IsActive" :checked="$country->IsActive" />

                <div class="mt-3">

                    <button type="submit" class="btn btn-primary">
                        Update
                    </button>

                    <a href="{{ route('master.country.index') }}" class="btn btn-secondary">
                        Cancel
                    </a>

                </div>

            </form>

        </div>

    </x-card>

@endsection
