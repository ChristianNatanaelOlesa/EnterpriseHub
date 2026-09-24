<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('Tr_EmpFormHist', function (Blueprint $table) {
            $table->string('EmpFormHistID', 16)->primary();

            $table->string('EmpFormID', 13);

            // Organization
            $table->string('DirID', 3)->nullable();
            $table->string('DivID', 3)->nullable();
            $table->string('DeptID', 3)->nullable();

            // Job
            $table->unsignedSmallInteger('JobLvlID')->nullable();
            $table->unsignedSmallInteger('JobTitleID')->nullable();

            // Employment
            $table->string('ReportTo', 3)->nullable();
            $table->string('EmpStatus', 50)->nullable();

            // Request
            $table->date('EffectiveDate');
            $table->string('Remarks', 1000);
            $table->string('ReqUser', 50)->nullable();
            $table->date('ReqDate');

            $table->boolean('IsActive')->nullable();

            // Workflow / Approval
            $table->string('QRApp', 200)->nullable();
            $table->string('Status', 10)->nullable();
            $table->string('UserID', 3)->nullable();
            $table->string('ProcessID', 9)->nullable();
            $table->string('CurrentStateID', 11)->nullable();

            // Audit
            $table->dateTime('InputDate')->nullable();
            $table->string('InputUser', 50)->nullable();
            $table->dateTime('ModifDate')->nullable();
            $table->string('ModifUser', 50)->nullable();

            $table->foreign('EmpFormID')
                ->references('EmpFormID')
                ->on('Tr_EmpForm');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Tr_EmpFormHist');
    }
};
