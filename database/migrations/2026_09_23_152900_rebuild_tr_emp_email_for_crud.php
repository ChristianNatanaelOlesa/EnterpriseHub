<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('Tr_EmpEmail')) {
            return;
        }

        // Existing development table was an early draft. Rebuild it only when
        // the old SourceType column is still present.
        if (!Schema::hasColumn('Tr_EmpEmail', 'SourceType')) {
            return;
        }

        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('Tr_EmpEmailDetail');
        Schema::drop('Tr_EmpEmail');

        Schema::create('Tr_EmpEmail', function (Blueprint $table) {
            $table->string('EmpEmailID', 13)->primary();
            $table->string('EmpFormID', 13)->nullable();
            $table->string('ReqDivID', 3)->nullable();
            $table->string('ReqUser', 50);
            $table->date('ReqDate');
            $table->string('ReqType', 10);
            $table->string('EmailType', 20);
            $table->string('Email', 300);
            $table->text('Purpose');
            $table->date('DateFrom');
            $table->date('DateUntil')->default('1900-01-01');
            $table->text('Notes')->nullable();
            $table->string('CocID', 6)->nullable();
            $table->boolean('IsConfirm')->default(false);
            $table->string('QRAppCoc', 200)->nullable();
            $table->boolean('IsGiven')->default(false);
            $table->date('GivenDate')->default('1900-01-01');
            $table->text('GivenNote')->nullable();
            $table->boolean('IsTakeOut')->default(false);
            $table->date('TakeOutDate')->default('1900-01-01');
            $table->text('TakeOutNote')->nullable();
            $table->string('Status', 10)->default('-');
            $table->dateTime('InputDate')->useCurrent();
            $table->string('InputUser', 50)->default('Admin');
            $table->dateTime('ModifDate')->useCurrent();
            $table->string('ModifUser', 50)->default('Admin');

            $table->foreign('EmpFormID')
                ->references('EmpFormID')
                ->on('Tr_EmpForm')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->index('EmpFormID');
            $table->index('ReqDivID');
            $table->index('ReqUser');
            $table->index('Status');
        });

        Schema::enableForeignKeyConstraints();
    }

    public function down(): void
    {
        // The original draft migration remains the rollback source for a
        // fresh database; no destructive rollback is performed here.
    }
};
