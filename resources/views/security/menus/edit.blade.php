@extends('layouts.app')

@section('title', 'Menu Management - Edit Menu')

@section('content')

    <div class="card">

        <div class="card-header">

            <h3 class="card-title">
                Menu Management - Edit Menu
            </h3>

        </div>

        <form method="POST" action="{{ route('security.menus.update', $menu->MenuID) }}">

            @csrf
            @method('PUT')

            <div class="card-body">

                @include('security.menus._form')

                <hr class="my-4">
                <section aria-labelledby="menu-permissions-heading">
                    <input type="hidden" name="permission_configuration_submitted" value="1">
                    <h4 id="menu-permissions-heading" class="h6">Available permissions for this menu</h4>
                    <p class="text-muted small mb-3">These permissions become available in Role Management. Saving a mapping does not grant it to any role.</p>
                    @php
                        $configuredPermissionIds = old('permission_ids', $permissions->where('is_configured', true)->pluck('PermissionID')->all());
                    @endphp
                    <div class="row">
                        @forelse ($permissions as $permission)
                            <div class="col-sm-6 col-lg-4 mb-2">
                                <label class="form-check">
                                    <input class="form-check-input" type="checkbox" name="permission_ids[]"
                                        value="{{ $permission->PermissionID }}"
                                        @checked(in_array($permission->PermissionID, $configuredPermissionIds))>
                                    <span class="form-check-label">{{ $permission->Name }}</span>
                                    <small class="text-muted">({{ $permission->Name }})</small>
                                </label>
                            </div>
                        @empty
                            <div class="col-12 text-muted">No active master permissions.</div>
                        @endforelse
                    </div>
                    @error('permission_ids')
                        <div class="text-danger small mt-2">{{ $message }}</div>
                    @enderror
                </section>

            </div>

            <div class="card-footer">

                <a href="{{ route('security.menus.index') }}" class="btn btn-secondary">
                    Cancel
                </a>

                <button type="submit" class="btn btn-primary">
                    Update
                </button>

            </div>

        </form>

    </div>

@endsection
