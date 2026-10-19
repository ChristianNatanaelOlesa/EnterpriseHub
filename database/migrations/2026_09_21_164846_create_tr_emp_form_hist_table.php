<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('tr_empformhist', function (Blueprint $table) {
            $table->string('EmpFormHistID', 16)->primary();
            $table->string('EmpFormID', 13);

            // Organization
            $table->string('CompID', 3)->nullable();
            $table->string('DirID', 3)->nullable();
            $table->string('DivID', 3)->nullable();
            $table->string('DeptID', 3)->nullable();

            // Job
            $table->unsignedBigInteger('JobLvlID')->nullable();
            $table->unsignedBigInteger('JobTitleID')->nullable();

            // Employment
            $table->string('ReportTo', 3)->nullable();
            $table->string('EmpStatus', 50)->nullable();

            // Request
            $table->date('EffectiveDate');
            $table->string('Remarks', 1000);
            $table->date('ReqDate');

            $table->boolean('IsActive')->nullable();

            // Workflow / Approval
            $table->string('QRApp', 200)->nullable();
            $table->string('Status', 10)->nullable();

            // Audit
            $table->dateTime('InputDate')->nullable();
            $table->string('InputUser', 50)->nullable();
            $table->dateTime('ModifDate')->nullable();
            $table->string('ModifUser', 50)->nullable();

            $table->foreign('EmpFormID')
                ->references('EmpFormID')
                ->on('tr_empform');

            $table->foreign('CompID')
                ->references('CompID')
                ->on('ms_company');

            $table->foreign('DirID')
                ->references('DirID')
                ->on('ms_directorate');

            $table->foreign('DivID')
                ->references('DivID')
                ->on('ms_division');

            $table->foreign('DeptID')
                ->references('DeptID')
                ->on('ms_department');

            $table->foreign('JobLvlID')
                ->references('JobLevelID')
                ->on('ms_job_level');

            $table->foreign('JobTitleID')
                ->references('JobTitleID')
                ->on('ms_job_title');

            $table->index('EmpFormID');
            $table->index('EffectiveDate');
            $table->index('Status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tr_empformhist');
    }
};
