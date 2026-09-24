<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use App\Http\Requests\Security\StoreMenuRequest;
use App\Http\Requests\Security\UpdateMenuRequest;
use App\Services\Security\MenuService;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    protected MenuService $menuService;

    public function __construct(MenuService $menuService)
    {
        $this->menuService = $menuService;
    }

    public function index(Request $request)
    {
        $menus = $this->menuService->getAll($request->input('search'));

        return view('security.menus.index', compact('menus'));
    }

    public function create()
    {
        $parents = $this->menuService->getParents();

        return view(
            'security.menus.create',
            compact('parents')
        );
    }

    public function store(StoreMenuRequest $request)
    {
        $this->menuService->store(
            $request->validated()
        );

        return redirect()
            ->route('security.menus.index')
            ->with('success', 'Menu berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $menu = $this->menuService->findById($id);
        $parents = $this->menuService->getParents();

        return view(
            'security.menus.edit',
            compact('menu', 'parents')
        );
    }

    public function update(
        UpdateMenuRequest $request,
        string $id
    ) {
        $this->menuService->update(
            $id,
            $request->validated()
        );

        return redirect()
            ->route('security.menus.index')
            ->with('success', 'Menu berhasil diupdate.');
    }

    public function destroy(string $id)
    {
        $this->menuService->delete($id);

        return redirect()
            ->route('security.menus.index')
            ->with('success', 'Menu berhasil dihapus.');
    }
}
