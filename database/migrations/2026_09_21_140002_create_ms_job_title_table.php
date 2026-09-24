<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('ms_job_title', function (Blueprint $table) {
            $table->id('JobTitleID');
            $table->string('JobTitle', 200);
            $table->boolean('IsActive')->default(true);

            $table->dateTime('InputDate')->useCurrent();
            $table->string('InputUser', 50)->default('Admin');

            $table->dateTime('ModifDate')->useCurrent();
            $table->string('ModifUser', 50)->default('Admin');

            $table->string('DeletedBy', 50)->nullable();
            $table->dateTime('DeletedDate')->nullable();

            $table->unique('JobTitle');
            $table->index('IsActive');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ms_job_title');
    }
};
