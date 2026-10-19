<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('ms_coc')) {
            return;
        }

        Schema::create('Ms_Coc', function (Blueprint $table) {
            $table->string('CocID', 6)->primary();
            $table->string('Name', 200);
            $table->string('Description', 1000);
            $table->longText('Contents');
            $table->string('FileLoc', 200);

            $table->auditColumns();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ms_coc');
    }
};
