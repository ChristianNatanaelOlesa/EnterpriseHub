<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('tr_empemail', function (Blueprint $table) {
            $table->string('EmpEmailID', 13)->primary();
            $table->string('EmpFormID', 13)->nullable();
            $table->date('ReqDate');

            $table->string('EmailType', 20);
            $table->string('Email', 300);
            $table->text('Purpose');
            $table->text('Notes')->default('-');

            $table->string('ReqType', 10);
            $table->date('DateFrom');
            $table->date('DateUntil')->default('1900-01-01');

            $table->string('CocID', 6)->default('COC003');
            $table->boolean('IsConfirm')->default(false);
            $table->string('QRAppCoc', 200)->default('-');

            $table->boolean('IsGiven')->default(false);
            $table->date('GivenDate')->default('1900-01-01');
            $table->text('GivenNote')->default('-');

            $table->boolean('IsTakeOut')->default(false);
            $table->date('TakeOutDate')->default('1900-01-01');
            $table->text('TakeOutNote')->default('-');

            $table->string('Status', 10)->default('DRAFT');

            $table->dateTime('InputDate')->useCurrent();
            $table->string('InputUser', 50)->default('Admin');
            $table->dateTime('ModifDate')->useCurrent();
            $table->string('ModifUser', 50)->default('Admin');

            $table->foreign('EmpFormID')
                ->references('EmpFormID')
                ->on('tr_empform')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->index('EmpFormID');
            $table->index('Status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tr_empemail');
    }
};
