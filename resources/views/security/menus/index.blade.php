@extends('layouts.app')

@section('title', 'Menus')

@section('content')

<div class="card">

    <div class="card-header d-flex justify-content-between align-items-center">

        <h3 class="card-title">
            Menu Management
        </h3>

        <a
            href="{{ route('security.menus.create') }}"
            class="btn btn-primary"
        >

            <i class="bi bi-plus-lg"></i>

            Add Menu

        </a>

    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered table-hover align-middle">

                <thead>

                    <tr>

                        <th width="60">
                            No
                        </th>

                        <th>
                            Code
                        </th>

                        <th>
                            Name
                        </th>

                        <th>
                            Parent
                        </th>

                        <th>
                            Route
                        </th>

                        <th>
                            Sort
                        </th>

                        <th>
                            Status
                        </th>

                        <th width="120">
                            Action
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($menus as $menu)

                        <tr>

                            <td>
                                {{ $menus->firstItem() + $loop->index }}
                            </td>

                            <td>
                                {{ $menu->Code }}
                            </td>

                            <td>

                                @if($menu->ParentID)
                                    &nbsp;&nbsp;&nbsp;↳
                                @endif

                                {{ $menu->Name }}

                            </td>

                            <td>

                                @if($menu->parent)
                                    {{ $menu->parent->Name }}
                                @else
                                    -
                                @endif

                            </td>

                            <td>
                                {{ $menu->Route ?? '-' }}
                            </td>

                            <td>
                                {{ $menu->SortOrder }}
                            </td>

                            <td>

                                @if($menu->IsActive)

                                    <span class="badge text-bg-success">
                                        Active
                                    </span>

                                @else

                                    <span class="badge text-bg-danger">
                                        Inactive
                                    </span>

                                @endif

                            </td>

                            <td>

                                <a
                                    href="{{ route('security.menus.edit', $menu->MenuID) }}"
                                    class="btn btn-sm btn-warning"
                                >

                                    <i class="bi bi-pencil-square"></i>

                                </a>

                                <form
                                    action="{{ route('security.menus.destroy', $menu->MenuID) }}"
                                    method="POST"
                                    class="d-inline"
                                >

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-sm btn-danger"
                                        onclick="return confirm('Yakin ingin menghapus menu ini?')"
                                    >

                                        <i class="bi bi-trash"></i>

                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="8"
                                class="text-center"
                            >
                                No Data
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

            <div class="mt-3">

                {{ $menus->links() }}

            </div>

        </div>

    </div>

</div>

@endsection