<?php

namespace App\Support;

use App\Models\Security\ScMenu;
use App\Models\Security\ScRoleMenu;

class Permission
{
    protected static array $cache = [];

    public static function can(
        string $permission,
        string $routeName
    ): bool {
        $cacheKey = $permission.':'.$routeName;

        if (array_key_exists($cacheKey, self::$cache)) {
            return self::$cache[$cacheKey];
        }

        if (! auth()->check()) {
            return self::$cache[$cacheKey] = false;
        }

        $roleIds = auth()->user()
            ->roles()
            ->wherePivot('IsActive', true)
            ->pluck('sc_role.RoleID');

        if ($roleIds->isEmpty()) {
            return self::$cache[$cacheKey] = false;
        }

        return self::$cache[$cacheKey] = ScRoleMenu::query()
            ->whereIn('RoleID', $roleIds)
            ->where('IsActive', true)
            ->where($permission, true)
            ->whereHas('menu', function ($query) use ($routeName) {
                $query
                    ->where('Route', $routeName)
                    ->where('IsActive', true);
            })
            ->exists();
    }

    public static function canOpen(string $routeName): bool
    {
        return self::can('CanOpen', $routeName);
    }

    public static function canAdd(string $routeName): bool
    {
        return self::can('CanAdd', $routeName);
    }

    public static function canEdit(string $routeName): bool
    {
        return self::can('CanEdit', $routeName);
    }

    public static function canDelete(string $routeName): bool
    {
        return self::can('CanDelete', $routeName);
    }

    public static function canPrint(string $routeName): bool
    {
        return self::can('CanPrint', $routeName);
    }

    public static function canExport(string $routeName): bool
    {
        return self::can('CanExport', $routeName);
    }

    public static function canApprove(string $routeName): bool
    {
        return self::can('CanApprove', $routeName);
    }

    public static function menuTree()
    {
        if (! auth()->check()) {
            return collect();
        }

        $roleIds = auth()->user()
            ->roles()
            ->wherePivot('IsActive', true)
            ->pluck('sc_role.RoleID');

        if ($roleIds->isEmpty()) {
            return collect();
        }

        /*
         * Ambil semua menu aktif.
         */
        $menus = ScMenu::query()
            ->where('sc_menu.IsActive', true)
            ->whereNull('sc_menu.DeletedDate')
            ->orderBy('sc_menu.SortOrder')
            ->orderBy('sc_menu.MenuID')
            ->get();

        /*
         * Ambil MenuID yang memiliki permission CanOpen
         * untuk role user saat ini.
         */
        $allowedMenuIds = ScRoleMenu::query()
            ->whereIn('RoleID', $roleIds)
            ->where('IsActive', true)
            ->where('CanOpen', true)
            ->pluck('MenuID')
            ->unique();

        /*
         * Tentukan menu yang boleh ditampilkan.
         *
         * Child:
         *   harus memiliki CanOpen.
         *
         * Parent:
         *   boleh tampil jika:
         *   - dirinya memiliki CanOpen, atau
         *   - memiliki minimal satu child yang boleh tampil.
         */
        $visibleMenus = $menus->filter(function ($menu) use (
            $allowedMenuIds,
            $menus
        ) {

            /*
             * Menu yang memiliki permission langsung.
             */
            if ($allowedMenuIds->contains($menu->MenuID)) {
                return true;
            }

            /*
             * Parent menu tanpa permission langsung,
             * tetapi memiliki child yang boleh diakses.
             */
            return $menus->contains(function ($child) use (
                $menu,
                $allowedMenuIds
            ) {

                return $child->ParentID == $menu->MenuID
                    && $allowedMenuIds->contains(
                        $child->MenuID
                    );

            });

        });

        /*
         * Pastikan parent dari menu yang visible
         * juga ikut tersedia agar hierarchy tidak putus.
         */
        $visibleMenus = $visibleMenus->filter(function ($menu) use (
            $visibleMenus
        ) {

            if (! $menu->ParentID) {
                return true;
            }

            return $visibleMenus->contains(
                'MenuID',
                $menu->ParentID
            );

        });

        return $visibleMenus->groupBy('ParentID');
    }

    public static function childMenus(
        $menus,
        $parentId
    ) {
        return $menus->get(
            $parentId,
            collect()
        );
    }

    public static function isMenuActive(
        ?string $routeName
    ): bool {
        if (! $routeName) {
            return false;
        }

        return request()->routeIs($routeName)
            || request()->routeIs(
                preg_replace(
                    '/\.index$/',
                    '.*',
                    $routeName
                )
            );
    }

    public static function hasActiveMenu(
        $menu,
        $menuTree
    ): bool {
        if (
            $menu->Route
            && self::isMenuActive($menu->Route)
        ) {
            return true;
        }

        $children = $menuTree->get(
            $menu->MenuID,
            collect()
        );

        foreach ($children as $child) {

            if (self::hasActiveMenu($child, $menuTree)) {
                return true;
            }

        }

        return false;
    }
}
