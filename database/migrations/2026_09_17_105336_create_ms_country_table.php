<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('ms_country', function (Blueprint $table) {
            $table->string('CountryID', 3)->primary();

            $table->string('Country', 100);

            $table->boolean('IsActive')->default(true);

            $table->auditColumns();

            $table->index('IsActive');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ms_country');
    }
};
