@extends('layouts.app')

@section('content')

<div class="container">

    <h3>Tambah Company</h3>

    <form method="POST" action="{{ route('companies.update', $company) }}">

    @csrf
    @method('PUT')

        <div class="mb-3">
            <x-form.input label="Company Code" name="CompanyCode" :value="$company->CompanyCode"/>
        </div>

        <div class="mb-3">
            <label>Company Name</label>
            <input type="text"
                   name="CompanyName"
                   class="form-control"
                   value="{{ old('CompanyName') }}">
        </div>

        <div class="mb-3">
            <label>Company Alias</label>
            <input type="text"
                   name="CompanyAlias"
                   class="form-control"
                   value="{{ old('CompanyAlias') }}">
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input"
                   type="checkbox"
                   name="IsActive"
                   value="1"
                   checked>

            <label class="form-check-label">
                Active
            </label>
        </div>

        <button class="btn btn-primary">
            Save
        </button>

    </form>

</div>

@endsection