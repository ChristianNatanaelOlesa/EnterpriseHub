<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use App\Models\EForm\TrEmpForm;
use App\Models\Security\ScUser;
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

        /*
         * Only employees that do not yet have a record in Sc_User
         * are eligible to be linked to a new login account.
         *
         * Do not filter by IsActive here: if an EmpFormID already exists
         * in Sc_User, it is already linked to a user account and must not
         * be offered again.
         */
        $employeeForms = TrEmpForm::query()
            ->select([
                'EmpFormID',
                'FirstName',
                'LastName',
                'MobileNo',
                'Email',
            ])
            ->whereNotIn(
                'EmpFormID',
                ScUser::query()
                    ->whereNotNull('EmpFormID')
                    ->where('EmpFormID', '!=', '')
                    ->select('EmpFormID')
            )
            ->orderBy('FirstName')
            ->orderBy('LastName')
            ->get();

        $userRoleIds = old('RoleIDs', []);

        return view(
            'security.users.create',
            compact('roles', 'employeeForms', 'userRoleIds')
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
        $userRoleIds = old(
            'RoleIDs',
            $this->userService->getUserRoleIds((int) $id)
        );

        // Employee Form dropdown for edit mode: include currently assigned EmpFormID.
        $employeeForms = TrEmpForm::query()
            ->select([
                'EmpFormID',
                'FirstName',
                'LastName',
                'MobileNo',
                'Email',
            ])
            ->where(function ($query) use ($user) {
                $query->whereNotIn(
                    'EmpFormID',
                    ScUser::query()
                        ->whereNotNull('EmpFormID')
                        ->where('EmpFormID', '!=', '')
                        ->where('UserID', '!=', $user->UserID)
                        ->select('EmpFormID')
                )
                    ->orWhere('EmpFormID', $user->EmpFormID);
            })
            ->orderBy('FirstName')
            ->orderBy('LastName')
            ->get();

        return view(
            'security.users.edit',
            compact('user', 'roles', 'userRoleIds', 'employeeForms')
        );
    }

    public function showRoles(string $id)
    {
        $user = $this->userService->findById($id);
        $roles = $user->activeRoles()
            ->orderBy('sc_role.RoleID')
            ->get(['sc_role.*', 'sc_user_role.IsActive as pivot_is_active']);

        return response()->json([
            'user' => $user,
            'roles' => $roles,
        ]);
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
