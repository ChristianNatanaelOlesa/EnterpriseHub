@extends('layouts.app')

@section('title', 'Edit Religion')

@section('content')

    <x-alert />

    <x-card>

        <div class="card-header">

            <h5 class="mb-0">
                Edit Religion
            </h5>

        </div>

        <div class="card-body">

            <form method="POST" action="{{ route('master.religion.update', $data->ReligionID) }}">

                @csrf
                @method('PUT')

                <x-form.input label="Religion ID" name="ReligionID" :value="old('ReligionID', $data->ReligionID)" required="true" />

                <x-form.input label="Religion" name="Religion" :value="old('Religion', $data->Religion)" required="true" />

                <x-form.checkbox label="Active" name="IsActive" :checked="$data->IsActive" />

                <div class="mt-3">

                    <button type="submit" class="btn btn-primary">
                        Update
                    </button>

                    <a href="{{ route('master.religion.index') }}" class="btn btn-secondary">
                        Cancel
                    </a>

                </div>

            </form>

        </div>

    </x-card>

@endsection
