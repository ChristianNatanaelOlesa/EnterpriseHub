<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use App\Http\Requests\Security\StoreRoleRequest;
use App\Http\Requests\Security\UpdateRoleRequest;
use App\Services\Security\RoleService;

class RoleController extends Controller
{
    protected RoleService $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function index()
    {
        $roles = $this->roleService->getAll();

        return view(
            'security.roles.index',
            compact('roles')
        );
    }

    public function create()
    {
        $menus = $this->roleService->getMenus();

        $permissions = collect();

        return view(
            'security.roles.create',
            compact(
                'menus',
                'permissions'
            )
        );
    }

    public function store(StoreRoleRequest $request)
    {
        $data = $request->validated();

        $permissions = $data['permissions'] ?? [];

        unset($data['permissions']);

        $this->roleService->store(
            $data,
            $permissions
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

        $menus = $this->roleService->getMenus();

        $permissions = $this->roleService
            ->getRolePermissions($role->RoleID);

        return view(
            'security.roles.edit',
            compact(
                'role',
                'menus',
                'permissions'
            )
        );
    }

    public function update(
        UpdateRoleRequest $request,
        string $id
    ) {
        $data = $request->validated();

        $permissions = $data['permissions'] ?? [];

        unset($data['permissions']);

        $this->roleService->update(
            $id,
            $data,
            $permissions
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
            (int) $id
        );

        return redirect()
            ->route('security.roles.index')
            ->with(
                'success',
                'Role berhasil dihapus.'
            );
    }
}
