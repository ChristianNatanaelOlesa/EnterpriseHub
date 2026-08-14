<div class="card mt-4">

    <div class="card-header">

        <h5 class="mb-0">
            Menu Permissions
        </h5>

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
                            Open
                        </th>

                        <th class="text-center">
                            Add
                        </th>

                        <th class="text-center">
                            Edit
                        </th>

                        <th class="text-center">
                            Delete
                        </th>

                        <th class="text-center">
                            Print
                        </th>

                        <th class="text-center">
                            Export
                        </th>

                        <th class="text-center">
                            Approve
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($menus as $menu)

                        @php
                            $permission = $permissions->get($menu->MenuID);
                        @endphp

                        <tr>

                            <td>

                                @if($menu->ParentID)
                                    &nbsp;&nbsp;&nbsp;&nbsp;↳
                                @endif

                                <strong>
                                    {{ $menu->Name }}
                                </strong>

                                <small class="text-muted">
                                    ({{ $menu->Code }})
                                </small>

                            </td>

                            @foreach([
                                'CanOpen',
                                'CanAdd',
                                'CanEdit',
                                'CanDelete',
                                'CanPrint',
                                'CanExport',
                                'CanApprove'
                            ] as $permissionName)

                                <td class="text-center">

                                    <input
                                        type="checkbox"
                                        class="form-check-input"
                                        name="permissions[{{ $menu->MenuID }}][{{ $permissionName }}]"
                                        value="1"
                                        @checked(
                                            old(
                                                "permissions.{$menu->MenuID}.{$permissionName}",
                                                $permission?->{$permissionName} ?? false
                                            )
                                        )
                                    >

                                </td>

                            @endforeach

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="8"
                                class="text-center"
                            >
                                No menu available.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>