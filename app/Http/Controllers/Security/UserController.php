<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use App\Models\EForm\TrEmpForm;
use App\Http\Requests\Security\StoreUserRequest;
use App\Http\Requests\Security\UpdateUserRequest;
use App\Services\Security\RoleService;
use App\Services\Security\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected UserService $userService;

    protected RoleService $roleService;

    public function __construct(
        UserService $userService,
        RoleService $roleService
    ) {
        $this->userService = $userService;
        $this->roleService = $roleService;
    }

    public function index(Request $request)
    {
        $users = $this->userService->getAll($request->input('search'));

        return view(
            'security.users.index',
            compact('users')
        );
    }

    public function create()
    {
        $roles = $this->roleService->getActiveRoles();

        $employeeForms = TrEmpForm::query()
            ->select([
                'EmpFormID',
                'FirstName',
                'LastName',
                'MobileNo',
                'Email',
            ])
            ->orderBy('FirstName')
            ->orderBy('LastName')
            ->get();

        return view(
            'security.users.create',
            compact('roles', 'employeeForms')
        );
    }

    public function store(StoreUserRequest $request)
    {
        $this->userService->store(
            $request->validated()
        );

        return redirect()
            ->route('security.users.index')
            ->with(
                'success',
                'User berhasil ditambahkan.'
            );
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $user = $this->userService->findById($id);

        $roles = $this->roleService->getActiveRoles();

        return view(
            'security.users.edit',
            compact(
                'user',
                'roles'
            )
        );
    }

    public function update(
        UpdateUserRequest $request,
        string $id
    ) {
        $this->userService->update(
            $id,
            $request->validated()
        );

        return redirect()
            ->route('security.users.index')
            ->with(
                'success',
                'User berhasil diupdate.'
            );
    }

    public function destroy(string $id)
    {
        $this->userService->delete($id);

        return redirect()
            ->route('security.users.index')
            ->with(
                'success',
                'User berhasil dihapus.'
            );
    }

    public function resetPassword(string $id)
    {
        $this->userService->resetPassword($id);

        return redirect()
            ->route('security.users.index')
            ->with(
                'success',
                'Password berhasil direset menjadi default.'
            );
    }

    public function toggleStatus(string $id)
    {
        $this->userService->toggleStatus($id);

        return redirect()
            ->route('security.users.index')
            ->with(
                'success',
                'Status user berhasil diubah.'
            );
    }
}
