@foreach ($menus as $menu)
    @php

        $children = $menuTree->get($menu->MenuID, collect());

        $permission = $permissions->get($menu->MenuID);

    @endphp

    @if ($children->isEmpty())
        <tr>

            <td>

                <span class="ms-4">

                    <i class="bi bi-arrow-return-right text-muted"></i>

                    <strong>
                        {{ $menu->Name }}
                    </strong>

                    <small class="text-muted">
                        ({{ $menu->Code }})
                    </small>

                </span>

            </td>

            @foreach (['CanOpen', 'CanAdd', 'CanEdit', 'CanDelete', 'CanPrint', 'CanExport', 'CanApprove'] as $permissionName)
                <td class="text-center">

                    <input type="checkbox" class="form-check-input"
                        name="permissions[{{ $menu->MenuID }}][{{ $permissionName }}]" value="1"
                        @checked(old("permissions.{$menu->MenuID}.{$permissionName}", $permission?->{$permissionName} ?? false))>

                </td>
            @endforeach

        </tr>
    @else
        <tr class="table-light">

            <td colspan="8">

                @if ($menu->Icon)
                    <i class="{{ $menu->Icon }}"></i>
                @endif

                <strong>
                    {{ $menu->Name }}
                </strong>

                <small class="text-muted">
                    ({{ $menu->Code }})
                </small>

            </td>

        </tr>

        @include('security.roles._permission_rows', [
            'menus' => $children,
            'menuTree' => $menuTree,
            'permissions' => $permissions,
        ])
    @endif
@endforeach
