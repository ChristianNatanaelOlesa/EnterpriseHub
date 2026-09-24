<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ms_asset_type', function (Blueprint $table) {
            $table->string('AssTypeID', 50)->primary();
            $table->string('AssetGroupID', 50);
            $table->string('AssetType', 150);
            $table->text('TypeDesc');
            $table->boolean('IsActive')->default(true);
            $table->string('InputUser', 100)->default('Admin');
            $table->dateTime('InputDate')->useCurrent();
            $table->string('ModifUser', 100)->default('Admin');
            $table->dateTime('ModifDate')->useCurrent();
            $table->string('DeletedBy', 100)->nullable();
            $table->dateTime('DeletedDate')->nullable();

            $table->index('AssetGroupID');
            $table->foreign('AssetGroupID')
                ->references('AssGroupID')
                ->on('ms_asset_group');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ms_asset_type');
    }
};
