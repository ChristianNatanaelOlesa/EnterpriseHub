<div class="row">

    <div class="col-md-6 mb-3">

        <label class="form-label">
            Menu ID
        </label>

        <input type="text" class="form-control" value="{{ $menu->MenuID ?? 'Generated automatically' }}" readonly>

        @error('MenuID')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>


    <div class="col-md-6 mb-3">

        <label class="form-label">
            Menu
        </label>

        <input type="text" name="Menu" class="form-control @error('Menu') is-invalid @enderror"
            value="{{ old('Menu', $menu->Menu ?? '') }}" maxlength="100" required>

        @error('Menu')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>


    <div class="col-md-6 mb-3"><label class="form-label">Level</label><input class="form-control" value="{{ $menu->Lvl ?? 'Calculated automatically' }}" readonly></div>
    <div class="col-md-6 mb-3"><label class="form-label">Menu Area</label><select name="MenuArea" class="form-select" required><option value="TOP" @selected(old('MenuArea', $menu->MenuArea ?? 'TOP') === 'TOP')>TOP</option><option value="SIDEBAR" @selected(old('MenuArea', $menu->MenuArea ?? '') === 'SIDEBAR')>SIDEBAR</option></select></div>

    <div class="col-md-12 mb-3">
        <label for="ParentID" class="form-label">Parent Menu</label>
        <select id="ParentID" name="ParentID" class="form-select @error('ParentID') is-invalid @enderror">
            <option value="">No parent (Level 1)</option>
            @foreach ($parents as $parent)
                <option value="{{ $parent->MenuID }}" @selected(old('ParentID', $menu->ParentID ?? '') === $parent->MenuID)>
                    {{ $parent->MenuID }} — {{ $parent->Menu }} (Level {{ $parent->Lvl }})
                </option>
            @endforeach
        </select>
        <div class="form-text">MenuID yang dipilih menjadi ParentID. Level dihitung otomatis, maksimal 3 level.</div>
        @error('ParentID')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>


    <div class="col-md-6 mb-3">

        <label class="form-label">
            Sort Order
        </label>

        <input type="number" name="SortOrder" class="form-control"
            value="{{ old('SortOrder', $menu->SortOrder ?? 0) }}" min="0" required>

    </div>


    <div class="col-md-6 mb-3">

        <label class="form-label">
            Route
        </label>

        <input type="text" name="Route" class="form-control" value="{{ old('Route', $menu->Route ?? '') }}"
            maxlength="255" placeholder="security.users.index">

    </div>


    <div class="col-md-6 mb-3">

        <label class="form-label">
            Description
        </label>

        <textarea name="Description" class="form-control" required>{{ old('Description', $menu->Description ?? '') }}</textarea>

    </div>


    <div class="col-md-6 mb-3">

        <label class="form-label">
            Icon
        </label>

        <input type="text" name="Icon" class="form-control" value="{{ old('Icon', $menu->Icon ?? '') }}"
            maxlength="100" placeholder="bi bi-people">

    </div>


    <div class="col-md-6 mb-3">

        <label class="form-label">
            Status
        </label>

        <div class="form-check form-switch mt-2">

            <input type="hidden" name="IsActive" value="0">

            <input type="checkbox" name="IsActive" value="1" class="form-check-input" @checked(old('IsActive', $menu->IsActive ?? true))>

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

            <input type="hidden" name="IsMenu" value="0">

            <input type="checkbox" name="IsMenu" value="1" class="form-check-input" @checked(old('IsMenu', $menu->IsMenu ?? true))>

            <label class="form-check-label">
                Display as Menu
            </label>

        </div>

    </div>

</div>
