<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('sc_menu', function (Blueprint $table) {
            $table->string('MenuArea', 20)
                ->default('TOP')
                ->after('Name');

            $table->index('MenuArea');
        });
    }

    public function down(): void
    {
        Schema::table('sc_menu', function (Blueprint $table) {
            $table->dropIndex(['MenuArea']);
            $table->dropColumn('MenuArea');
        });
    }
};
