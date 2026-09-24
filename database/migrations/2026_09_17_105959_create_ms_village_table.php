<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('ms_village', function (Blueprint $table) {
            $table->unsignedBigInteger('VillageID')->primary();

            $table->string('DistrictID', 10);
            $table->string('Village', 100);
            $table->string('PostalCode', 10)->nullable();
            $table->boolean('IsActive')->default(true);

            // Audit fields
            $table->dateTime('InputDate')->useCurrent();
            $table->string('InputUser', 50)->default('Admin');

            $table->dateTime('ModifDate')->useCurrent();
            $table->string('ModifUser', 50)->default('Admin');

            $table->string('DeletedBy', 50)->nullable();
            $table->dateTime('DeletedDate')->nullable();

            // Foreign key
            $table->foreign('DistrictID')
                ->references('DistrictID')
                ->on('ms_district');

            // Index
            $table->index('DistrictID');
            $table->index('PostalCode');
            $table->index('IsActive');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ms_village');
    }
};
