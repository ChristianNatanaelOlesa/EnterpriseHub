<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('ms_province', function (Blueprint $table) {
            $table->string('ProvinceID', 10)->primary();

            $table->string('CountryID', 3);

            $table->string('Province', 100);

            $table->boolean('IsActive')->default(true);

            $table->auditColumns();

            $table->foreign('CountryID')
                ->references('CountryID')
                ->on('ms_country');

            $table->index('CountryID');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ms_province');
    }
};
