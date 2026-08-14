<div class="row">

    <div class="col-md-6 mb-3">

        <label class="form-label">
            Code
        </label>

        <input
            type="text"
            name="Code"
            class="form-control @error('Code') is-invalid @enderror"
            value="{{ old('Code', $menu->Code ?? '') }}"
            maxlength="30"
            required
        >

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
            class="form-control @error('Name') is-invalid @enderror"
            value="{{ old('Name', $menu->Name ?? '') }}"
            maxlength="100"
            required
        >

        @error('Name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>


    <div class="col-md-6 mb-3">

        <label class="form-label">
            Parent Menu
        </label>

        <select
            name="ParentID"
            class="form-select @error('ParentID') is-invalid @enderror"
        >

            <option value="">
                -- No Parent --
            </option>

            @foreach($parents as $parent)

                <option
                    value="{{ $parent->MenuID }}"
                    @selected(
                        old(
                            'ParentID',
                            $menu->ParentID ?? ''
                        ) == $parent->MenuID
                    )
                >

                    {{ $parent->Name }}

                </option>

            @endforeach

        </select>

        @error('ParentID')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>


    <div class="col-md-6 mb-3">

        <label class="form-label">
            Sort Order
        </label>

        <input
            type="number"
            name="SortOrder"
            class="form-control"
            value="{{ old('SortOrder', $menu->SortOrder ?? 0) }}"
            min="0"
            required
        >

    </div>


    <div class="col-md-6 mb-3">

        <label class="form-label">
            Route
        </label>

        <input
            type="text"
            name="Route"
            class="form-control"
            value="{{ old('Route', $menu->Route ?? '') }}"
            maxlength="255"
            placeholder="security.users.index"
        >

    </div>


    <div class="col-md-6 mb-3">

        <label class="form-label">
            URL
        </label>

        <input
            type="text"
            name="URL"
            class="form-control"
            value="{{ old('URL', $menu->URL ?? '') }}"
            maxlength="255"
            placeholder="/security/users"
        >

    </div>


    <div class="col-md-6 mb-3">

        <label class="form-label">
            Icon
        </label>

        <input
            type="text"
            name="Icon"
            class="form-control"
            value="{{ old('Icon', $menu->Icon ?? '') }}"
            maxlength="100"
            placeholder="bi bi-people"
        >

    </div>


    <div class="col-md-6 mb-3">

        <label class="form-label">
            Status
        </label>

        <div class="form-check form-switch mt-2">

            <input
                type="hidden"
                name="IsActive"
                value="0"
            >

            <input
                type="checkbox"
                name="IsActive"
                value="1"
                class="form-check-input"
                @checked(old('IsActive', $menu->IsActive ?? true))
            >

            <label class="form-check-label">
                Active
            </label>

        </div>

    </div>


    <div class="col-md-6 mb-3">

        <label class="form-label">
            Menu Type
        </label>

        <div class="form-check form-switch mt-2">

            <input
                type="hidden"
                name="IsMenu"
                value="0"
            >

            <input
                type="checkbox"
                name="IsMenu"
                value="1"
                class="form-check-input"
                @checked(old('IsMenu', $menu->IsMenu ?? true))
            >

            <label class="form-check-label">
                Display as Menu
            </label>

        </div>

    </div>

</div>