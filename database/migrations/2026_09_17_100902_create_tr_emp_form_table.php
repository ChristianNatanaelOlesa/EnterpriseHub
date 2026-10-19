<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('tr_empform', function (Blueprint $table) {
            $table->string('EmpFormID', 13)->primary();

            $table->string('FirstName', 300);
            $table->string('LastName', 300);
            $table->string('MobileNo', 30);
            $table->date('BirthDate');
            $table->string('NIP', 30);
            $table->string('MaritalStatus', 1);
            $table->string('ReligionID', 3);
            $table->date('JoinDate');
            $table->unsignedInteger('VillageID');
            $table->string('Address', 1000);
            $table->string('Email', 200);

            $table->dateTime('InputDate');
            $table->string('InputUser', 50);
            $table->dateTime('ModifDate');
            $table->string('ModifUser', 50);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tr_empform');
    }
};
