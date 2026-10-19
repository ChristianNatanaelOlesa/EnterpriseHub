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
        Schema::table('sc_permission', function (Blueprint $table) {
            if (Schema::hasColumn('sc_permission', 'Code')) {
                $table->dropUnique('sc_permission_code_unique');
                $table->dropColumn('Code');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sc_permission', function (Blueprint $table) {
            if (! Schema::hasColumn('sc_permission', 'Code')) {
                $table->string('Code', 50)->unique()->after('PermissionID');
            }
        });
    }
};
