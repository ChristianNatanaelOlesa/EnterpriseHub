<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('ms_email_group', function (Blueprint $table) {
            $table->unsignedBigInteger('DivisionID')->after('EmailGroupID');
            $table->foreign('DivisionID')
                ->references('DivisionID')
                ->on('ms_division');
            $table->index('DivisionID');
        });
    }

    public function down(): void
    {
        Schema::table('ms_email_group', function (Blueprint $table) {
            $table->dropForeign(['DivisionID']);
            $table->dropIndex(['DivisionID']);
            $table->dropColumn('DivisionID');
        });
    }
};
