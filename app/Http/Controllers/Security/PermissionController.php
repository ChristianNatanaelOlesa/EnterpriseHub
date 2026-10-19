<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use App\Http\Requests\Security\StorePermissionRequest;
use App\Http\Requests\Security\UpdatePermissionRequest;
use App\Services\Security\PermissionService;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function __construct(private PermissionService $permissionService)
    {
    }

    public function index(Request $request)
    {
        $permissions = $this->permissionService->getAll($request->input('search'));

        return view('security.permissions.index', compact('permissions'));
    }

    public function create()
    {
        return view('security.permissions.create');
    }

    public function store(StorePermissionRequest $request)
    {
        $this->permissionService->store($request->validated());

        return redirect()->route('security.permissions.index')
            ->with('success', 'Permission berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $permission = $this->permissionService->findById((int) $id);

        return view('security.permissions.edit', compact('permission'));
    }

    public function update(UpdatePermissionRequest $request, string $id)
    {
        $this->permissionService->update((int) $id, $request->validated());

        return redirect()->route('security.permissions.index')
            ->with('success', 'Permission berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $this->permissionService->deactivate((int) $id);

        return redirect()->route('security.permissions.index')
            ->with('success', 'Permission berhasil dinonaktifkan.');
    }
}
