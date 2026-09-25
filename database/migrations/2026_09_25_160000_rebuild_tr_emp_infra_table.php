<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('Tr_EmpInfra');

        Schema::create('Tr_EmpInfra', function (Blueprint $table) {
            $table->string('EmpInfraID', 13)->primary();

            $table->string('EmpFormID', 13);
            $table->string('ReqDivID', 3)->nullable();
            $table->string('ReqUser', 50);
            $table->date('ReqDate');

            $table->string('ReqType', 10)->default('Permanent');
            $table->date('DateFrom');
            $table->date('DateUntil')->default('1900-01-01');

            $table->string('AccessType', 20);
            $table->string('AccessArea', 200)->default('Akun Windows');
            $table->string('UserLogin', 100)->unique();

            $table->text('Purpose');
            $table->string('Notes', 1000)->default('-');

            $table->string('CocID', 6)->default('COC005');

            $table->boolean('IsConfirm')->default(false);
            $table->string('QRAppCoc', 200)->default('-');

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

            $table->index('ReqDivID');
            $table->index('ReqUser');
            $table->index('ReqType');
            $table->index('DateFrom');
            $table->index('AccessType');
            $table->index('Status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Tr_EmpInfra');
    }
};
