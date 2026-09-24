<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Tr_EmpNetwork', function (Blueprint $table) {
            $table->string('EmpNetworkID', 13)->primary();
            $table->string('EmpFormID', 13);
            $table->string('SourceType', 30);
            $table->boolean('WLAN')->default(false);
            $table->boolean('Internet')->default(false);
            $table->boolean('VPN')->default(false);
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

            $table->index('EmpFormID');
            $table->index('SourceType');
            $table->index('Status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Tr_EmpNetwork');
    }
};
