<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('sc_user_dept', function (Blueprint $table) {

            $table->bigIncrements('UserDeptID');

            $table->unsignedBigInteger('UserID');
            $table->unsignedBigInteger('DepartmentID');

            $table->boolean('IsActive')->default(true);

            $table->auditColumns();

            $table->foreign('UserID')
                ->references('UserID')
                ->on('sc_user');

            $table->foreign('DepartmentID')
                ->references('DepartmentID')
                ->on('ms_department');

            $table->unique(['UserID', 'DepartmentID']);

            $table->index('UserID');
            $table->index('DepartmentID');
            $table->index('IsActive');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sc_user_dept');
    }
};
