<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('ms_email_group', function (Blueprint $table) {
            $table->string('EmailGroupID', 5)->primary();
            $table->string('Email', 100);
            $table->text('Description');
            $table->boolean('IsGroup')->default(true);
            $table->boolean('IsActive')->default(true);

            $table->auditColumns();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ms_email_group');
    }
};
