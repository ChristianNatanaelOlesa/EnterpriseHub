<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Tr_EmpNetDrive', function (Blueprint $table) {
            $table->string('EmpNetDriveID',13)->primary();
            $table->string('EmpFormID',13);
            $table->string('SourceType',30);
            $table->string('DriveName',100);
            $table->string('DrivePath',500);
            $table->string('AccessType',50);
            $table->string('Notes',1000)->nullable();
            $table->string('Status',30);
            $table->string('InputUser',50)->default('Admin');
            $table->dateTime('InputDate')->useCurrent();
            $table->string('ModifUser',50)->default('Admin');
            $table->dateTime('ModifDate')->useCurrent();
            $table->foreign('EmpFormID')->references('EmpFormID')->on('Tr_EmpForm')->restrictOnDelete()->cascadeOnUpdate();
            $table->index('EmpFormID');
            $table->index('SourceType');
            $table->index('Status');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('Tr_EmpNetDrive');
    }
};
