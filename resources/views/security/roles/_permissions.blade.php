<div class="card mt-4">

    <div class="card-header d-flex justify-content-between align-items-center">

        <h5 class="mb-0">
            Hak Akses Menu
        </h5>

        <div class="form-check">

            <input type="checkbox" class="form-check-input" id="checkAllPermissions">

            <label class="form-check-label" for="checkAllPermissions">
                Pilih Semua
            </label>

        </div>

    </div>

    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-bordered table-hover mb-0 align-middle">

                <thead>

                    <tr>

                        <th>
                            Menu
                        </th>

                        <th class="text-center">
                            Buka
                        </th>

                        <th class="text-center">
                            Tambah
                        </th>

                        <th class="text-center">
                            Edit
                        </th>

                        <th class="text-center">
                            Hapus
                        </th>

                        <th class="text-center">
                            Cetak
                        </th>

                        <th class="text-center">
                            Ekspor
                        </th>

                        <th class="text-center">
                            Setujui
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($menus as $menu)

                        @php
                            $permission = $permissions->get($menu->MenuID);
                            $isParent = is_null($menu->ParentID);
                        @endphp

                        <tr>

                            <td>

                                @if ($isParent)
                                    <strong>

                                        <i class="bi bi-folder me-1"></i>

                                        {{ $menu->Name }}

                                    </strong>
                                @else
                                    <span class="ms-4 text-muted">
                                        ↳
                                    </span>

                                    {{ $menu->Name }}
                                @endif

                                <small class="text-muted ms-1">
                                    ({{ $menu->Code }})
                                </small>

                            </td>

                            @foreach (['CanOpen', 'CanAdd', 'CanEdit', 'CanDelete', 'CanPrint', 'CanExport', 'CanApprove'] as $permissionName)
                                <td class="text-center">

                                    <input type="checkbox" class="form-check-input permission-checkbox"
                                        data-menu-id="{{ $menu->MenuID }}" data-permission="{{ $permissionName }}"
                                        name="permissions[{{ $menu->MenuID }}][{{ $permissionName }}]" value="1"
                                        @checked(old("permissions.{$menu->MenuID}.{$permissionName}", $permission?->{$permissionName} ?? false))>

                                </td>
                            @endforeach

                        </tr>

                    @empty

                        <tr>

                            <td colspan="8" class="text-center py-4 text-muted">
                                Tidak ada menu yang tersedia.
                            </td>

                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>


@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const allCheckbox = document.getElementById(
                'checkAllPermissions'
            );

            const checkboxes = document.querySelectorAll(
                '.permission-checkbox'
            );


            /*
             * Update status checkbox "Pilih Semua"
             */
            function updateAllState() {

                if (!checkboxes.length) {
                    return;
                }

                const checkedCount =
                    document.querySelectorAll(
                        '.permission-checkbox:checked'
                    ).length;

                allCheckbox.checked =
                    checkedCount === checkboxes.length;

                allCheckbox.indeterminate =
                    checkedCount > 0 &&
                    checkedCount < checkboxes.length;
            }


            /*
             * Pilih semua permission
             */
            allCheckbox.addEventListener(
                'change',
                function() {

                    checkboxes.forEach(function(checkbox) {

                        checkbox.checked =
                            allCheckbox.checked;

                    });

                }
            );


            /*
             * Logic masing-masing permission
             */
            checkboxes.forEach(function(checkbox) {

                checkbox.addEventListener(
                    'change',
                    function() {

                        const menuId =
                            this.dataset.menuId;

                        const permission =
                            this.dataset.permission;


                        /*
                         * Jika Buka dimatikan,
                         * seluruh permission menu dimatikan.
                         */
                        if (
                            permission === 'CanOpen' &&
                            !this.checked
                        ) {

                            document
                                .querySelectorAll(
                                    `.permission-checkbox[data-menu-id="${menuId}"]`
                                )
                                .forEach(function(item) {

                                    item.checked = false;

                                });

                        }


                        /*
                         * Jika permission lain diaktifkan,
                         * otomatis Buka ikut aktif.
                         */
                        if (
                            permission !== 'CanOpen' &&
                            this.checked
                        ) {

                            const openCheckbox =
                                document.querySelector(
                                    `.permission-checkbox[data-menu-id="${menuId}"][data-permission="CanOpen"]`
                                );

                            if (openCheckbox) {

                                openCheckbox.checked = true;

                            }

                        }


                        updateAllState();

                    }
                );

            });


            /*
             * Initial state
             */
            updateAllState();

        });
    </script>
@endpush
