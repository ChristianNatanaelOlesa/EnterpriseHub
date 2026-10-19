<?php

namespace App\Http\Requests\Security;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UpdateRoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $roleId = $this->route('role');

        if (is_object($roleId)) {
            $roleId = $roleId->RoleID;
        }

        return [

            'Role' => [
                'required',
                'string',
                'max:100',
            ],

            'Description' => [
                'required',
                'string',
                'max:255',
            ],

            'IsActive' => [
                'required',
                'boolean',
            ],

            'menu_permissions' => [
                'nullable',
                'array',
            ],

            'menu_permissions.*' => [
                'integer',
                'distinct',
                'exists:sc_menu_permission,MenuPermissionID',
            ],

        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator): void {
            $ids = array_values(array_unique(array_map('intval', (array) $this->input('menu_permissions', []))));
            if ($ids === []) {
                return;
            }

            $validCount = DB::table('sc_menu_permission as mp')
                ->join('sc_menu as m', 'm.MenuID', '=', 'mp.MenuID')
                ->join('sc_permission as p', 'p.PermissionID', '=', 'mp.PermissionID')
                ->whereIn('mp.MenuPermissionID', $ids)
                ->where('mp.IsActive', true)->whereNull('mp.DeletedDate')
                ->where('m.IsActive', true)->where('m.IsMenu', true)->whereNull('m.DeletedDate')
                ->whereNotNull('m.Route')->where('m.Route', '<>', '')
                ->where('p.IsActive', true)->whereNull('p.DeletedDate')
                ->distinct()->count('mp.MenuPermissionID');

            if ($validCount !== count($ids)) {
                $validator->errors()->add('menu_permissions', 'Pilih hanya permission aktif yang tersedia untuk menu terkait.');
            }
        });
    }
}
