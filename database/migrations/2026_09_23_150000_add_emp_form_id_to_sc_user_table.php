<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('sc_user', function (Blueprint $table) {
            $table->string('EmpFormID', 13)->nullable()->after('UserID');
            $table->index('EmpFormID', 'sc_user_empformid_index');
        });
    }

    public function down(): void
    {
        Schema::table('sc_user', function (Blueprint $table) {
            $table->dropIndex('sc_user_empformid_index');
            $table->dropColumn('EmpFormID');
        });
    }
};
