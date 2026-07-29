<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('ms_division', function (Blueprint $table) {

            $table->bigIncrements('ID');

            $table->unsignedBigInteger('DirectorateID');

            $table->string('DivisionCode', 20);
            $table->string('DivisionName', 200);

            $table->boolean('IsActive')->default(true);

            $table->auditColumns();

            $table->foreign('DirectorateID')
                ->references('ID')
                ->on('ms_directorate')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->unique(['DirectorateID', 'DivisionCode']);

            $table->index('DirectorateID');
            $table->index('IsActive');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ms_division');
    }
};
