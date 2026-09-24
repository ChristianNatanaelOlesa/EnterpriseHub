@extends('layouts.app')

@section('title', 'Edit Employee Email')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h4 class="mb-1">Edit Employee Email</h4>
        <div class="text-muted small">
            Update employee email transaction
        </div>
    </div>

    <a
        href="{{ route('employee-email.index') }}"
        class="btn btn-outline-secondary"
    >
        <i class="bi bi-arrow-left me-1"></i>
        Back
    </a>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<form
    method="POST"
    action="{{ route('employee-email.update', $email->EmpEmailID) }}"
>
    @csrf
    @method('PUT')

    <div class="card mb-4">

        <div class="card-header">
            <strong>FORM : EMPLOYEE EMAIL</strong>
        </div>

        <div class="card-body">

            <div class="row">

                {{-- Emp Email ID --}}
                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Emp Email ID
                    </label>

                    <input
                        type="text"
                        class="form-control readonly-field"
                        value="{{ $email->EmpEmailID }}"
                        readonly
                    >

                </div>

                {{-- Emp Form ID --}}
                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Emp Form ID
                    </label>

                    <input
                        type="text"
                        class="form-control readonly-field"
                        value="{{ $email->EmpFormID }}"
                        readonly
                    >

                </div>

                {{-- Req User --}}
                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Req User
                    </label>

                    <input
                        type="text"
                        class="form-control readonly-field"
                        value="{{ $email->ReqUser }}"
                        readonly
                    >

                </div>

                {{-- Req Date --}}
                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Req Date
                    </label>

                    <input
                        type="text"
                        class="form-control readonly-field"
                        value="{{ $email->ReqDate ? \Carbon\Carbon::parse($email->ReqDate)->format('d - m - Y') : '-' }}"
                        readonly
                    >

                </div>

                {{-- Request Type --}}
                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Request Type
                        <span class="text-danger">*</span>
                    </label>

                    <select
                        name="ReqType"
                        id="ReqType"
                        class="form-select @error('ReqType') is-invalid @enderror"
                        required
                    >

                        <option value="">
                            -- Select Request Type --
                        </option>

                        <option
                            value="Permanent"
                            {{ old('ReqType', $email->ReqType) === 'Permanent' ? 'selected' : '' }}
                        >
                            Permanent
                        </option>

                        <option
                            value="Temporary"
                            {{ old('ReqType', $email->ReqType) === 'Temporary' ? 'selected' : '' }}
                        >
                            Temporary
                        </option>

                    </select>

                    @error('ReqType')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                {{-- Email Type --}}
                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Email Type
                        <span class="text-danger">*</span>
                    </label>

                    <select
                        name="EmailType"
                        id="EmailType"
                        class="form-select @error('EmailType') is-invalid @enderror"
                        required
                    >

                        <option value="">
                            -- Select Email Type --
                        </option>

                        <option
                            value="Personal"
                            {{ old('EmailType', $email->EmailType) === 'Personal' ? 'selected' : '' }}
                        >
                            Personal
                        </option>

                        <option
                            value="Corporate"
                            {{ old('EmailType', $email->EmailType) === 'Corporate' ? 'selected' : '' }}
                        >
                            Corporate
                        </option>

                    </select>

                    @error('EmailType')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                {{-- Email --}}
                <div class="col-md-12 mb-3">

                    <label class="form-label">
                        Email
                        <span class="text-danger">*</span>
                    </label>

                    {{-- Personal Email --}}
                    <div id="personalEmailWrapper">

                        <input
                            type="text"
                            id="PersonalEmail"
                            class="form-control readonly-field"
                            value="Fill by IT Infra"
                            readonly
                        >

                        <input
                            type="hidden"
                            name="Email"
                            id="PersonalEmailHidden"
                            value="Fill by IT Infra"
                        >

                    </div>

                    {{-- Corporate Email --}}
                    <div id="corporateEmailWrapper">

                        <select
                            name="Email"
                            id="CorporateEmail"
                            class="form-select @error('Email') is-invalid @enderror"
                        >

                            <option value="">
                                -- Select Corporate Email --
                            </option>

                            @foreach($corporateEmailGroups as $group)

                                <option
                                    value="{{ $group->Email }}"
                                    {{ old('Email', $email->EmailType === 'Corporate' ? $email->Email : '') === $group->Email ? 'selected' : '' }}
                                >
                                    {{ $group->Email }}
                                    @if($group->Description)
                                        - {{ $group->Description }}
                                    @endif
                                </option>

                            @endforeach

                        </select>

                        @error('Email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                </div>

                {{-- Date From --}}
                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Date From
                        <span class="text-danger">*</span>
                    </label>

                    <input
                        type="date"
                        name="DateFrom"
                        id="DateFrom"
                        class="form-control @error('DateFrom') is-invalid @enderror"
                        value="{{ old('DateFrom', $email->DateFrom ? \Carbon\Carbon::parse($email->DateFrom)->format('Y-m-d') : '') }}"
                        required
                    >

                    @error('DateFrom')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- Date Until --}}
                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Date Until
                        <span class="text-danger">*</span>
                    </label>

                    <input
                        type="date"
                        name="DateUntil"
                        id="DateUntil"
                        class="form-control @error('DateUntil') is-invalid @enderror"
                        value="{{ old('DateUntil', $email->DateUntil ? \Carbon\Carbon::parse($email->DateUntil)->format('Y-m-d') : '') }}"
                        required
                    >

                    @error('DateUntil')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

