<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::dropIfExists('Tr_EmpApp');

        Schema::create('Tr_EmpApp', function (Blueprint $table) {
            $table->string('EmpAppID', 13)->primary();
            $table->string('EmpFormID', 13);
            $table->string('ReqDivID', 50);
            $table->string('ReqUser', 50);
            $table->date('ReqDate');
            $table->string('ReqType', 30)->default('Permanent');
            $table->string('Purpose', 3000)->default('Kebutuhan Pekerjaan');
            $table->date('DateFrom');
            $table->date('DateUntil')->default('1900-01-01');
            $table->string('UserLogin', 200)->default('-');
            $table->string('UserPassword', 200)->default('-');
            $table->string('AccessType', 30);
            $table->string('AppType', 30);
            $table->string('AppName', 300);
            $table->string('URL', 1000)->default('-');
            $table->string('Notes', 1000)->default('-');

            $table->string('CocID', 20)->default('COC006');
            $table->boolean('IsConfirm')->default(false);
            $table->string('QRAppCoc', 300)->default('-');
            $table->boolean('IsGiven')->default(false);
            $table->date('GivenDate')->default('1900-01-01');
            $table->string('GivenNote', 1000)->default('-');
            $table->boolean('IsTakeOut')->default(false);
            $table->date('TakeOutDate')->default('1900-01-01');
            $table->string('TakeOutNote', 1000)->default('-');

            $table->string('Status', 30)->default('DRAFT');

            $table->dateTime('InputDate')->useCurrent();
            $table->string('InputUser', 50)->default('Admin');
            $table->dateTime('ModifDate')->useCurrent();
            $table->string('ModifUser', 50)->default('Admin');

            $table->foreign('EmpFormID')
                ->references('EmpFormID')
                ->on('Tr_EmpForm')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->index('EmpFormID');
            $table->index('ReqDivID');
            $table->index('ReqUser');
            $table->index('Status');
            $table->index('AppType');
            $table->index('AppName');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Tr_EmpApp');
    }
};
