@extends('layouts.app')
@section('title', 'Edit Job Title')
@section('content')
<x-alert />
<x-card>
    <div class="card-header"><h5 class="mb-0">Edit Job Title</h5></div>
    <div class="card-body">
        <form method="POST" action="{{ route('master.job-title.update', $data->JobTitleID) }}">
            @csrf @method('PUT')
            <x-form.input label="Job Title" name="JobTitle" :value="old('JobTitle', $data->JobTitle)" required="true" />
            <x-form.checkbox label="Active" name="IsActive" :checked="$data->IsActive" />
            <div class="mt-3"><button type="submit" class="btn btn-primary">Update</button> <a href="{{ route('master.job-title.index') }}" class="btn btn-secondary">Cancel</a></div>
        </form>
    </div>
</x-card>
@endsection
