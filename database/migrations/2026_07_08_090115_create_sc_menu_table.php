<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('Sc_Menu', function (Blueprint $Table) {

            $Table->bigIncrements('ID');

            $Table->unsignedBigInteger('ParentID')->nullable();

            $Table->string('Code', 30)->unique();

            $Table->string('Name', 100);

            $Table->string('Route', 255)->nullable();

            $Table->string('URL', 255)->nullable();

            $Table->string('Icon', 100)->nullable();

            $Table->integer('SortOrder')->default(0);

            $Table->boolean('IsMenu')->default(true);

            $Table->boolean('IsActive')->default(true);

            $Table->unsignedBigInteger('CreatedBy')->nullable();
            $Table->dateTime('CreatedDate')->useCurrent();

            $Table->unsignedBigInteger('UpdatedBy')->nullable();
            $Table->dateTime('UpdatedDate')->nullable();

            $Table->unsignedBigInteger('DeletedBy')->nullable();
            $Table->dateTime('DeletedDate')->nullable();

            $Table->foreign('ParentID')
                  ->references('ID')
                  ->on('Sc_Menu');

            $Table->index('ParentID');
            $Table->index('Code');
            $Table->index('IsActive');
            $Table->index('SortOrder');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Sc_Menu');
    }
};
