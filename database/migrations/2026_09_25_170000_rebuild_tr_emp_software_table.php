<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('Tr_EmpSoftware');

        Schema::create('Tr_EmpSoftware', function (Blueprint $table) {
            $table->string('EmpSoftwareID', 13)->primary();
            $table->string('EmpFormID', 13);
            $table->unsignedBigInteger('ReqDivID');
            $table->string('ReqUser', 50);
            $table->date('ReqDate');
            $table->string('ReqType', 20)->default('Permanent');
            $table->date('DateFrom');
            $table->date('DateUntil')->default('1900-01-01');
            $table->string('SoftType', 100);
            $table->string('SoftTool', 200);
            $table->text('Purpose');
            $table->text('Notes')->nullable();
            $table->string('CocID', 20)->default('COC004');
            $table->boolean('IsConfirm')->default(false);
            $table->string('QRAppCoc', 100)->default('-');
            $table->boolean('IsGiven')->default(false);
            $table->date('GivenDate')->default('1900-01-01');
            $table->string('GivenNote', 1000)->default('-');
            $table->boolean('IsTakeOut')->default(false);
            $table->date('TakeOutDate')->default('1900-01-01');
            $table->string('TakeOutNote', 1000)->default('-');
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

            $table->foreign('ReqDivID')
                ->references('DivisionID')
                ->on('ms_division')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->index('EmpFormID');
            $table->index('ReqDivID');
            $table->index('ReqUser');
            $table->index('DateFrom');
            $table->index('SoftType');
            $table->index('Status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Tr_EmpSoftware');
    }
};
