<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('ms_division', function (Blueprint $table) {

            $table->id('DivisionID');

            $table->unsignedBigInteger('DirectorateID');

            $table->string('DivisionCode', 20);
            $table->string('DivisionName', 200);

            $table->boolean('IsActive')->default(true);

            $table->auditColumns();

            $table->foreign('DirectorateID')
                ->references('DirectorateID')
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
