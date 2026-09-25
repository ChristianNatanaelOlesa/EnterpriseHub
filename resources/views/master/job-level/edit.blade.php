@extends('layouts.app')
@section('title', 'Edit Job Level')
@section('content')
    <x-alert />
    <x-card>
        <div class="card-header">
            <h5 class="mb-0">Edit Job Level</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('master.job-level.update', $data->JobLevelID) }}">
                @csrf @method('PUT')
                <x-form.input label="Job Level" name="JobLevel" :value="old('JobLevel', $data->JobLevel)" required="true" />
                <x-form.checkbox label="Active" name="IsActive" :checked="$data->IsActive" />
                <div class="mt-3"><button type="submit" class="btn btn-primary">Update</button> <a
                        href="{{ route('master.job-level.index') }}" class="btn btn-secondary">Cancel</a></div>
            </form>
        </div>
    </x-card>
@endsection
