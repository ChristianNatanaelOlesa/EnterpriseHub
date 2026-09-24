<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Tr_EmpEmailDetail', function (Blueprint $table) {
            $table->string('EmpEmailDetailID', 16)->primary();
            $table->string('EmpEmailID', 13);
            $table->string('EmailCategory', 20);
            $table->string('EmailAddress', 200);
            $table->string('RequestType', 30)->nullable();
            $table->date('DateFrom')->nullable();
            $table->date('DateUntil')->nullable();
            $table->string('Purpose', 500)->nullable();
            $table->string('Notes', 1000)->nullable();
            $table->string('InputUser', 50)->default('Admin');
            $table->dateTime('InputDate')->useCurrent();
            $table->string('ModifUser', 50)->default('Admin');
            $table->dateTime('ModifDate')->useCurrent();

            $table->foreign('EmpEmailID')
                ->references('EmpEmailID')
                ->on('Tr_EmpEmail')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->index('EmpEmailID');
            $table->index('EmailCategory');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Tr_EmpEmailDetail');
    }
};
