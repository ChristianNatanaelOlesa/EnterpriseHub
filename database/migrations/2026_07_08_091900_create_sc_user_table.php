<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('Sc_User', function (Blueprint $Table) {

            $Table->bigIncrements('ID');

            $Table->string('Username', 50)->unique();

            $Table->string('Password', 255);

            $Table->string('FullName', 100);

            $Table->string('Email', 100)->nullable();

            $Table->string('PhoneNumber', 30)->nullable();

            $Table->string('Photo', 255)->nullable();

            $Table->dateTime('LastLogin')->nullable();

            $Table->boolean('IsActive')->default(true);

            $Table->auditColumns();

            $Table->index('Username');
            $Table->index('Email');
            $Table->index('IsActive');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Sc_User');
    }
};
