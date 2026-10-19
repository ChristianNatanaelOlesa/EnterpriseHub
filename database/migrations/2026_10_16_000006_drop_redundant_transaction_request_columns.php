<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        $tables = [
            'tr_empapp', 'tr_empemail', 'tr_empequip', 'tr_empinfra',
            'tr_empitarea', 'tr_empnetwork', 'tr_empsharingfolder', 'tr_empsoft',
            'tr_empsoftware', 'tr_empnetdrive',
            'tr_empformhist',
        ];

        foreach ($tables as $tableName) {
            if (! Schema::hasTable($tableName)) continue;
            $columns = array_values(array_filter(['ReqDivID', 'ReqUser'], fn ($column) => Schema::hasColumn($tableName, $column)));
            if ($columns) Schema::table($tableName, fn (Blueprint $table) => $table->dropColumn($columns));
        }
    }

    public function down(): void
    {
        // Requester division and username are derived from EmpFormID and its employee history.
        // Re-creating these fields would introduce duplicate, potentially stale identity data.
    }
};
