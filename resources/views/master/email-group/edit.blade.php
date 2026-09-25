@extends('layouts.app')

@section('title', 'Edit Email Group')

@section('content')

    <x-alert />

    <x-card>

        <div class="card-header">
            <h5 class="mb-0">Edit Email Group</h5>
        </div>

        <div class="card-body">

            <form method="POST" action="{{ route('master.email-group.update', $data->EmailGroupID) }}">

                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="EmailGroupID" class="form-label">Email Group ID</label>
                    <input type="text" id="EmailGroupID" class="form-control" value="{{ $data->EmailGroupID }}" readonly>
                </div>

                <div class="mb-3">
                    <label for="DivisionID" class="form-label">
                        Division <span class="text-danger">*</span>
                    </label>
                    <select id="DivisionID" name="DivisionID" class="form-select @error('DivisionID') is-invalid @enderror"
                        required>
                        <option value="">-- Pilih Division --</option>
                        @foreach ($divisions as $division)
                            <option value="{{ $division->DivisionID }}" @selected(old('DivisionID', $data->DivisionID ?? '') == $division->DivisionID)>
                                {{ $division->DivisionName }}
                            </option>
                        @endforeach
                    </select>
                    @error('DivisionID')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <x-form.input label="Email" name="Email" type="email" :value="old('Email', $data->Email)" required="true" />

                <div class="mb-3">
                    <label for="Description" class="form-label">
                        Description <span class="text-danger">*</span>
                    </label>
                    <textarea id="Description" name="Description" class="form-control" rows="4" required>{{ old('Description', $data->Description) }}</textarea>
                    @error('Description')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <x-form.checkbox label="Email Group" name="IsGroup" :checked="$data->IsGroup" />

                <x-form.checkbox label="Active" name="IsActive" :checked="$data->IsActive" />

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('master.email-group.index') }}" class="btn btn-secondary">Cancel</a>
                </div>

            </form>

        </div>

    </x-card>

@endsection
