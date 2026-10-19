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

            $table->auditColumns();

            // Foreign key
            $table->foreign('DistrictID')
                ->references('DistrictID')
                ->on('ms_district');

            // Index
            $table->index('DistrictID');
            $table->index('PostalCode');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ms_village');
    }
};
