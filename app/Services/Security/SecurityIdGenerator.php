<?php

namespace App\Services\Security;

use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SecurityIdGenerator
{
    public static function nextRoleId(): string
    {
        return DB::transaction(function (): string {
            $counter = self::lockCounter('role', 'GLOBAL', self::lastRoleSequence());

            for ($sequence = $counter + 1; $sequence <= 999; $sequence++) {
                self::setCounter('role', 'GLOBAL', $sequence);
                $candidate = sprintf('RL%03d', $sequence);
                if (! DB::table('sc_role')->where('RoleID', $candidate)->exists()) {
                    return $candidate;
                }
            }

            throw ValidationException::withMessages([
                'Code' => 'Kapasitas ID role RL001 sampai RL999 sudah penuh.',
            ]);
        });
    }

    public static function nextMenuId(?string $parentId): string
    {
        return DB::transaction(function () use ($parentId): string {
            $parts = $parentId === null ? [0, 0, 0] : array_map('intval', explode('-', $parentId));
            $level = $parentId === null ? 0 : count(array_filter($parts, fn ($part) => $part !== 0));
            if ($level >= 3) {
                throw ValidationException::withMessages(['ParentID' => 'Hierarki menu maksimal tiga level.']);
            }

            $scope = $parentId ?? 'ROOT';
            $lastSequence = self::lastMenuSequence($parentId, $level);
            $counter = self::lockCounter('menu', $scope, $lastSequence);

            for ($sequence = $counter + 1; $sequence <= 99; $sequence++) {
                $candidateParts = $parts;
                $candidateParts[$level] = $sequence;
                for ($index = $level + 1; $index < 3; $index++) {
                    $candidateParts[$index] = 0;
                }
                $candidate = implode('-', array_map(fn ($part) => sprintf('%02d', $part), $candidateParts));
                self::setCounter('menu', $scope, $sequence);

                if (! DB::table('sc_menu')->where('MenuID', $candidate)->exists()) {
                    return $candidate;
                }
            }

            throw ValidationException::withMessages([
                'ParentID' => 'Parent menu sudah mencapai batas 99 menu anak.',
            ]);
        });
    }

    private static function lockCounter(string $entity, string $scope, int $initialValue): int
    {
        DB::table('sc_security_id_sequence')->insertOrIgnore([
            'Entity' => $entity,
            'Scope' => $scope,
            'NextValue' => $initialValue,
        ]);

        $row = DB::table('sc_security_id_sequence')
            ->where('Entity', $entity)
            ->where('Scope', $scope)
            ->lockForUpdate()
            ->first();

        if ((int) $row->NextValue < $initialValue) {
            self::setCounter($entity, $scope, $initialValue);
            return $initialValue;
        }

        return (int) $row->NextValue;
    }

    private static function setCounter(string $entity, string $scope, int $value): void
    {
        DB::table('sc_security_id_sequence')
            ->where('Entity', $entity)
            ->where('Scope', $scope)
            ->update(['NextValue' => $value]);
    }

    private static function lastRoleSequence(): int
    {
        return DB::table('sc_role')->pluck('RoleID')->map(function ($id): int {
            return preg_match('/^RL(\d{3})$/', (string) $id, $matches) ? (int) $matches[1] : 0;
        })->max() ?? 0;
    }

    private static function lastMenuSequence(?string $parentId, int $level): int
    {
        if ($level === 0) {
            return DB::table('sc_menu')->whereNull('ParentID')->pluck('MenuID')
                ->map(fn ($id) => (int) substr((string) $id, 0, 2))->max() ?? 0;
        }

        return DB::table('sc_menu')->where('ParentID', $parentId)->pluck('MenuID')
            ->map(fn ($id) => (int) explode('-', (string) $id)[$level])->max() ?? 0;
    }
}
