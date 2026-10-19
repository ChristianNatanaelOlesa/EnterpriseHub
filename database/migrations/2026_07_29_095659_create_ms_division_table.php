<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('ms_division', function (Blueprint $table) {

            $table->string('DivID', 3)->primary();

            $table->string('DirID');

            $table->string('Division', 200);

            $table->text('Description');

            $table->boolean('IsActive')->default(true);

            $table->auditColumns();

            $table->foreign('DirID')
                ->references('DirID')
                ->on('ms_directorate')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ms_division');
    }
};
