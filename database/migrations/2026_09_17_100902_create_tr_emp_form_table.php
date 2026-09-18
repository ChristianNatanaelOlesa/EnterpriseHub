<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('Tr_EmpForm', function (Blueprint $table) {
            $table->string('EmpFormID', 13)->primary();

            $table->string('FirstName', 300);
            $table->string('LastName', 300)->nullable();
            $table->string('MobileNo', 30)->nullable();
            $table->date('BirthDate')->nullable();
            $table->string('NIP', 30)->nullable();
            $table->string('MaritalStatus', 1)->nullable();
            $table->string('ReligionID', 3)->nullable();
            $table->date('JoinDate')->nullable();
            $table->unsignedInteger('VillageID')->nullable();
            $table->string('Address', 1000)->nullable();
            $table->string('Email', 200)->nullable();

            $table->dateTime('InputDate')->nullable();
            $table->string('InputUser', 50)->nullable();
            $table->dateTime('ModifDate')->nullable();
            $table->string('ModifUser', 50)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Tr_EmpForm');
    }
};
