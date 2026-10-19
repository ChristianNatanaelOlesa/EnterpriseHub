<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use App\Http\Requests\Security\StoreRoleRequest;
use App\Http\Requests\Security\UpdateRoleRequest;
use App\Services\Security\RoleService;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    protected RoleService $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function index(Request $request)
    {
        $roles = $this->roleService->getAll($request->input('search'));

        return view(
            'security.roles.index',
            compact('roles')
        );
    }

    public function create()
    {
        $menuPermissions = $this->roleService->getMenuPermissions();

        return view(
            'security.roles.create',
            compact('menuPermissions')
        );
    }

    public function store(StoreRoleRequest $request)
    {
        $data = $request->validated();

        $menuPermissions = $data['menu_permissions'] ?? [];
        unset($data['menu_permissions']);

        $this->roleService->store(
            $data,
            $menuPermissions
        );

        return redirect()
            ->route('security.roles.index')
            ->with(
                'success',
                'Role dan hak akses berhasil ditambahkan.'
            );
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $role = $this->roleService->findById($id);

        $menuPermissions = $this->roleService->getMenuPermissions();
        $selectedPermissions = $this->roleService->getRolePermissions($role->RoleID);

        return view(
            'security.roles.edit',
            compact('role', 'menuPermissions', 'selectedPermissions')
        );
    }

    public function update(
        UpdateRoleRequest $request,
        string $id
    ) {
        $data = $request->validated();

        $menuPermissions = $data['menu_permissions'] ?? [];
        unset($data['menu_permissions']);

        $this->roleService->update(
            $id,
            $data,
            $menuPermissions
        );

        return redirect()
            ->route('security.roles.index')
            ->with(
                'success',
                'Role dan hak akses berhasil diupdate.'
            );
    }

    public function destroy(string $id)
    {
        $this->roleService->delete(
            $id
        );

        return redirect()
            ->route('security.roles.index')
            ->with(
                'success',
                'Role dinonaktifkan. Assignment user dan permission tetap disimpan.'
            );
    }
}