</div>

                {{-- Purpose --}}
                <div class="col-md-12 mb-3">

                    <label class="form-label">
                        Purpose
                        <span class="text-danger">*</span>
                    </label>

                    <textarea
                        name="Purpose"
                        id="Purpose"
                        rows="3"
                        class="form-control @error('Purpose') is-invalid @enderror"
                        required
                    >{{ old('Purpose', $email->Purpose) }}</textarea>

                    @error('Purpose')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                {{-- Notes --}}
                <div class="col-md-12 mb-3">

                    <label class="form-label">
                        Notes
                    </label>

                    <textarea
                        name="Notes"
                        id="Notes"
                        rows="3"
                        class="form-control @error('Notes') is-invalid @enderror"
                    >{{ old('Notes', $email->Notes) }}</textarea>

                    @error('Notes')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

            </div>

        </div>

    </div>

    {{-- Buttons --}}
    <div class="d-flex justify-content-end gap-2">

        <a
            href="{{ route('employee-email.index') }}"
            class="btn btn-secondary"
        >
            Cancel
        </a>

        <button
            type="submit"
            class="btn btn-primary"
        >
            <i class="bi bi-save me-1"></i>
            Update
        </button>

    </div>

</form>

@endsection

@push('styles')
<style>
    .readonly-field {
        background-color: #f1f3f5 !important;
        color: #495057 !important;
        cursor: not-allowed;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const emailType = document.getElementById('EmailType');

    const personalWrapper = document.getElementById('personalEmailWrapper');
    const corporateWrapper = document.getElementById('corporateEmailWrapper');

    const corporateEmail = document.getElementById('CorporateEmail');
    const personalEmailHidden = document.getElementById('PersonalEmailHidden');

    const dateFrom = document.getElementById('DateFrom');
    const dateUntil = document.getElementById('DateUntil');

    function toggleEmailType() {

        if (emailType.value === 'Personal') {

            personalWrapper.style.display = 'block';
            corporateWrapper.style.display = 'none';

            corporateEmail.removeAttribute('name');

            personalEmailHidden.setAttribute('name', 'Email');
            personalEmailHidden.value = 'Fill by IT Infra';

        } else {

            personalWrapper.style.display = 'none';
            corporateWrapper.style.display = 'block';

            personalEmailHidden.removeAttribute('name');

            corporateEmail.setAttribute('name', 'Email');

        }
    }

    function toggleDateUntil() {

        if (document.getElementById('ReqType').value === 'Permanent') {

            dateUntil.value = '1900-01-01';
            dateUntil.readOnly = true;
            dateUntil.classList.add('readonly-field');

        } else {

            dateUntil.readOnly = false;
            dateUntil.classList.remove('readonly-field');

        }
    }

    emailType.addEventListener('change', toggleEmailType);

    document.getElementById('ReqType')
        .addEventListener('change', toggleDateUntil);

    dateFrom.addEventListener('change', function () {

        dateUntil.min = dateFrom.value;

        if (
            dateUntil.value &&
            dateUntil.value < dateFrom.value &&
            document.getElementById('ReqType').value !== 'Permanent'
        ) {
            dateUntil.value = dateFrom.value;
        }

    });

    toggleEmailType();
    toggleDateUntil();

    if (dateFrom.value) {
        dateUntil.min = dateFrom.value;
    }

});
</script>
@endpush