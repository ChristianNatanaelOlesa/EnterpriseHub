<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('ms_company', function (Blueprint $table) {

            $table->string('CompID', 3)->primary();

            $table->string('Company', 100);

            $table->text('Description');

            $table->string('Address');

            $table->string('Phone1', 30);

            $table->string('Phone2', 30)->default("-");

            $table->string('Email', 100)->nullable();

            $table->boolean('IsActive')->default(true);

            $table->auditColumns();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ms_company');
    }
};
