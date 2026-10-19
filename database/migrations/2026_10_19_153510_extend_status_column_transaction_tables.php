<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $tables = [
            'tr_empemail',
            'tr_empequip',
            'tr_empsoft',
            'tr_empitarea',
            'tr_empsharingfolder',
            'tr_empnetwork',
            'tr_empinfra',
            'tr_empapp',
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table) && Schema::hasColumn($table, 'Status')) {
                Schema::table($table, function (Blueprint $tableObj) {
                    $tableObj->string('Status', 50)->change();
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = [
            'tr_empemail',
            'tr_empequip',
            'tr_empsoft',
            'tr_empitarea',
            'tr_empsharingfolder',
            'tr_empnetwork',
            'tr_empinfra',
            'tr_empapp',
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table) && Schema::hasColumn($table, 'Status')) {
                Schema::table($table, function (Blueprint $tableObj) {
                    $tableObj->string('Status', 10)->change();
                });
            }
        }
    }
};
