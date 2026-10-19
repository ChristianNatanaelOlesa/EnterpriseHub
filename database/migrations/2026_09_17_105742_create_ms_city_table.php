<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('ms_city', function (Blueprint $table) {
            $table->string('CityID', 10)->primary();

            $table->string('ProvinceID', 10);

            $table->string('City', 100);

            $table->boolean('IsActive')->default(true);

            $table->auditColumns();

            $table->foreign('ProvinceID')
                ->references('ProvinceID')
                ->on('ms_province');

            $table->index('ProvinceID');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ms_city');
    }
};
