<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (! Schema::hasTable('sc_role')) return;
        if (Schema::hasColumn('sc_role', 'Name') && Schema::hasColumn('sc_role', 'Role')) {
            DB::table('sc_role')->whereNotNull('Name')->where('Name', '<>', '')->update(['Role' => DB::raw('Name')]);
        }
        if (Schema::hasColumn('sc_role', 'Code')) {
            foreach (Schema::getIndexes('sc_role') as $index) {
                if (in_array('Code', $index['columns'], true)) {
                    Schema::table('sc_role', fn (Blueprint $table) => $index['unique']
                        ? $table->dropUnique($index['name']) : $table->dropIndex($index['name']));
                }
            }
        }
        $legacy = array_values(array_filter(['Code', 'Name'], fn ($column) => Schema::hasColumn('sc_role', $column)));
        if ($legacy) Schema::table('sc_role', fn (Blueprint $table) => $table->dropColumn($legacy));
    }

    public function down(): void
    {
        if (! Schema::hasTable('sc_role')) return;
        Schema::table('sc_role', function (Blueprint $table): void {
            if (! Schema::hasColumn('sc_role', 'Code')) $table->string('Code', 30)->nullable();
            if (! Schema::hasColumn('sc_role', 'Name')) $table->string('Name', 100)->nullable();
        });
        DB::table('sc_role')->update(['Code' => DB::raw('RoleID'), 'Name' => DB::raw('Role')]);
        Schema::table('sc_role', fn (Blueprint $table) => $table->unique('Code', 'sc_role_code_unique'));
    }
};
