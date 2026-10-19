<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (! Schema::hasTable('sc_menu')) return;
        if (Schema::hasColumn('sc_menu', 'Name') && Schema::hasColumn('sc_menu', 'Menu')) {
            DB::table('sc_menu')->whereNotNull('Name')->where('Name', '<>', '')->update(['Menu' => DB::raw('Name')]);
        }
        if (Schema::hasColumn('sc_menu', 'URL') && Schema::hasColumn('sc_menu', 'Route')) {
            DB::table('sc_menu')->whereNotNull('URL')->where('URL', '<>', '')
                ->where(fn ($q) => $q->whereNull('Route')->orWhere('Route', ''))->update(['Route' => DB::raw('URL')]);
        }
        if (Schema::hasColumn('sc_menu', 'Code')) {
            foreach (Schema::getIndexes('sc_menu') as $index) {
                if (in_array('Code', $index['columns'], true)) {
                    Schema::table('sc_menu', fn (Blueprint $table) => $index['unique']
                        ? $table->dropUnique($index['name']) : $table->dropIndex($index['name']));
                }
            }
        }
        $legacy = array_values(array_filter(['Variable','Code','Name','URL'], fn ($c) => Schema::hasColumn('sc_menu', $c)));
        if ($legacy) Schema::table('sc_menu', fn (Blueprint $table) => $table->dropColumn($legacy));
    }

    public function down(): void
    {
        if (! Schema::hasTable('sc_menu')) return;
        Schema::table('sc_menu', function (Blueprint $table): void {
            if (! Schema::hasColumn('sc_menu', 'Code')) $table->string('Code', 30)->nullable();
            if (! Schema::hasColumn('sc_menu', 'Name')) $table->string('Name', 100)->nullable();
            if (! Schema::hasColumn('sc_menu', 'URL')) $table->string('URL', 255)->nullable();
        });
        DB::table('sc_menu')->update(['Code' => DB::raw('MenuID'), 'Name' => DB::raw('Menu')]);
        Schema::table('sc_menu', fn (Blueprint $table) => $table->unique('Code', 'sc_menu_code_unique'));
    }
};
