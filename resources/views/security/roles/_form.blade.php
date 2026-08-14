<div class="row">

    <div class="col-md-6 mb-3">

        <label class="form-label">

            Code

        </label>

        <input
            type="text"
            name="Code"
            value="{{ old('Code', $role->Code ?? '') }}"
            class="form-control @error('Code') is-invalid @enderror">

        @error('Code')

            <div class="invalid-feedback">

                {{ $message }}

            </div>

        @enderror

    </div>

    <div class="col-md-6 mb-3">

        <label class="form-label">

            Name

        </label>

        <input
            type="text"
            name="Name"
            value="{{ old('Name', $role->Name ?? '') }}"
            class="form-control @error('Name') is-invalid @enderror">

        @error('Name')

            <div class="invalid-feedback">

                {{ $message }}

            </div>

        @enderror

    </div>

</div>

<div class="row">

    <div class="col-md-12 mb-3">

        <label class="form-label">

            Description

        </label>

        <textarea
            name="Description"
            rows="3"
            class="form-control @error('Description') is-invalid @enderror">{{ old('Description', $role->Description ?? '') }}</textarea>

        @error('Description')

            <div class="invalid-feedback">

                {{ $message }}

            </div>

        @enderror

    </div>

</div>

<div class="row">

    <div class="col-md-4 mb-3">

        <label class="form-label">

            Status

        </label>

        <select
            name="IsActive"
            class="form-select">

            <option value="1"
                {{ old('IsActive', $role->IsActive ?? 1) == 1 ? 'selected' : '' }}>

                Active

            </option>

            <option value="0"
                {{ old('IsActive', $role->IsActive ?? 1) == 0 ? 'selected' : '' }}>

                Inactive

            </option>

        </select>

    </div>

</div>