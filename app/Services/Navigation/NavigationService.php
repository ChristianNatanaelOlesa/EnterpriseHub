<?php

namespace App\Services\Navigation;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class NavigationService
{
    public function getTopMenus(): array
    {
        $table = $this->findMenuTable();

        if (!$table) {
            return ['System' => [], 'Administration' => []];
        }

        $columns = Schema::getColumnListing($table);

        $label = $this->column($columns, [
            'MenuName', 'Name', 'Menu', 'Title', 'MenuTitle'
        ]);

        $group = $this->column($columns, [
            'MenuGroup', 'GroupName', 'Module', 'MenuType', 'Type', 'Category'
        ]);

        $parent = $this->column($columns, [
            'ParentMenuID', 'ParentID', 'ParentMenuId', 'ParentId'
        ]);

        $route = $this->column($columns, [
            'RouteName', 'Route', 'URL', 'Url', 'MenuURL', 'Link'
        ]);

        $icon = $this->column($columns, [
            'Icon', 'IconClass', 'MenuIcon'
        ]);

        $active = $this->column($columns, [
            'IsActive', 'Active', 'Status'
        ]);

        $order = $this->column($columns, [
            'MenuOrder', 'SortOrder', 'OrderNo', 'DisplayOrder', 'Seq'
        ]);

        if (!$label) {
            return ['System' => [], 'Administration' => []];
        }

        $query = DB::table($table);

        if ($active) {
            if (in_array($active, ['IsActive', 'Active'], true)) {
                $query->where($active, true);
            } else {
                $query->where(function ($q) use ($active) {
                    $q->where($active, true)
                        ->orWhere($active, 'ACTIVE')
                        ->orWhere($active, 'Active');
                });
            }
        }

        $query->orderBy($order ?: $label);

        $menus = ['System' => [], 'Administration' => []];

        foreach ($query->get() as $row) {
            $name = trim((string) ($row->{$label} ?? ''));

            if ($name === '') {
                continue;
            }

            $groupName = $group
                ? trim((string) ($row->{$group} ?? ''))
                : '';

            $groupName = $this->normalizeGroup($groupName, $name);

            if (!isset($menus[$groupName])) {
                continue;
            }

            $menus[$groupName][] = [
                'id' => $this->primaryValue($row, $columns),
                'label' => $name,
                'route' => $route ? trim((string) ($row->{$route} ?? '')) : '',
                'icon' => $icon ? trim((string) ($row->{$icon} ?? '')) : 'bi-circle',
                'parent_id' => $parent ? ($row->{$parent} ?? null) : null,
            ];
        }

        return $this->hierarchy($menus);
    }

    private function findMenuTable(): ?string
    {
        foreach (Schema::getTables() as $info) {
            $name = $info['name'] ?? '';

            if (preg_match('/^(sc|security)[_]?menus?$/i', $name)) {
                return $name;
            }
        }

        foreach (Schema::getTables() as $info) {
            $name = $info['name'] ?? '';

            if (preg_match('/menu/i', $name)) {
                return $name;
            }
        }

        return null;
    }

    private function column(array $columns, array $candidates): ?string
    {
        foreach ($candidates as $candidate) {
            foreach ($columns as $column) {
                if (strcasecmp($column, $candidate) === 0) {
                    return $column;
                }
            }
        }

        return null;
    }

    private function primaryValue(object $row, array $columns): mixed
    {
        foreach (['MenuID', 'MenuId', 'ID', 'Id'] as $candidate) {
            $column = $this->column($columns, [$candidate]);

            if ($column) {
                return $row->{$column} ?? null;
            }
        }

        return null;
    }

    private function normalizeGroup(string $group, string $label): string
    {
        $value = Str::lower($group);
        $name = Str::lower($label);

        if (
            Str::contains($value, ['admin', 'security']) ||
            Str::contains($name, ['security', 'role', 'user'])
        ) {
            return 'Administration';
        }

        if (
            Str::contains($value, ['system', 'master']) ||
            Str::contains($name, ['master'])
        ) {
            return 'System';
        }

        return $group === '' ? 'System' : $group;
    }

    private function hierarchy(array $menus): array
    {
        foreach ($menus as $group => $items) {
            $parents = [];
            $children = [];

            foreach ($items as $item) {
                if ($item['parent_id'] === null || $item['parent_id'] === '') {
                    $item['children'] = [];
                    $parents[(string) $item['id']] = $item;
                } else {
                    $children[] = $item;
                }
            }

            foreach ($children as $child) {
                $key = (string) $child['parent_id'];

                if (isset($parents[$key])) {
                    $parents[$key]['children'][] = $child;
                } else {
                    $child['children'] = [];
                    $parents[] = $child;
                }
            }

            $menus[$group] = array_values($parents);
        }

        return $menus;
    }
}
