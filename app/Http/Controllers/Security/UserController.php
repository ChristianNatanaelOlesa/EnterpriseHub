<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use App\Services\Security\UserService;
use App\Http\Requests\Security\StoreUserRequest;
use App\Http\Requests\Security\UpdateUserRequest;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = $this->userService->getAll();

        return view('security.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('security.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $this->userService->store($request->validated());

        return redirect()
            ->route('security.users.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = $this->userService->findById($id);

        return view('security.users.edit', compact('user'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        $this->userService->update($id, $request->validated());

        return redirect()
            ->route('security.users.index')
            ->with('success', 'User berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->userService->delete($id);

        return redirect()
            ->route('security.users.index')
            ->with('success', 'User berhasil dihapus.');
    }

    public function resetPassword(string $id)
    {
        $this->userService->resetPassword($id);

        return redirect()
            ->route('security.users.index')
            ->with('success', 'Password berhasil direset menjadi default.');
    }

    public function toggleStatus(string $id)
    {
        $this->userService->toggleStatus($id);

        return redirect()
            ->route('security.users.index')
            ->with('success', 'Status user berhasil diubah.');
    }
}
