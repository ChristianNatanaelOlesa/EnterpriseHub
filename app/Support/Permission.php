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

        $menus = ScMenu::query()
            ->where('sc_menu.IsActive', true)
            ->whereNull('sc_menu.DeletedDate')
            ->where(function ($query) use ($roleIds) {

                $query
                    ->whereNull('sc_menu.Route')
                    ->orWhereExists(function ($subQuery) use ($roleIds) {

                        $subQuery
                            ->selectRaw('1')
                            ->from('sc_role_menu')
                            ->whereColumn(
                                'sc_role_menu.MenuID',
                                'sc_menu.MenuID'
                            )
                            ->whereIn(
                                'sc_role_menu.RoleID',
                                $roleIds
                            )
                            ->where(
                                'sc_role_menu.IsActive',
                                true
                            )
                            ->where(
                                'sc_role_menu.CanOpen',
                                true
                            );

                    });

            })
            ->orderBy('sc_menu.SortOrder')
            ->orderBy('sc_menu.MenuID')
            ->get();

        return $menus
            ->filter(function ($menu) use ($menus) {

                if (! $menu->ParentID) {
                    return true;
                }

                return $menus->contains(
                    'MenuID',
                    $menu->ParentID
                );

            })
            ->groupBy('ParentID');
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
