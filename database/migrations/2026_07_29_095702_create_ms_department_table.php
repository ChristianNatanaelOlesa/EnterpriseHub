<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('ms_department', function (Blueprint $table) {

            $table->id('DepartmentID');

            $table->unsignedBigInteger('DivisionID');

            $table->string('DepartmentCode', 20);
            $table->string('DepartmentName', 200);

            $table->boolean('IsActive')->default(true);

            $table->auditColumns();

            $table->foreign('DivisionID')
                ->references('DivisionID')
                ->on('ms_division')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ms_department');
    }
};
