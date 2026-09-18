<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('tr_form_hco_action', function (Blueprint $table) {

            $table->string('FormHCOActionID', 15)->primary();

            $table->string('FormHCOReqID', 12);

            $table->string('ActionID', 12);

            $table->string('TransitionID', 22);

            $table->string('Comments', 500);

            $table->boolean('IsActive')->nullable();

            $table->boolean('IsComplete')->nullable();

            $table->string('CompletedBy', 50)->nullable();

            $table->date('DueDateOrg');

            $table->date('DueDate');

            $table->date('ApvDate');

            $table->string('QRCodeLoc', 200)->nullable();

            $table->string('Keys', 5)->nullable();

            $table->string('EncryptQRCode', 500)->nullable();

            $table->dateTime('InputDate')->nullable();

            $table->string('InputUser', 50)->nullable();

            $table->dateTime('ModifDate')->nullable();

            $table->string('ModifUser', 50)->nullable();

            $table->index('FormHCOReqID');
            $table->index('ActionID');
            $table->index('TransitionID');
            $table->index('CompletedBy');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tr_form_hco_action');
    }
};
