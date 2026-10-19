<?php

namespace App\Services\Security;

use App\Repositories\Security\MenuRepository;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class MenuService
{
    private const IT_FULFILLMENT_MENUS = [
        '08-03-00', '08-04-00', '08-05-00', '08-06-00', '08-07-00', '08-08-00', '08-09-00',
    ];

    protected MenuRepository $repository;

    public function __construct(MenuRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAll(?string $search = null)
    {
        return $this->repository->getAllMenus(10, $search);
    }

    public function getParents(?string $excludeMenuId = null)
    {
        $menus = $this->repository->getParentMenus();
        $map = $menus->keyBy(fn ($menu) => (string) $menu->MenuID);

        return $menus->filter(function ($menu) use ($excludeMenuId, $map): bool {
            $id = (string) $menu->MenuID;
            if ($id === $excludeMenuId || $this->isDescendantOf($id, $excludeMenuId, $map)) {
                return false;
            }

            try {
                return $this->depthOf($id, $map, []) < 3;
            } catch (ValidationException) {
                return false;
            }
        })->values();
    }

    public function findById(string $id)
    {
        return $this->repository->find($id);
    }

    public function getPermissionConfiguration(string $menuId)
    {
        $canConfigureFulfillment = in_array($menuId, self::IT_FULFILLMENT_MENUS, true);
        $configuredIds = DB::table('sc_menu_permission')->where('MenuID', $menuId)
            ->where('IsActive', true)->whereNull('DeletedDate')->pluck('PermissionID')->map(fn ($id) => (int) $id);

        return DB::table('sc_permission')
            ->where('IsActive', true)->whereNull('DeletedDate')
            ->when(! $canConfigureFulfillment, fn ($query) => $query->where('Name', '<>', 'IT Fulfillment'))
            ->orderBy('Name')->get(['PermissionID', 'Name'])
            ->map(function ($permission) use ($configuredIds) {
                $permission->is_configured = $configuredIds->contains((int) $permission->PermissionID);
                return $permission;
            });
    }

    public function store(array $data)
    {
        return DB::transaction(function () use ($data) {

            $this->validateRoute($data['Route'] ?? null);
            $parentId = $data['ParentID'] ?? null;
            $data['Lvl'] = $this->validateHierarchy(null, $parentId);
            $data['MenuID'] = SecurityIdGenerator::nextMenuId($parentId === null ? null : (string) $parentId);

            $data['InputUser'] = auth()->user()->Username;
            $data['InputDate'] = now();

            return $this->repository->create($data);
        });
    }

    public function update(string $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {

            $configurePermissions = (bool) ($data['permission_configuration_submitted'] ?? false);
            $permissionIds = array_map('intval', $data['permission_ids'] ?? []);
            unset($data['permission_ids']);
            unset($data['permission_configuration_submitted']);

            $this->validateRoute($data['Route'] ?? null);
            $data['Lvl'] = $this->validateHierarchy((string) $id, $data['ParentID'] ?? null);

            $data['ModifUser'] = auth()->user()->Username;
            $data['ModifDate'] = now();

            $menu = $this->repository->update($id, $data);
            if ($configurePermissions) {
                $this->syncMenuPermissions($id, $permissionIds);
            }

            return $menu;
        });
    }

    private function syncMenuPermissions(string $menuId, array $permissionIds): void
    {
        $permissionIds = array_values(array_unique($permissionIds));
        $isITFulfillmentMenu = in_array($menuId, self::IT_FULFILLMENT_MENUS, true);
        $requestedITFulfillment = DB::table('sc_permission')->whereIn('PermissionID', $permissionIds)
            ->where('Name', 'IT Fulfillment')->exists();
        if ($requestedITFulfillment && ! $isITFulfillmentMenu) {
            throw ValidationException::withMessages(['permission_ids' => 'IT Fulfillment hanya tersedia pada menu Employee Request yang didukung.']);
        }
        $current = DB::table('sc_menu_permission')->where('MenuID', $menuId)->get()->keyBy('PermissionID');
        $removed = $current->filter(
            fn ($mapping, $permissionId) =>
            (bool) $mapping->IsActive && ! in_array((int) $permissionId, $permissionIds, true)
        );

        foreach ($removed as $mapping) {
            if (DB::table('sc_role_permission')->where('MenuPermissionID', $mapping->MenuPermissionID)
                ->where('IsActive', true)->whereNull('DeletedDate')->exists()) {
                throw ValidationException::withMessages([
                    'permission_ids' => 'Mapping permission tidak dapat dinonaktifkan selama masih diberikan kepada role. Cabut assignment role terlebih dahulu.',
                ]);
            }
        }

        $username = auth()->user()->Username;
        $now = now();
        foreach ($permissionIds as $permissionId) {
            $mapping = $current->get($permissionId);
            if ($mapping) {
                DB::table('sc_menu_permission')->where('MenuPermissionID', $mapping->MenuPermissionID)->update([
                    'IsActive' => true, 'DeletedBy' => null, 'DeletedDate' => null,
                    'ModifUser' => $username, 'ModifDate' => $now,
                ]);
                continue;
            }

            DB::table('sc_menu_permission')->insert([
                'MenuID' => $menuId, 'PermissionID' => $permissionId, 'IsActive' => true,
                'InputUser' => $username, 'InputDate' => $now, 'ModifUser' => $username, 'ModifDate' => $now,
            ]);
        }

        foreach ($removed as $mapping) {
            DB::table('sc_menu_permission')->where('MenuPermissionID', $mapping->MenuPermissionID)->update([
                'IsActive' => false, 'DeletedBy' => $username, 'DeletedDate' => $now,
                'ModifUser' => $username, 'ModifDate' => $now,
            ]);
        }
    }

    public function delete(string $id)
    {
        return DB::transaction(function () use ($id) {

            if (DB::table('sc_menu')->where('ParentID', $id)->whereNull('DeletedDate')->exists()) {
                throw ValidationException::withMessages([
                    'ParentID' => 'Menu parent tidak dapat dinonaktifkan selama masih memiliki submenu.',
                ]);
            }

            return $this->repository->update($id, [

                'IsActive'    => false,
                'DeletedBy'   => auth()->user()->Username,
                'DeletedDate' => now(),

            ]);
        });
    }

    private function validateRoute(?string $routeName): void
    {
        if ($routeName !== null && trim($routeName) !== '' && ! Route::has($routeName)) {
            throw ValidationException::withMessages([
                'Route' => 'Nama route tidak terdaftar pada aplikasi.',
            ]);
        }
    }

    /** Validate parent links, prevent cycles, and limit the resulting tree to three levels. */
    private function validateHierarchy(?string $menuId, mixed $parentId): int
    {
        $menus = DB::table('sc_menu')
            ->whereNull('DeletedDate')
            ->get(['MenuID', 'ParentID'])
            ->keyBy(fn ($menu) => (string) $menu->MenuID);

        if ($menuId !== null && ! $menus->has($menuId)) {
            abort(404);
        }

        $parentId = $parentId === null || $parentId === '' ? null : (string) $parentId;
        if ($parentId !== null && ! $menus->has($parentId)) {
            throw ValidationException::withMessages(['ParentID' => 'Parent menu tidak ditemukan.']);
        }

        if ($menuId !== null && $parentId === $menuId) {
            throw ValidationException::withMessages(['ParentID' => 'Menu tidak dapat menjadi parent bagi dirinya sendiri.']);
        }

        if ($menuId !== null) {
            $menus[$menuId]->ParentID = $parentId;
        }

        $parentDepth = $parentId === null ? 0 : $this->depthOf($parentId, $menus, []);
        if ($parentDepth + 1 > 3) {
            throw ValidationException::withMessages(['ParentID' => 'Hierarki menu maksimal tiga level.']);
        }

        if ($menuId !== null) {
            $subtreeDepth = $this->subtreeDepth($menuId, $menus, []);
            if ($parentDepth + $subtreeDepth > 3) {
                throw ValidationException::withMessages(['ParentID' => 'Pemindahan ini akan membuat submenu melampaui tiga level.']);
            }
        }

        return $parentDepth + 1;
    }

    private function depthOf(string $menuId, $menus, array $visited): int
    {
        if (isset($visited[$menuId])) {
            throw ValidationException::withMessages(['ParentID' => 'Struktur menu memiliki circular reference.']);
        }

        $menu = $menus->get($menuId);
        if (! $menu) {
            throw ValidationException::withMessages(['ParentID' => 'Parent menu tidak ditemukan.']);
        }

        $parentId = $menu->ParentID === null ? null : (string) $menu->ParentID;
        if ($parentId === null) {
            return 1;
        }

        $visited[$menuId] = true;
        return 1 + $this->depthOf($parentId, $menus, $visited);
    }

    private function subtreeDepth(string $menuId, $menus, array $visited): int
    {
        if (isset($visited[$menuId])) {
            throw ValidationException::withMessages(['ParentID' => 'Struktur menu memiliki circular reference.']);
        }

        $visited[$menuId] = true;
        $childDepths = $menus
            ->filter(fn ($menu) => $menu->ParentID !== null && (string) $menu->ParentID === $menuId)
            ->map(fn ($child) => $this->subtreeDepth((string) $child->MenuID, $menus, $visited));

        return 1 + ($childDepths->isEmpty() ? 0 : $childDepths->max());
    }

    private function isDescendantOf(string $menuId, ?string $ancestorId, $menus): bool
    {
        if ($ancestorId === null) {
            return false;
        }

        $parentId = $menus->get($menuId)?->ParentID;
        $visited = [];
        while ($parentId !== null) {
            $parentId = (string) $parentId;
            if ($parentId === $ancestorId) {
                return true;
            }
            if (isset($visited[$parentId])) {
                return true;
            }
            $visited[$parentId] = true;
            $parentId = $menus->get($parentId)?->ParentID;
        }

        return false;
    }
}
