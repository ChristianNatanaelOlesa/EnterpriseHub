<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Tr_EmpITArea', function (Blueprint $table) {
            $table->string('EmpITAreaID', 13)->primary();
            $table->string('EmpFormID', 13);
            $table->string('SourceType', 30);
            $table->boolean('EmailOnTablet')->default(false);
            $table->boolean('EmailOnPhone')->default(false);
            $table->boolean('Fingerprint')->default(false);
            $table->boolean('CCTV')->default(false);
            $table->boolean('Firewall')->default(false);
            $table->boolean('ExternalDrive')->default(false);
            $table->boolean('DataCenter')->default(false);
            $table->string('Status', 30)->default('DRAFT');
            $table->string('InputUser', 50)->default('Admin');
            $table->dateTime('InputDate')->useCurrent();
            $table->string('ModifUser', 50)->default('Admin');
            $table->dateTime('ModifDate')->useCurrent();

            $table->foreign('EmpFormID')
                ->references('EmpFormID')
                ->on('Tr_EmpForm')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->index('EmpFormID');
            $table->index('SourceType');
            $table->index('Status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Tr_EmpITArea');
    }
};
