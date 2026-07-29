<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('ms_department', function (Blueprint $table) {

            $table->bigIncrements('ID');

            $table->unsignedBigInteger('DivisionID');

            $table->string('DepartmentCode', 20);
            $table->string('DepartmentName', 200);

            $table->boolean('IsActive')->default(true);

            $table->auditColumns();

            $table->foreign('DivisionID')
                ->references('ID')
                ->on('ms_division')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->unique(['DivisionID', 'DepartmentCode']);

            $table->index('DivisionID');
            $table->index('IsActive');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ms_department');
    }
};
