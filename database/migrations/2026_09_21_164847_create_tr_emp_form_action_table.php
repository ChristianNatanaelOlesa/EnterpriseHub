<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('Tr_EmpFormAction', function (Blueprint $table) {
            $table->string('EmpFormActionID', 18)->primary();

            $table->string('EmpFormHistID', 15);

            $table->string('ActionID', 12)->nullable();
            $table->string('TransitionID', 22)->nullable();

            $table->string('Comments', 500)->nullable();

            $table->boolean('IsActive')->nullable();
            $table->boolean('IsComplete')->nullable();

            $table->string('CompletedBy', 50)->nullable();

            $table->date('DueDateOrg')->nullable();
            $table->date('DueDate')->nullable();
            $table->date('ApvDate')->nullable();

            $table->string('QRCodeLoc', 200)->nullable();
            $table->string('Keys', 5)->nullable();
            $table->string('EncryptQRCode', 500)->nullable();

            // Audit
            $table->dateTime('InputDate')->nullable();
            $table->string('InputUser', 50)->nullable();
            $table->dateTime('ModifDate')->nullable();
            $table->string('ModifUser', 50)->nullable();

            $table->foreign('EmpFormHistID')
                ->references('EmpFormHistID')
                ->on('Tr_EmpFormHist');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Tr_EmpFormAction');
    }
};
