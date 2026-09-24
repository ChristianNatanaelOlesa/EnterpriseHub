<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('Ms_Coc')) {
            return;
        }

        Schema::create('Ms_Coc', function (Blueprint $table) {
            $table->string('CocID', 6)->primary();
            $table->string('Name', 200);
            $table->string('Description', 1000);
            $table->longText('Contents');
            $table->string('FileLoc', 200);
            $table->dateTime('InputDate');
            $table->string('InputUser', 50);
            $table->dateTime('ModifDate');
            $table->string('ModifUser', 50);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Ms_Coc');
    }
};
