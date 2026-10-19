<div class="row g-3">
    <div class="col-md-6">
        <label for="Name" class="form-label">Nama <span class="text-danger">*</span></label>
        <input id="Name" name="Name" type="text" maxlength="100"
            value="{{ old('Name', $permission->Name ?? '') }}"
            class="form-control @error('Name') is-invalid @enderror" required>
        @error('Name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        <div class="form-text">Gunakan nama unik seperti View, Import, Cancel, atau Reopen.</div>
    </div>

    <div class="col-12">
        @php $active = old('IsActive', isset($permission) ? (int) $permission->IsActive : 1); @endphp
        <input type="hidden" name="IsActive" value="0">
        <div class="form-check">
            <input id="IsActive" name="IsActive" type="checkbox" value="1"
                class="form-check-input @error('IsActive') is-invalid @enderror" @checked((bool) $active)>
            <label for="IsActive" class="form-check-label">Aktif</label>
            @error('IsActive') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>
</div>
