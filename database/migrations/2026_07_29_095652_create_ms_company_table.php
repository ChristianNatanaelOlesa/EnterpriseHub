<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('ms_company', function (Blueprint $table) {

            $table->id('CompanyID');

            $table->string('CompanyCode', 20)->unique();

            $table->string('CompanyName', 100);

            $table->string('Address')->nullable();

            $table->string('Phone', 30)->nullable();

            $table->string('Email', 100)->nullable();

            $table->boolean('IsActive')->default(true);

            $table->string('CreatedBy', 50)->nullable();

            $table->timestamp('CreatedDate')->nullable();

            $table->string('UpdatedBy', 50)->nullable();

            $table->timestamp('UpdatedDate')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ms_company');
    }
};
