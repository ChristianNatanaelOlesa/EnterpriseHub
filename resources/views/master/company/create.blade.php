@extends('layouts.app')

@section('content')

<x-alert />

<x-card>

<form
    method="POST"
    action="{{ route('companies.store') }}"
>

    @csrf

    <x-form.input
        label="Company Code"
        name="CompanyCode"
        required="true"
    />

    <x-form.input
        label="Company Name"
        name="CompanyName"
        required="true"
    />

    <x-form.input
        label="Company Alias"
        name="CompanyAlias"
    />

    <x-form.checkbox
        label="Active"
        name="IsActive"
        checked="true"
    />

    <button
        class="btn btn-primary"
    >
        Save
    </button>

</form>

</x-card>

@endsection