<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('Sc_Role', function (Blueprint $Table) {

            $Table->id('ID');

            $Table->string('Code', 30)->unique();

            $Table->string('Name', 100);

            $Table->string('Description', 255)->nullable();

            $Table->boolean('IsActive')->default(true);

            $Table->unsignedBigInteger('CreatedBy')->nullable();

            $Table->dateTime('CreatedDate')->nullable();

            $Table->unsignedBigInteger('UpdatedBy')->nullable();

            $Table->dateTime('UpdatedDate')->nullable();

            $Table->unsignedBigInteger('DeletedBy')->nullable();

            $Table->dateTime('DeletedDate')->nullable();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Sc_Role');
    }
};
