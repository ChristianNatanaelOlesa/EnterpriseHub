<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        $this->normalizeRoleAndMenuColumns();
        $this->normalizeCocReferences();
        if (! Schema::hasTable('sc_permission')) {
            Schema::create('sc_permission', function (Blueprint $table): void {
                $table->bigIncrements('PermissionID');
                $table->string('Code', 50)->unique();
                $table->string('Name', 100);
                $table->boolean('IsActive')->default(true);
                $table->auditColumns();
            });
        }

        if (! Schema::hasTable('sc_menu_permission')) {
            Schema::create('sc_menu_permission', function (Blueprint $table): void {
                $table->bigIncrements('MenuPermissionID');
                $table->string('MenuID', 8);
                $table->unsignedBigInteger('PermissionID');
                $table->boolean('IsActive')->default(true);
                $table->auditColumns();
                $table->unique(['MenuID', 'PermissionID'], 'sc_menu_permission_menu_permission_unique');
                $table->foreign('MenuID')->references('MenuID')->on('sc_menu')->restrictOnDelete();
                $table->foreign('PermissionID')->references('PermissionID')->on('sc_permission')->restrictOnDelete();
            });
        }

        if (! Schema::hasTable('sc_role_permission')) {
            Schema::create('sc_role_permission', function (Blueprint $table): void {
                $table->bigIncrements('RolePermissionID');
                $table->string('RoleID', 5);
                $table->unsignedBigInteger('MenuPermissionID');
                $table->boolean('IsActive')->default(true);
                $table->auditColumns();
                $table->unique(['RoleID', 'MenuPermissionID'], 'sc_role_permission_role_menu_permission_unique');
                $table->foreign('RoleID')->references('RoleID')->on('sc_role')->restrictOnDelete();
                $table->foreign('MenuPermissionID')->references('MenuPermissionID')->on('sc_menu_permission')->restrictOnDelete();
            });
        } elseif (! Schema::hasColumn('sc_role_permission', 'MenuPermissionID')) {
            Schema::table('sc_role_permission', function (Blueprint $table): void {
                $table->unsignedBigInteger('MenuPermissionID')->nullable()->after('RoleID');
                $table->index('MenuPermissionID', 'sc_role_permission_menu_permission_index');
                $table->foreign('MenuPermissionID', 'sc_role_permission_menu_permission_fk')
                    ->references('MenuPermissionID')->on('sc_menu_permission')->restrictOnDelete();
            });
        }

        if (Schema::hasTable('sc_role_permission') && Schema::hasColumn('sc_role_permission', 'MenuPermissionID')) {
            $indexes = collect(Schema::getIndexes('sc_role_permission'));
            if (! $indexes->contains(fn ($index) => $index['columns'] === ['RoleID', 'MenuPermissionID'] && $index['unique'])) {
                Schema::table('sc_role_permission', fn (Blueprint $table) => $table->unique(
                    ['RoleID', 'MenuPermissionID'], 'sc_role_permission_role_menu_permission_unique'
                ));
            }
            if (! $this->hasForeignKey('sc_role_permission', 'MenuPermissionID')) {
                Schema::table('sc_role_permission', fn (Blueprint $table) => $table->foreign(
                    'MenuPermissionID', 'sc_role_permission_menu_permission_fk'
                )->references('MenuPermissionID')->on('sc_menu_permission')->restrictOnDelete());
            }
        }

        if (! Schema::hasTable('sc_security_id_sequence')) {
            Schema::create('sc_security_id_sequence', function (Blueprint $table): void {
                $table->string('Entity', 10);
                $table->string('Scope', 16);
                $table->unsignedSmallInteger('NextValue')->default(0);
                $table->primary(['Entity', 'Scope']);
            });
        } elseif (Schema::hasColumn('sc_security_id_sequence', 'NextValue')) {
            $column = collect(Schema::getColumns('sc_security_id_sequence'))->firstWhere('name', 'NextValue');
            if ($column && str_contains(strtolower($column['type']), 'tinyint')) {
                Schema::table('sc_security_id_sequence', fn (Blueprint $table) => $table->unsignedSmallInteger('NextValue')->default(0)->change());
            }
        }

        if (Schema::hasTable('sc_user_role')) {
            $duplicate = DB::table('sc_user_role')->select('UserID', 'RoleID')->groupBy('UserID', 'RoleID')->havingRaw('COUNT(*) > 1')->first();
            if ($duplicate) {
                throw new RuntimeException('Duplicate sc_user_role assignments exist; resolve them before adding the required unique UserID/RoleID constraint.');
            }
            if (! collect(Schema::getIndexes('sc_user_role'))->contains(fn ($index) => $index['columns'] === ['UserID', 'RoleID'] && $index['unique'])) {
                Schema::table('sc_user_role', fn (Blueprint $table) => $table->unique(['UserID', 'RoleID'], 'sc_user_role_user_role_unique'));
            }
        }

        if (Schema::hasTable('sc_user') && Schema::hasTable('tr_empform')
            && Schema::hasColumn('sc_user', 'EmpFormID') && Schema::hasColumn('tr_empform', 'EmpFormID')
            && ! $this->hasForeignKey('sc_user', 'EmpFormID')) {
            Schema::table('sc_user', function (Blueprint $table): void {
                $table->foreign('EmpFormID', 'sc_user_empformid_foreign')
                    ->references('EmpFormID')->on('tr_empform')->restrictOnDelete();
            });
        }

        // Preserve old assignments in the existing table and translate only explicit
        // action grants. Navigation-only legacy grants never imply a backend View grant.
        $this->migrateLegacyMenuPermissions();
        $this->migrateLegacyActionGrants();
        $this->preserveDuplicateLegacyGrantRows();

        // Retain the old navigation relation for rollback and data review, but remove its
        // legacy runtime name from the final authorization model.
        if (Schema::hasTable('sc_role_menu') && ! Schema::hasTable('sc_role_menu_legacy')) {
            Schema::rename('sc_role_menu', 'sc_role_menu_legacy');
        }
    }

    private function normalizeRoleAndMenuColumns(): void
    {
        if (Schema::hasTable('sc_role')) {
            Schema::table('sc_role', function (Blueprint $table): void {
                if (! Schema::hasColumn('sc_role', 'Code')) $table->string('Code', 30)->nullable();
                if (! Schema::hasColumn('sc_role', 'Name')) $table->string('Name', 100)->nullable();
            });
            if (Schema::hasColumn('sc_role', 'Role')) {
                DB::table('sc_role')->whereNull('Code')->update(['Code' => DB::raw('RoleID')]);
                DB::table('sc_role')->whereNull('Name')->update(['Name' => DB::raw('Role')]);
            } else {
                DB::table('sc_role')->whereNull('Code')->update(['Code' => DB::raw('RoleID')]);
                DB::table('sc_role')->whereNull('Name')->update(['Name' => DB::raw('RoleID')]);
            }
            foreach (['Code' => 'string', 'Name' => 'string'] as $column => $type) {
                $metadata = collect(Schema::getColumns('sc_role'))->firstWhere('name', $column);
                if ($metadata && $metadata['nullable']) {
                    Schema::table('sc_role', fn (Blueprint $table) => $table->{$type}($column, $column === 'Code' ? 30 : 100)->nullable(false)->change());
                }
            }
            if (Schema::hasColumn('sc_role', 'Description')) {
                $description = collect(Schema::getColumns('sc_role'))->firstWhere('name', 'Description');
                if ($description && ! $description['nullable']) {
                    Schema::table('sc_role', fn (Blueprint $table) => $table->text('Description')->nullable()->change());
                }
            }
            if (! collect(Schema::getIndexes('sc_role'))->contains(fn ($index) => $index['columns'] === ['Code'] && $index['unique'])) {
                Schema::table('sc_role', fn (Blueprint $table) => $table->unique('Code', 'sc_role_code_unique'));
            }
        }

        if (Schema::hasTable('sc_menu')) {
            Schema::table('sc_menu', function (Blueprint $table): void {
                if (! Schema::hasColumn('sc_menu', 'Code')) $table->string('Code', 30)->nullable();
                if (! Schema::hasColumn('sc_menu', 'Name')) $table->string('Name', 100)->nullable();
            });
            if (Schema::hasColumn('sc_menu', 'Menu')) {
                DB::table('sc_menu')->whereNull('Name')->update(['Name' => DB::raw('Menu')]);
            } else {
                DB::table('sc_menu')->whereNull('Name')->update(['Name' => DB::raw('MenuID')]);
            }
            DB::table('sc_menu')->whereNull('Code')->update(['Code' => DB::raw('MenuID')]);
            $area = collect(Schema::getColumns('sc_menu'))->firstWhere('name', 'MenuArea');
            if ($area && preg_match('/varchar\((\d+)\)/i', $area['type'], $matches) && (int) $matches[1] < 7) {
                Schema::table('sc_menu', fn (Blueprint $table) => $table->string('MenuArea', 20)->default('TOP')->change());
            }
            foreach (['Code' => 30, 'Name' => 100] as $column => $length) {
                $metadata = collect(Schema::getColumns('sc_menu'))->firstWhere('name', $column);
                if ($metadata && $metadata['nullable']) {
                    Schema::table('sc_menu', fn (Blueprint $table) => $table->string($column, $length)->nullable(false)->change());
                }
            }
            if (! Schema::hasColumn('sc_menu', 'URL')) {
                Schema::table('sc_menu', fn (Blueprint $table) => $table->string('URL', 255)->nullable());
            }
            if (! collect(Schema::getIndexes('sc_menu'))->contains(fn ($index) => $index['columns'] === ['Code'] && $index['unique'])) {
                Schema::table('sc_menu', fn (Blueprint $table) => $table->unique('Code', 'sc_menu_code_unique'));
            }
        }
    }

    private function normalizeCocReferences(): void
    {
        $references = [
            'tr_empnetwork' => ['InternetCocID', 'WLANCocID', 'VPNCocID'],
            'tr_empitarea' => ['CocID'], 'tr_empemail' => ['CocID'], 'tr_empapp' => ['CocID'],
            'tr_empinfra' => ['CocID'], 'tr_empnetdrive' => ['CocID'], 'tr_empsoft' => ['CocID'],
            'tr_empequip' => ['CocID'],
        ];
        foreach ($references as $table => $columns) {
            if (! Schema::hasTable($table)) continue;
            foreach ($columns as $column) {
                if ($table === 'tr_empnetdrive' && ! Schema::hasColumn($table, $column)) {
                    Schema::table($table, fn (Blueprint $blueprint) => $blueprint->string($column, 6)->nullable());
                }
                if (! Schema::hasColumn($table, $column)) continue;

                foreach (Schema::getForeignKeys($table) as $foreignKey) {
                    if (in_array($column, $foreignKey['columns'], true)) {
                        Schema::table($table, fn (Blueprint $blueprint) => $blueprint->dropForeign($foreignKey['name']));
                    }
                }

                $metadata = collect(Schema::getColumns($table))->firstWhere('name', $column);
                if ($metadata && ! preg_match('/varchar\(6\)/i', $metadata['type'])) {
                    $valuesExceedingLimit = DB::table($table)->whereNotNull($column)
                        ->whereRaw('CHAR_LENGTH(`'.$column.'`) > 6')->exists();
                    if ($valuesExceedingLimit) {
                        throw new RuntimeException("Cannot constrain {$table}.{$column}: existing values exceed Ms_Coc.CocID length 6.");
                    }
                    Schema::table($table, function (Blueprint $blueprint) use ($column, $metadata): void {
                        $definition = $blueprint->string($column, 6)->nullable((bool) $metadata['nullable']);
                        if ($metadata['default'] !== null) $definition->default($metadata['default']);
                    });
                }

                if (Schema::hasTable('ms_coc') && ! $this->hasForeignKey($table, $column)) {
                    $invalidValue = DB::table($table.' as source')->leftJoin('ms_coc as target', 'target.CocID', '=', 'source.'.$column)
                        ->whereNotNull('source.'.$column)->whereNull('target.CocID')->exists();
                    if ($invalidValue) {
                        throw new RuntimeException("Cannot add {$table}.{$column} foreign key: existing CocID values are missing from Ms_Coc.");
                    }
                    Schema::table($table, fn (Blueprint $blueprint) => $blueprint->foreign($column)
                        ->references('CocID')->on('ms_coc')->restrictOnDelete()->cascadeOnUpdate());
                }
            }
        }
    }

    private function hasForeignKey(string $table, string $column): bool
    {
        foreach (Schema::getForeignKeys($table) as $foreignKey) {
            if (in_array($column, $foreignKey['columns'], true)) return true;
        }
        return false;
    }

    private function migrateLegacyActionGrants(): void
    {
        foreach (['sc_role_permission', 'sc_page_permission', 'sc_menu_page', 'sc_page'] as $table) {
            if (! Schema::hasTable($table)) return;
        }
        if (! Schema::hasColumn('sc_role_permission', 'PagePermissionID')) return;

        DB::table('sc_role_permission as rp')
            ->join('sc_page_permission as pp', 'pp.PagePermissionID', '=', 'rp.PagePermissionID')
            ->join('sc_menu_page as ml', 'ml.WebPageID', '=', 'pp.WebPageID')
            ->join('sc_menu_permission as mp', function ($join): void {
                $join->on('mp.MenuID', '=', 'ml.MenuID')->on('mp.PermissionID', '=', 'pp.PermissionID');
            })
            ->whereNotNull('rp.PagePermissionID')
            ->where('rp.IsActive', true)->whereNull('rp.DeletedDate')
            ->where('pp.IsActive', true)->whereNull('pp.DeletedDate')
            ->whereNull('ml.DeletedDate')
            ->whereNull('rp.MenuPermissionID')
            ->select(['rp.RolePermissionID', 'mp.MenuPermissionID'])
            ->orderBy('rp.RolePermissionID')->get()
            ->each(fn ($grant) => DB::table('sc_role_permission')->where('RolePermissionID', $grant->RolePermissionID)
                ->update(['MenuPermissionID' => $grant->MenuPermissionID]));
    }

    private function migrateLegacyMenuPermissions(): void
    {
        foreach (['sc_page_permission', 'sc_menu_page', 'sc_page'] as $table) {
            if (! Schema::hasTable($table)) return;
        }

        $links = DB::table('sc_menu_page as ml')
            ->join('sc_page_permission as pp', 'pp.WebPageID', '=', 'ml.WebPageID')
            ->where('pp.IsActive', true)->whereNull('pp.DeletedDate')
            ->whereNull('ml.DeletedDate')
            ->select(['ml.MenuID', 'pp.PermissionID'])->distinct()->get();
        foreach ($links as $link) {
            DB::table('sc_menu_permission')->insertOrIgnore([
                'MenuID' => $link->MenuID, 'PermissionID' => $link->PermissionID, 'IsActive' => true,
                'InputUser' => 'Security migration', 'InputDate' => now(),
                'ModifUser' => 'Security migration', 'ModifDate' => now(),
            ]);
        }
    }

    private function preserveDuplicateLegacyGrantRows(): void
    {
        if (! Schema::hasTable('sc_role_permission') || ! Schema::hasColumn('sc_role_permission', 'MenuPermissionID')) return;
        DB::table('sc_role_permission')->whereNotNull('MenuPermissionID')->orderBy('RolePermissionID')->get()
            ->groupBy(fn ($row) => $row->RoleID.'|'.$row->MenuPermissionID)
            ->each(function ($grants): void {
                if ($grants->count() < 2) return;
                foreach ($grants->slice(1) as $duplicate) {
                    // Keep the legacy PagePermissionID and audit fields for recovery;
                    // null only the new link so the new unique constraint is valid.
                    DB::table('sc_role_permission')->where('RolePermissionID', $duplicate->RolePermissionID)
                        ->update(['MenuPermissionID' => null]);
                }
            });
    }

    public function down(): void
    {
        $legacyRolePermissions = Schema::hasTable('sc_role_permission') && Schema::hasColumn('sc_role_permission', 'PagePermissionID');
        if (Schema::hasTable('sc_role_menu_legacy') && ! Schema::hasTable('sc_role_menu')) {
            Schema::rename('sc_role_menu_legacy', 'sc_role_menu');
        }

        // A legacy table keeps its old PagePermissionID column and rows. A fresh-install
        // schema has no PagePermissionID, so only that new table is removed on rollback.
        if (Schema::hasTable('sc_role_permission') && Schema::hasColumn('sc_role_permission', 'PagePermissionID')
            && Schema::hasColumn('sc_role_permission', 'MenuPermissionID')) {
            Schema::table('sc_role_permission', function (Blueprint $table): void {
                if (collect(Schema::getForeignKeys('sc_role_permission'))->contains(fn ($fk) => $fk['name'] === 'sc_role_permission_menu_permission_fk')) {
                    $table->dropForeign('sc_role_permission_menu_permission_fk');
                }
                if (collect(Schema::getIndexes('sc_role_permission'))->contains(fn ($index) => $index['name'] === 'sc_role_permission_menu_permission_index')) {
                    $table->dropIndex('sc_role_permission_menu_permission_index');
                }
                if (collect(Schema::getIndexes('sc_role_permission'))->contains(fn ($index) => $index['name'] === 'sc_role_permission_role_menu_permission_unique')) {
                    $table->dropUnique('sc_role_permission_role_menu_permission_unique');
                }
                $table->dropColumn('MenuPermissionID');
            });
        }

        if (Schema::hasTable('sc_user_role') && collect(Schema::getIndexes('sc_user_role'))->contains(fn ($index) => $index['name'] === 'sc_user_role_user_role_unique')) {
            Schema::table('sc_user_role', fn (Blueprint $table) => $table->dropUnique('sc_user_role_user_role_unique'));
        }
        if (Schema::hasTable('sc_user')) {
            foreach (Schema::getForeignKeys('sc_user') as $foreignKey) {
                if (in_array('EmpFormID', $foreignKey['columns'], true) && $foreignKey['name'] === 'sc_user_empformid_foreign') {
                    Schema::table('sc_user', fn (Blueprint $table) => $table->dropForeign($foreignKey['name']));
                }
            }
        }
        foreach (['tr_empnetwork' => ['InternetCocID', 'WLANCocID', 'VPNCocID'], 'tr_empitarea' => ['CocID'],
            'tr_empemail' => ['CocID'], 'tr_empapp' => ['CocID'], 'tr_empinfra' => ['CocID'],
            'tr_empnetdrive' => ['CocID'], 'tr_empsoft' => ['CocID'], 'tr_empequip' => ['CocID']] as $table => $columns) {
            if (! Schema::hasTable($table)) continue;
            foreach (Schema::getForeignKeys($table) as $foreignKey) {
                if (array_intersect($columns, $foreignKey['columns']) !== []) {
                    Schema::table($table, fn (Blueprint $blueprint) => $blueprint->dropForeign($foreignKey['name']));
                }
            }
        }

        if (! $legacyRolePermissions) {
            Schema::dropIfExists('sc_role_permission');
            Schema::dropIfExists('sc_menu_permission');
            if (! Schema::hasTable('sc_page_permission')) Schema::dropIfExists('sc_permission');
        }
    }
};
