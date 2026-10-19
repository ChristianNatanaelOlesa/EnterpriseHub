<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('ms_asset_group', function (Blueprint $table) {
            $table->string('AssGroupID', 50)->primary();
            $table->string('AssetGroup', 200);
            $table->decimal('ComLifetime', 10, 2)->nullable();
            $table->decimal('FiscalLifetime', 10, 2)->nullable();
            $table->text('Description');
            $table->boolean('IsActive')->default(true);

            $table->auditColumns();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ms_asset_group');
    }
};
