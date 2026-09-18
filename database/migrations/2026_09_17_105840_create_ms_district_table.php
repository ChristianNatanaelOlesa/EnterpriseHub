<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('ms_district', function (Blueprint $table) {
            $table->string('DistrictID', 10)->primary();
            $table->string('CityID', 10);
            $table->string('District', 100);
            $table->boolean('IsActive')->default(true);

            $table->dateTime('InputDate')->useCurrent();
            $table->string('InputUser', 50)->default('Admin');
            $table->dateTime('ModifDate')->useCurrent();
            $table->string('ModifUser', 50)->default('Admin');
            $table->string('DeletedBy', 50)->nullable();
            $table->dateTime('DeletedDate')->nullable();

            $table->foreign('CityID')
                ->references('CityID')
                ->on('ms_city');

            $table->index('CityID');
            $table->index('IsActive');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ms_district');
    }
};
