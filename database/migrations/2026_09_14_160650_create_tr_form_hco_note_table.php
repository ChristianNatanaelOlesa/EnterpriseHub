<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('tr_form_hco_note', function (Blueprint $table) {

            $table->string('FormHCONoteID', 16)->primary();

            $table->string('FormHCOReqID', 13);

            $table->string('ActionTypeID', 3);

            $table->string('UserID', 3);

            $table->string('Notes', 3000);

            $table->dateTime('InputDate')->nullable();

            $table->string('InputUser', 50)->nullable();

            $table->dateTime('ModifDate')->nullable();

            $table->string('ModifUser', 50)->nullable();

            $table->index('FormHCOReqID');

            $table->index('ActionTypeID');

            $table->index('UserID');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tr_form_hco_note');
    }
};
