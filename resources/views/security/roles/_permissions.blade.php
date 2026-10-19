<div class="card mt-4">
    <div class="card-header">
        <h5 class="mb-0">Permission per Menu</h5>
    </div>
    <div class="card-body">
        <p class="text-muted mb-3">
            Pilih tindakan secara eksplisit. Permission ditampilkan per menu agar daftar lebih ringkas.
            Akses menu tanpa permission View tidak memberikan akses halaman atau tindakan backend.
        </p>

        @php
            $selected = old('menu_permissions', isset($selectedPermissions) ? $selectedPermissions->keys()->all() : []);
            $permissionGroups = [
                'Transaction' => [],
                'Security' => [],
                'Master' => [],
            ];
            foreach ($menuPermissions->groupBy('MenuID') as $menuItems) {
                $prefix = substr((string) $menuItems->first()->MenuID, 0, 2);
                $category = in_array($prefix, ['03', '04', '05'], true)
                    ? 'Master'
                    : (in_array($prefix, ['01', '02', '06'], true) ? 'Security' : 'Transaction');
                $permissionGroups[$category][] = $menuItems;
            }
        @endphp

        <div class="d-flex justify-content-end gap-2 mb-3">
            <button type="button" class="btn btn-sm btn-outline-primary" data-check-all-permissions>
                <i class="bi bi-check2-square"></i> Checklist semua
            </button>
            <button type="button" class="btn btn-sm btn-outline-secondary" data-uncheck-all-permissions>
                Hapus checklist
            </button>
        </div>

        @foreach (['Transaction', 'Security', 'Master'] as $category)
            <details class="border rounded mb-3" @if ($category === 'Transaction') open @endif>
                <summary class="px-3 py-2 fw-semibold bg-light">
                    {{ $category }} <span class="text-muted fw-normal">({{ count($permissionGroups[$category]) }} menu)</span>
                </summary>
                <div class="table-responsive p-2">
                    <table class="table table-bordered table-hover align-middle mb-0">
                        <thead><tr><th scope="col" style="width:35%">Menu</th><th scope="col">Permission</th></tr></thead>
                        <tbody>
                            @forelse ($permissionGroups[$category] as $items)
                                @php $menu = $items->first(); @endphp
                                <tr>
                                    <td><div class="fw-semibold">{{ $menu->MenuName }}</div><small class="text-muted">{{ $menu->MenuID }}</small></td>
                                    <td><div class="d-flex flex-wrap align-items-center column-gap-3 row-gap-2">
                                        @foreach ($items as $item)
                                            <label class="form-check form-check-inline mb-0">
                                                <input class="form-check-input menu-permission-check" type="checkbox" name="menu_permissions[]" value="{{ $item->MenuPermissionID }}" @checked(in_array($item->MenuPermissionID, $selected))>
                                                <span class="form-check-label">{{ $item->PermissionName }}</span>
                                            </label>
                                        @endforeach
                                    </div></td>
                                </tr>
                            @empty
                                <tr><td colspan="2" class="text-center text-muted">Belum ada permission untuk kategori ini.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </details>
        @endforeach

        <script>
            document.querySelector('[data-check-all-permissions]')?.addEventListener('click', () => {
                document.querySelectorAll('.menu-permission-check').forEach((checkbox) => checkbox.checked = true);
            });
            document.querySelector('[data-uncheck-all-permissions]')?.addEventListener('click', () => {
                document.querySelectorAll('.menu-permission-check').forEach((checkbox) => checkbox.checked = false);
            });
        </script>
    </div>
</div>
