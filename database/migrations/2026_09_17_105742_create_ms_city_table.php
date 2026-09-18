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

            $table->dateTime('InputDate')->useCurrent();
            $table->string('InputUser', 50)->default('Admin');
            $table->dateTime('ModifDate')->useCurrent();
            $table->string('ModifUser', 50)->default('Admin');
            $table->string('DeletedBy', 50)->nullable();
            $table->dateTime('DeletedDate')->nullable();

            $table->foreign('ProvinceID')
                ->references('ProvinceID')
                ->on('ms_province');

            $table->index('ProvinceID');
            $table->index('IsActive');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ms_city');
    }
};
