<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('ms_job_title', function (Blueprint $table) {
            $table->id('JobTitleID');
            $table->string('JobTitle', 200)->unique();
            $table->boolean('IsActive')->default(true);

            $table->auditColumns();

            $table->index('IsActive');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ms_job_title');
    }
};
