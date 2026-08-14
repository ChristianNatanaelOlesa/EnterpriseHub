<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('sc_user', function (Blueprint $Table) {

            $Table->bigIncrements('UserID');

            $Table->string('Username', 50)->unique();

            $Table->string('FullName', 100);

            $Table->string('Password', 255);

            $Table->unsignedBigInteger('RoleID')->nullable();

            $Table->string('Email', 100)->nullable();

            $Table->string('PhoneNumber', 30)->nullable();

            $Table->string('Photo', 255)->nullable();

            $Table->dateTime('LastLogin')->nullable();

            $Table->boolean('IsActive')->default(true);

            $Table->auditColumns();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sc_user');
    }
};
