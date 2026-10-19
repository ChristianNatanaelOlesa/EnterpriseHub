<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('ms_job_level', function (Blueprint $table) {
            $table->id('JobLevelID');

            $table->string('JobLevel', 100)->unique();

            $table->boolean('IsActive')->default(true);

            $table->auditColumns();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ms_job_level');
    }
};
