@extends('layouts.app')

@section('title', 'Create Employee Application')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Employee Application</h4>
            <div class="text-muted">Create Employee Application Request</div>
        </div>

        <a href="{{ route('employee-app.index') }}" class="btn btn-secondary">
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

    <form method="POST" action="{{ route('employee-app.store') }}">
        @csrf

        {{-- REQUEST INFORMATION --}}
        <div class="card mb-4">
            <div class="card-header">
                <strong>FORM : EMPLOYEE APPLICATION</strong>
            </div>

            <div class="card-body">
                <div class="row">

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Emp App ID</label>
                        <input
                            type="text"
                            class="form-control readonly-field"
                            value="AUTO"
                            readonly
                        >
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Emp Form ID</label>
                        <input
                            type="text"
                            class="form-control readonly-field"
                            value="{{ $empForm?->EmpFormID ?? 'EmpFormID belum tersedia' }}"
                            readonly
                        >

                        @if (!$empForm)
                            <div class="form-text text-danger">
                                User login belum memiliki EmpFormID pada Sc_User.
                            </div>
                        @endif
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Request User</label>
                        <input
                            type="text"
                            class="form-control readonly-field"
                            value="{{ session('username') ?: session('Username') ?: auth()->user()?->Username ?: auth()->user()?->username ?: '-' }}"
                            readonly
                        >
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">
                            Request Type <span class="text-danger">*</span>
                        </label>

                        <select
                            name="ReqType"
                            id="ReqType"
                            class="form-select"
                            required
                        >
                            <option
                                value="Permanent"
                                @selected(old('ReqType', 'Permanent') === 'Permanent')
                            >
                                Permanent
                            </option>

                            <option
                                value="Temporary"
                                @selected(old('ReqType') === 'Temporary')
                            >
                                Temporary
                            </option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">
                            Date From <span class="text-danger">*</span>
                        </label>

                        <input
                            type="date"
                            name="DateFrom"
                            id="DateFrom"
                            class="form-control"
                            value="{{ old('DateFrom', now()->toDateString()) }}"
                            required
                        >
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">
                            Date Until <span class="text-danger">*</span>
                        </label>

                        <input
                            type="date"
                            name="DateUntil"
                            id="DateUntil"
                            class="form-control"
                            value="{{ old('DateUntil', '1900-01-01') }}"
                            required
                        >
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Request Date</label>
                        <input
                            type="text"
                            class="form-control readonly-field"
                            value="{{ now()->format('d/m/Y') }}"
                            readonly
                        >
                    </div>

                    <div class="col-md-8 mb-3">
                        <label class="form-label">
                            Purpose <span class="text-danger">*</span>
                        </label>

                        <textarea
                            name="Purpose"
                            class="form-control"
                            rows="3"
                            maxlength="3000"
                            required
                        >{{ old('Purpose', 'Kebutuhan Pekerjaan') }}</textarea>
                    </div>

                </div>
            </div>
        </div>

        {{-- APPLICATION INFORMATION --}}
        <div class="card mb-4">
            <div class="card-header">
                <strong>APPLICATION INFORMATION</strong>
            </div>

            <div class="card-body">
                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Access Type <span class="text-danger">*</span>
                        </label>

                        <select
                            name="AccessType"
                            class="form-select"
                            required
                        >
                            <option value="">-- Select Access Type --</option>

                            <option
                                value="Internal"
                                @selected(old('AccessType') === 'Internal')
                            >
                                Internal
                            </option>

                            <option
                                value="External"
                                @selected(old('AccessType') === 'External')
                            >
                                External
                            </option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Application Type <span class="text-danger">*</span>
                        </label>

                        <select
                            name="AppType"
                            id="AppType"
                            class="form-select"
                            required
                        >
                            <option value="">-- Select Application Type --</option>

                            <option
                                value="Website"
                                @selected(old('AppType') === 'Website')
                            >
                                Website
                            </option>

                            <option
                                value="Aplikasi"
                                @selected(old('AppType') === 'Aplikasi')
                            >
                                Aplikasi
                            </option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">User Login</label>

                        <input
                            type="text"
                            name="UserLogin"
                            class="form-control"
                            value="{{ old('UserLogin', '-') }}"
                            maxlength="200"
                            placeholder="Optional"
                        >
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">User Password</label>

                        <input
                            type="text"
                            name="UserPassword"
                            class="form-control"
                            value="{{ old('UserPassword', '-') }}"
                            maxlength="200"
                            placeholder="Optional"
                        >
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Application Name <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            name="AppName"
                            class="form-control"
                            value="{{ old('AppName') }}"
                            maxlength="300"
                            required
                        >
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">URL</label>

                        <input
                            type="url"
                            name="URL"
                            id="URL"
                            class="form-control"
                            value="{{ old('URL', '-') }}"
                            maxlength="1000"
                        >

                        <div class="form-text">
                            URL hanya dapat diisi untuk Website.
                        </div>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Notes</label>

                        <textarea
                            name="Notes"
                            class="form-control"
                            rows="3"
                            maxlength="1000"
                        >{{ old('Notes', '-') }}</textarea>
                    </div>

                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mb-4">
            <a
                href="{{ route('employee-app.index') }}"
                class="btn btn-secondary"
            >
                Close
            </a>

            <button
                type="submit"
                class="btn btn-primary"
                {{ !$empForm ? 'disabled' : '' }}
            >
                Submit
            </button>
        </div>

    </form>
</div>
@endsection

@push('styles')
<style>
.readonly-field {
    background-color: #e9ecef !important;
    color: #495057 !important;
    border-color: #ced4da;
    cursor: not-allowed;
    opacity: 1 !important;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const reqType = document.getElementById('ReqType');
    const dateFrom = document.getElementById('DateFrom');
    const dateUntil = document.getElementById('DateUntil');

    const appType = document.getElementById('AppType');
    const url = document.getElementById('URL');

    function syncDateUntil() {

        const permanent = reqType.value === 'Permanent';

        if (permanent) {

            dateUntil.value = '1900-01-01';

            dateUntil.readOnly = true;
            dateUntil.classList.add('readonly-field');

            dateUntil.removeAttribute('min');

        } else {

            dateUntil.readOnly = false;
            dateUntil.classList.remove('readonly-field');

            dateUntil.min = dateFrom.value || '';

            if (dateUntil.value === '1900-01-01') {
                dateUntil.value = dateFrom.value || '';
            }
        }
    }

    function syncUrl() {

        const website = appType.value === 'Website';

        url.readOnly = !website;

        url.classList.toggle(
            'readonly-field',
            !website
        );

        if (!website) {

            url.value = '-';

        } else if (url.value === '-') {

            url.value = '';
        }
    }

    reqType.addEventListener(
        'change',
        syncDateUntil
    );

    dateFrom.addEventListener(
        'change',
        function () {

            if (reqType.value === 'Temporary') {

                dateUntil.min = dateFrom.value || '';

                if (
                    dateUntil.value &&
                    dateUntil.value !== '1900-01-01' &&
                    dateUntil.value < dateFrom.value
                ) {
                    dateUntil.value = dateFrom.value;
                }
            }
        }
    );

    appType.addEventListener(
        'change',
        syncUrl
    );

    syncDateUntil();
    syncUrl();
});
</script>
@endpush