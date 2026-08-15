<div class="row">

    <div class="col-md-6 mb-3">

        <label class="form-label">
            Username
        </label>

        <input type="text" name="Username" value="{{ old('Username', $user->Username ?? '') }}"
            class="form-control @error('Username') is-invalid @enderror">

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

        <input type="text" name="FullName" value="{{ old('FullName', $user->FullName ?? '') }}"
            class="form-control @error('FullName') is-invalid @enderror">

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

        <input type="email" name="Email" value="{{ old('Email', $user->Email ?? '') }}"
            class="form-control @error('Email') is-invalid @enderror">

        @error('Email')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>


    <div class="col-md-6 mb-3">

        <label class="form-label">
            Nomor Telepon
        </label>

        <input type="text" name="PhoneNumber" value="{{ old('PhoneNumber', $user->PhoneNumber ?? '') }}"
            class="form-control @error('PhoneNumber') is-invalid @enderror">

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
                Password
            </label>

            <input type="password" name="Password" class="form-control @error('Password') is-invalid @enderror">

            @error('Password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror

        </div>


        <div class="col-md-6 mb-3">

            <label class="form-label">
                Konfirmasi Password
            </label>

            <input type="password" name="Password_confirmation" class="form-control">

        </div>

    </div>
@endif


<div class="row">

    <div class="col-md-6 mb-3">

        <label class="form-label">
            Role
            <span class="text-danger">*</span>
        </label>

        <select name="RoleID" class="form-select @error('RoleID') is-invalid @enderror">

            <option value="">
                -- Pilih Role --
            </option>

            @foreach ($roles as $role)
                <option value="{{ $role->RoleID }}" @selected(old('RoleID', $user->RoleID ?? '') == $role->RoleID)>
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
