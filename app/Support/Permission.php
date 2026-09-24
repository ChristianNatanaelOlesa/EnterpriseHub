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
        $cacheKey = $permission . ':' . $routeName;

        if (array_key_exists($cacheKey, self::$cache)) {
            return self::$cache[$cacheKey];
        }

        if (! auth()->check()) {
            return self::$cache[$cacheKey] = false;
        }

        $roleIds = auth()->user()
            ->roles()
            ->wherePivot('IsActive', true)
            ->where('sc_role.IsActive', true)
            ->whereNull('sc_role.DeletedDate')
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
                    ->where('IsActive', true)
                    ->where('IsMenu', true)
                    ->whereNull('DeletedDate');
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

    /**
     * Build the menu tree visible to the current user.
     *
     * MenuArea:
     * - TOP     = Topside menu
     * - SIDEBAR = User transaction menu
     */
    public static function menuTree(?string $menuArea = null)
    {
        if (! auth()->check()) {
            return collect();
        }

        $roleIds = auth()->user()
            ->roles()
            ->wherePivot('IsActive', true)
            ->where('sc_role.IsActive', true)
            ->whereNull('sc_role.DeletedDate')
            ->pluck('sc_role.RoleID');

        if ($roleIds->isEmpty()) {
            return collect();
        }

        $menusQuery = ScMenu::query()
            ->where('sc_menu.IsActive', true)
            ->where('sc_menu.IsMenu', true)
            ->whereNull('sc_menu.DeletedDate')
            ->orderBy('sc_menu.SortOrder')
            ->orderBy('sc_menu.MenuID');

        if ($menuArea !== null) {
            $menusQuery->where('sc_menu.MenuArea', $menuArea);
        }

        $menus = $menusQuery->get();

        if ($menus->isEmpty()) {
            return collect();
        }

        $allowedMenuIds = ScRoleMenu::query()
            ->whereIn('RoleID', $roleIds)
            ->where('IsActive', true)
            ->where('CanOpen', true)
            ->pluck('MenuID')
            ->unique();

        /*
         * Start from menus explicitly granted CanOpen.
         */
        $visibleIds = collect($allowedMenuIds)
            ->filter(fn ($id) => $menus->contains('MenuID', $id))
            ->values();

        /*
         * Add every ancestor required to keep the hierarchy intact.
         *
         * This is recursive by iteration, so a structure like:
         *
         * System
         *   Master
         *     Organization
         *       Directorate
         *
         * still works when only Directorate has CanOpen.
         */
        do {
            $before = $visibleIds->count();

            $parentIds = $menus
                ->whereIn('MenuID', $visibleIds)
                ->pluck('ParentID')
                ->filter()
                ->unique();

            $visibleIds = $visibleIds
                ->merge($parentIds)
                ->unique()
                ->values();

        } while ($visibleIds->count() > $before);

        $visibleMenus = $menus
            ->filter(fn ($menu) => $visibleIds->contains($menu->MenuID))
            ->values();

        return $visibleMenus->groupBy('ParentID');
    }

    public static function topMenuTree()
    {
        return self::menuTree('TOP');
    }

    public static function sidebarMenuTree()
    {
        return self::menuTree('SIDEBAR');
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
