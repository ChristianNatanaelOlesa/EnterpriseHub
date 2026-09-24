<div class="row">

    @if ($mode === 'create')
        <div class="col-md-6 mb-3">

            <label class="form-label">
                Employee Form ID <span class="text-danger">*</span>
            </label>

            <select name="EmpFormID"
                    id="EmpFormID"
                    class="form-select @error('EmpFormID') is-invalid @enderror"
                    required>

                <option value="">-- Pilih Employee --</option>

                @foreach ($employeeForms as $employee)
                    @php
                        $fullName = trim(($employee->FirstName ?? '') . ' ' . ($employee->LastName ?? ''));
                    @endphp

                    <option value="{{ $employee->EmpFormID }}"
                            data-first-name="{{ $employee->FirstName }}"
                            data-last-name="{{ $employee->LastName }}"
                            data-full-name="{{ $fullName }}"
                            data-mobile="{{ $employee->MobileNo }}"
                            data-email="{{ $employee->Email }}"
                            @selected(old('EmpFormID') == $employee->EmpFormID)>
                        {{ $employee->EmpFormID }} - {{ $fullName }}
                    </option>
                @endforeach

            </select>

            @error('EmpFormID')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror

        </div>
    @else
        <div class="col-md-6 mb-3">

            <label class="form-label">
                Employee Form ID
            </label>

            <input type="text"
                   value="{{ $user->EmpFormID ?? '' }}"
                   class="form-control"
                   readonly>

        </div>
    @endif

</div>

<div class="row">

    <div class="col-md-6 mb-3">

        <label class="form-label">
            Username
        </label>

        <input type="text"
               name="Username"
               id="Username"
               value="{{ old('Username', $user->Username ?? '') }}"
               class="form-control @error('Username') is-invalid @enderror"
               @if ($mode === 'create') readonly @endif>

        @error('Username')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>

    <div class="col-md-6 mb-3">

        <label class="form-label">
            Nama Lengkap
        </label>

        <input type="text"
               name="FullName"
               id="FullName"
               value="{{ old('FullName', $user->FullName ?? '') }}"
               class="form-control @error('FullName') is-invalid @enderror"
               @if ($mode === 'create') readonly @endif>

        @error('FullName')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>

</div>

<div class="row">

    <div class="col-md-6 mb-3">

        <label class="form-label">
            Email
        </label>

        <input type="email"
               name="Email"
               id="Email"
               value="{{ old('Email', $user->Email ?? '') }}"
               class="form-control @error('Email') is-invalid @enderror"
               @if ($mode === 'create') readonly @endif>

        @error('Email')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>

    <div class="col-md-6 mb-3">

        <label class="form-label">
            Mobile Phone
        </label>

        <input type="text"
               name="PhoneNumber"
               id="PhoneNumber"
               value="{{ old('PhoneNumber', $user->PhoneNumber ?? '') }}"
               class="form-control @error('PhoneNumber') is-invalid @enderror"
               @if ($mode === 'create') readonly @endif>

        @error('PhoneNumber')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>

</div>

@if ($mode === 'create')
    <div class="row">

        <div class="col-md-6 mb-3">

            <label class="form-label">
                Password Default
            </label>

            <input type="text"
                   id="PasswordPreview"
                   class="form-control"
                   value=""
                   readonly>

            <small class="text-muted">
                Format: Username + !23
            </small>

        </div>

    </div>
@endif

<div class="row">

    <div class="col-md-6 mb-3">

        <label class="form-label">
            Role <span class="text-danger">*</span>
        </label>

        <select name="RoleID" class="form-select @error('RoleID') is-invalid @enderror">

            <option value="">
                -- Pilih Role --
            </option>

            @foreach ($roles as $role)
                <option value="{{ $role->RoleID }}"
                        @selected(old('RoleID', $user->RoleID ?? '') == $role->RoleID)>
                    {{ $role->Code }} - {{ $role->Name }}
                </option>
            @endforeach

        </select>

        @error('RoleID')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>

    <div class="col-md-6 mb-3">

        <label class="form-label">
            Status
        </label>

        <select name="IsActive" class="form-select @error('IsActive') is-invalid @enderror">

            <option value="1" @selected(old('IsActive', $user->IsActive ?? 1) == 1)>
                Aktif
            </option>

            <option value="0" @selected(old('IsActive', $user->IsActive ?? 1) == 0)>
                Tidak Aktif
            </option>

        </select>

        @error('IsActive')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>

</div>

@if ($mode === 'create')
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const employeeSelect = document.getElementById('EmpFormID');
    const usernameInput = document.getElementById('Username');
    const fullNameInput = document.getElementById('FullName');
    const emailInput = document.getElementById('Email');
    const phoneInput = document.getElementById('PhoneNumber');
    const passwordPreview = document.getElementById('PasswordPreview');

    function clearEmployeeFields() {
        usernameInput.value = '';
        fullNameInput.value = '';
        emailInput.value = '';
        phoneInput.value = '';
        passwordPreview.value = '';
    }

    function fillEmployeeFields() {
        const option = employeeSelect.options[employeeSelect.selectedIndex];

        if (!option || !option.value) {
            clearEmployeeFields();
            return;
        }

        const username = option.dataset.firstName || '';

        usernameInput.value = username;
        fullNameInput.value = option.dataset.fullName || '';
        emailInput.value = option.dataset.email || '';
        phoneInput.value = option.dataset.mobile || '';
        passwordPreview.value = username ? username + '!23' : '';
    }

    employeeSelect.addEventListener('change', fillEmployeeFields);

    fillEmployeeFields();
});
</script>
@endpush
@endif
