<?php

namespace App\Repositories\Security;

use App\Models\Security\ScRole;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

class RoleRepository extends BaseRepository
{
    public function __construct(ScRole $model) { $this->model = $model; }

    public function getPaginated(int $perPage = 10, ?string $search = null)
    {
        return $this->model->whereNull('DeletedDate')->when($search, fn ($q) => $q->where(fn ($q) => $q
            ->where('RoleID', 'like', "%{$search}%")->orWhere('Role', 'like', "%{$search}%")
            ->orWhere('Description', 'like', "%{$search}%")))->orderBy('RoleID')->paginate($perPage)->withQueryString();
    }

    public function getActiveRoles()
    {
        return $this->model->where('IsActive', true)->whereNull('DeletedDate')->orderBy('RoleID')->get();
    }

    public function findById(string $id) { return $this->find($id); }

    public function getMenus()
    {
        return DB::table('sc_menu')->where('IsActive', true)->where('IsMenu', true)->whereNull('DeletedDate')
            ->orderByRaw("CASE WHEN MenuArea = 'TOP' THEN 1 ELSE 2 END")->orderBy('SortOrder')->orderBy('MenuID')->get();
    }

    public function getRolePermissions(string $roleId)
    {
        return DB::table('sc_role_permission')->where('RoleID', $roleId)->where('IsActive', true)->whereNull('DeletedDate')
            ->pluck('MenuPermissionID')->mapWithKeys(fn ($id) => [$id => true]);
    }

    /** Available action grants for active menus and permissions. */
    public function getMenuPermissions()
    {
        return DB::table('sc_menu_permission as mp')->join('sc_menu as m', 'm.MenuID', '=', 'mp.MenuID')
            ->join('sc_permission as p', 'p.PermissionID', '=', 'mp.PermissionID')
            ->where('mp.IsActive', true)->whereNull('mp.DeletedDate')
            ->where('m.IsActive', true)->where('m.IsMenu', true)->whereNull('m.DeletedDate')
            ->whereNotNull('m.Route')->where('m.Route', '<>', '')
            ->where('p.IsActive', true)->whereNull('p.DeletedDate')
            ->orderBy('m.MenuArea')->orderBy('m.SortOrder')->orderBy('m.MenuID')->orderBy('p.Name')
            ->get(['mp.MenuPermissionID', 'mp.MenuID', 'p.Name as PermissionCode', 'p.Name as PermissionName', 'm.MenuID as MenuCode', 'm.Menu as MenuName', 'm.Route']);
    }

    public function syncRolePermissions(string $roleId, array $menuPermissionIds, string $username): void
    {
        $now = now();
        $allowedIds = DB::table('sc_menu_permission as mp')->join('sc_menu as m', 'm.MenuID', '=', 'mp.MenuID')
            ->join('sc_permission as p', 'p.PermissionID', '=', 'mp.PermissionID')
            ->whereIn('mp.MenuPermissionID', array_map('intval', $menuPermissionIds))
            ->where('mp.IsActive', true)->whereNull('mp.DeletedDate')
            ->where('m.IsActive', true)->where('m.IsMenu', true)->whereNull('m.DeletedDate')
            ->whereNotNull('m.Route')->where('m.Route', '<>', '')
            ->where('p.IsActive', true)->whereNull('p.DeletedDate')->pluck('mp.MenuPermissionID')->map(fn ($id) => (int) $id)->all();

        $existing = DB::table('sc_role_permission')->where('RoleID', $roleId)->whereNotNull('MenuPermissionID')->get()->keyBy('MenuPermissionID');
        foreach ($existing as $id => $grant) {
            $active = in_array((int) $id, $allowedIds, true);
            DB::table('sc_role_permission')->where('RolePermissionID', $grant->RolePermissionID)->update([
                'IsActive' => $active, 'ModifUser' => $username, 'ModifDate' => $now,
                'DeletedBy' => $active ? null : $username, 'DeletedDate' => $active ? null : $now,
            ]);
        }
        foreach ($allowedIds as $id) {
            if ($existing->has($id)) continue;
            DB::table('sc_role_permission')->insert([
                'RoleID' => $roleId, 'MenuPermissionID' => $id, 'IsActive' => true,
                'InputUser' => $username, 'InputDate' => $now, 'ModifUser' => $username, 'ModifDate' => $now,
            ]);
        }
    }
}
