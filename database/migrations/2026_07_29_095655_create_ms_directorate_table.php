<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('ms_directorate', function (Blueprint $table) {

            $table->string('DirID', 3)->primary();

            $table->string('CompID');

            $table->string('Directorate', 200);

            $table->text('Description');

            $table->boolean('IsActive')->default(true);

            $table->auditColumns();

            $table->foreign('CompID')
                    ->references('CompID')
                    ->on('ms_company')
                    ->cascadeOnUpdate()
                    ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ms_directorate');
    }
};
