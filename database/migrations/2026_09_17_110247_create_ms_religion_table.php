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

            // Audit fields
            $table->dateTime('InputDate')->useCurrent();
            $table->string('InputUser', 50)->default('Admin');

            $table->dateTime('ModifDate')->useCurrent();
            $table->string('ModifUser', 50)->default('Admin');

            $table->string('DeletedBy', 50)->nullable();
            $table->dateTime('DeletedDate')->nullable();

            $table->index('IsActive');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ms_religion');
    }
};
