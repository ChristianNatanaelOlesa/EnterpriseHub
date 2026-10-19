<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('ms_religion', function (Blueprint $table) {
            $table->string('ReligionID', 3)->primary();

            $table->string('Religion', 50);

            $table->boolean('IsActive')->default(true);

            $table->auditColumns();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ms_religion');
    }
};
