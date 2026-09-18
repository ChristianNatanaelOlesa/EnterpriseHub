<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('wf_action', function (Blueprint $table) {
            $table->string('ActionID', 50)->primary();

            $table->string('ProcessID', 50);

            $table->string('ActionName', 255);

            $table->boolean('IsActive')->default(true);

            $table->dateTime('InputDate')->nullable();
            $table->string('InputUser', 100)->nullable();

            $table->dateTime('ModifDate')->nullable();
            $table->string('ModifUser', 100)->nullable();

            $table->foreign('ProcessID')
                ->references('ProcessID')
                ->on('wf_process')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->index('ProcessID');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wf_action');
    }
};
