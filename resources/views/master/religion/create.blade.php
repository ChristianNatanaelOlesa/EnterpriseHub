@extends('layouts.app')

@section('title', 'Tambah Religion')

@section('content')

    <x-alert />

    <x-card>

        <div class="card-header">

            <h5 class="mb-0">
                Tambah Religion
            </h5>

        </div>

        <div class="card-body">

            <form method="POST" action="{{ route('master.religion.store') }}">

                @csrf

                <x-form.input label="Religion ID" name="ReligionID" :value="old('ReligionID')" required="true" />

                <x-form.input label="Religion" name="Religion" :value="old('Religion')" required="true" />

                <x-form.checkbox label="Active" name="IsActive" checked="true" />

                <div class="mt-3">

                    <button type="submit" class="btn btn-primary">
                        Save
                    </button>

                    <a href="{{ route('master.religion.index') }}" class="btn btn-secondary">
                        Cancel
                    </a>

                </div>

            </form>

        </div>

    </x-card>

@endsection
