<?php

namespace App\Support;

use App\Models\Security\ScMenu;
use App\Models\Security\ScUserRole;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class Permission
{
    public static function can(string $permission, string $routeName): bool
    {
        $user = auth()->user();
        if (! $user || ! $user->IsActive || $user->DeletedDate || trim($routeName) === '' || trim($permission) === '') {
            return false;
        }

        try {
            return DB::table('sc_role_permission as rp')
                ->join('sc_menu_permission as mp', 'mp.MenuPermissionID', '=', 'rp.MenuPermissionID')
                ->join('sc_permission as p', 'p.PermissionID', '=', 'mp.PermissionID')
                ->join('sc_menu as m', 'm.MenuID', '=', 'mp.MenuID')
                ->join('sc_user_role as ur', 'ur.RoleID', '=', 'rp.RoleID')
                ->join('sc_role as r', 'r.RoleID', '=', 'ur.RoleID')
                ->where('ur.UserID', $user->UserID)
                ->where('ur.IsActive', true)->whereNull('ur.DeletedDate')
                ->where('r.IsActive', true)->whereNull('r.DeletedDate')
                ->where('rp.IsActive', true)->whereNull('rp.DeletedDate')
                ->where('mp.IsActive', true)->whereNull('mp.DeletedDate')
                ->where('p.Name', trim($permission))->where('p.IsActive', true)->whereNull('p.DeletedDate')
                ->where('m.Route', trim($routeName))->where('m.IsActive', true)->where('m.IsMenu', true)->whereNull('m.DeletedDate')
                ->exists();
        } catch (QueryException) {
            return false;
        }
    }

    public static function canOpen(string $routeName): bool { return self::can('View', $routeName); }
    public static function canAdd(string $routeName): bool { return self::can('Create', $routeName); }
    public static function canEdit(string $routeName): bool { return self::can('Update', $routeName); }
    public static function canDelete(string $routeName): bool { return self::can('Delete', $routeName); }
    public static function canApprove(string $routeName): bool { return self::can('Approve', $routeName); }
    public static function canPrint(string $routeName): bool { return self::can('Print', $routeName); }
    public static function canExport(string $routeName): bool { return self::can('Export', $routeName); }

    /** Return menus granted View plus any category ancestors needed to display them. */
    public static function menuTree(?string $menuArea = null): Collection
    {
        $user = auth()->user();
        if (! $user || ! $user->IsActive || $user->DeletedDate) {
            return collect();
        }

        $menusQuery = ScMenu::query()->where('IsActive', true)->where('IsMenu', true)->whereNull('DeletedDate')
            ->orderBy('SortOrder')->orderBy('MenuID');
        if ($menuArea !== null) {
            $menusQuery->where('MenuArea', $menuArea);
        }
        $menus = $menusQuery->get();

        try {
            $visibleIds = DB::table('sc_role_permission as rp')
                ->join('sc_menu_permission as mp', 'mp.MenuPermissionID', '=', 'rp.MenuPermissionID')
                ->join('sc_permission as p', 'p.PermissionID', '=', 'mp.PermissionID')
                ->join('sc_user_role as ur', 'ur.RoleID', '=', 'rp.RoleID')
                ->join('sc_role as r', 'r.RoleID', '=', 'ur.RoleID')
                ->where('ur.UserID', $user->UserID)->where('ur.IsActive', true)->whereNull('ur.DeletedDate')
                ->where('r.IsActive', true)->whereNull('r.DeletedDate')
                ->where('rp.IsActive', true)->whereNull('rp.DeletedDate')
                ->where('mp.IsActive', true)->whereNull('mp.DeletedDate')
                ->where('p.Name', 'View')->where('p.IsActive', true)->whereNull('p.DeletedDate')
                ->pluck('mp.MenuID')->unique()->values();
        } catch (QueryException) {
            return collect();
        }

        $pending = $menus->whereIn('MenuID', $visibleIds)->pluck('ParentID')->filter()->unique();
        while ($pending->isNotEmpty()) {
            $ancestors = $menus->whereIn('MenuID', $pending);
            $visibleIds = $visibleIds->merge($ancestors->pluck('MenuID'))->unique()->values();
            $pending = $ancestors->pluck('ParentID')->filter()->unique();
        }

        return $menus->filter(fn ($menu) => $visibleIds->contains($menu->MenuID))->values()->groupBy('ParentID');
    }

    public static function topMenuTree(): Collection { return self::menuTree('TOP'); }
    public static function sidebarMenuTree(): Collection { return self::menuTree('SIDEBAR'); }
    public static function childMenus(Collection $menus, mixed $parentId): Collection { return $menus->get($parentId, collect()); }

    public static function isMenuActive(?string $routeName): bool
    {
        return $routeName !== null && (request()->routeIs($routeName) || request()->routeIs(preg_replace('/\.index$/', '.*', $routeName)));
    }

    public static function hasActiveMenu($menu, Collection $menuTree): bool
    {
        if ($menu->Route && self::isMenuActive($menu->Route)) return true;
        foreach (self::childMenus($menuTree, $menu->MenuID) as $child) {
            if (self::hasActiveMenu($child, $menuTree)) return true;
        }
        return false;
    }
}
