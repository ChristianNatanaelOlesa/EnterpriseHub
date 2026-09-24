@extends('layouts.app')
@section('title', 'Tambah Job Title')
@section('content')
<x-alert />
<x-card>
    <div class="card-header"><h5 class="mb-0">Tambah Job Title</h5></div>
    <div class="card-body">
        <form method="POST" action="{{ route('master.job-title.store') }}">
            @csrf
            <x-form.input label="Job Title" name="JobTitle" :value="old('JobTitle')" required="true" />
            <x-form.checkbox label="Active" name="IsActive" checked="true" />
            <div class="mt-3"><button type="submit" class="btn btn-primary">Save</button> <a href="{{ route('master.job-title.index') }}" class="btn btn-secondary">Cancel</a></div>
        </form>
    </div>
</x-card>
@endsection
