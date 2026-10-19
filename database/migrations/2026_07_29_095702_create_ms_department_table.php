<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('ms_department', function (Blueprint $table) {

            $table->string('DeptID', 3)->primary();

            $table->string('DivID');

            $table->string('Department', 200);

            $table->text('Description');

            $table->boolean('IsActive')->default(true);

            $table->auditColumns();

            $table->foreign('DivID')
                ->references('DivID')
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
