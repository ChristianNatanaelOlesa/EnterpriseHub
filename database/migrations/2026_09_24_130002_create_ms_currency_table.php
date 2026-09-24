<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ms_currency', function (Blueprint $table) {
            $table->string('CcyID', 10)->primary();
            $table->string('Currency', 100);
            $table->unsignedInteger('Priority')->default(999);
            $table->boolean('IsActive')->default(true);
            $table->string('InputUser', 100)->default('Admin');
            $table->dateTime('InputDate')->useCurrent();
            $table->string('ModifUser', 100)->default('Admin');
            $table->dateTime('ModifDate')->useCurrent();
            $table->string('DeletedBy', 100)->nullable();
            $table->dateTime('DeletedDate')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ms_currency');
    }
};
