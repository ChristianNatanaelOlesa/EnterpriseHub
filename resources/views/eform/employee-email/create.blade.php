@extends('layouts.app')

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

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Employee Email</h4>
            <div class="text-muted">Create Employee Email Request</div>
        </div>
        <a href="{{ route('employee-email.index') }}" class="btn btn-secondary">Back</a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger"><ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif
    @if (session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

    <form method="POST" action="{{ route('employee-email.store') }}">
        @csrf

        <div class="card mb-4">
            <div class="card-header"><strong>FORM : EMPLOYEE EMAIL</strong></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Emp Email ID</label>
                        <input type="text" class="form-control readonly-field" value="AUTO" readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Emp Form ID</label>
                        <input type="text" class="form-control readonly-field" value="{{ $empForm?->EmpFormID ?? 'EmpFormID belum tersedia' }}" readonly>
                        @if (!$empForm)<div class="form-text text-danger">User login belum memiliki EmpFormID pada Sc_User.</div>@endif
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Request Type <span class="text-danger">*</span></label>
                        <select name="ReqType" id="ReqType" class="form-select" required>
                            <option value="Permanent" @selected(old('ReqType', 'Permanent') === 'Permanent')>Permanent</option>
                            <option value="Temporary" @selected(old('ReqType') === 'Temporary')>Temporary</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email Type <span class="text-danger">*</span></label>
                        <select name="EmailType" id="EmailType" class="form-select" required>
                            <option value="Personal" @selected(old('EmailType', 'Personal') === 'Personal')>Personal</option>
                            <option value="Corporate" @selected(old('EmailType') === 'Corporate')>Corporate</option>
                        </select>
                    </div>

                    <div class="col-md-12 mb-3" id="personalEmailWrapper">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="text" id="personalEmail" class="form-control readonly-field" value="{{ old('Email', 'Fill by IT Infra') }}" maxlength="300" readonly>
                    </div>

                    <div class="col-md-12 mb-3 d-none" id="corporateEmailWrapper">
                        <label class="form-label">Corporate Email <span class="text-danger">*</span></label>
                        <select id="corporateEmail" class="form-select">
                            <option value="">-- Select Corporate Email --</option>
                            @foreach ($emailGroups as $group)
                                <option value="{{ $group->Email }}" @selected(old('Email') === $group->Email)>
                                    {{ $group->Email }}{{ $group->Description ? ' - ' . $group->Description : '' }}
                                </option>
                            @endforeach
                        </select>
                        @if ($emailGroups->isEmpty())
                            <div class="form-text text-danger">Corporate Email untuk Division user login belum tersedia di Ms_EmailGroup.</div>
                        @endif
                    </div>

                    <input type="hidden" name="Email" id="emailSubmitValue" value="{{ old('Email', 'Fill by IT Infra') }}">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Date From <span class="text-danger">*</span></label>
                        <input type="date" name="DateFrom" id="DateFrom" class="form-control" value="{{ old('DateFrom', now()->toDateString()) }}" min="{{ now()->toDateString() }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Date Until</label>
                        <input type="date" name="DateUntil" id="DateUntil" class="form-control" value="{{ old('DateUntil', '1900-01-01') }}">
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Purpose <span class="text-danger">*</span></label>
                        <textarea name="Purpose" class="form-control" rows="4" maxlength="3000" required>{{ old('Purpose', 'Kebutuhan Pekerjaan') }}</textarea>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label">Notes</label>
                        <textarea name="Notes" class="form-control" rows="3" maxlength="1000">{{ old('Notes') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('employee-email.index') }}" class="btn btn-secondary">Close</a>
            <button type="submit" class="btn btn-primary" {{ !$empForm ? 'disabled' : '' }}>Submit</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const reqType = document.getElementById('ReqType');
    const dateFrom = document.getElementById('DateFrom');
    const dateUntil = document.getElementById('DateUntil');
    const emailType = document.getElementById('EmailType');
    const personalWrapper = document.getElementById('personalEmailWrapper');
    const corporateWrapper = document.getElementById('corporateEmailWrapper');
    const personalEmail = document.getElementById('personalEmail');
    const corporateEmail = document.getElementById('corporateEmail');
    const emailSubmitValue = document.getElementById('emailSubmitValue');

    function syncDateUntil() {
        const permanent = reqType.value === 'Permanent';
        dateUntil.disabled = permanent;
        dateUntil.readOnly = permanent;
        if (permanent) dateUntil.value = '1900-01-01';
        if (!permanent && dateUntil.value === '1900-01-01') dateUntil.value = '';
        dateUntil.min = dateFrom.value || '';
    }

    function syncEmail() {
        const corporate = emailType.value === 'Corporate';
        personalWrapper.classList.toggle('d-none', corporate);
        corporateWrapper.classList.toggle('d-none', !corporate);
        personalEmail.disabled = false;
        personalEmail.readOnly = true;
        personalEmail.classList.add('readonly-field');
        corporateEmail.disabled = !corporate;
        personalEmail.required = false;
        if (!corporate) {
            personalEmail.value = 'Fill by IT Infra';
        }
        corporateEmail.required = corporate;
        emailSubmitValue.value = corporate ? corporateEmail.value : 'Fill by IT Infra';
    }

    
    corporateEmail.addEventListener('change', () => emailSubmitValue.value = corporateEmail.value);
    reqType.addEventListener('change', syncDateUntil);
    dateFrom.addEventListener('change', syncDateUntil);
    emailType.addEventListener('change', syncEmail);

    syncDateUntil();
    syncEmail();
});
</script>
@endpush
