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
        Schema::create('wf_trans_action', function (Blueprint $table) {
            $table->id('TransActionID');

            $table->string('Transition', 100);
            $table->string('ActionID', 50);

            $table->boolean('IsActive')->default(true);

            $table->dateTime('InputDate')->nullable();
            $table->string('InputUser', 100)->nullable();

            $table->dateTime('ModifDate')->nullable();
            $table->string('ModifUser', 100)->nullable();

            $table->foreign('Transition')
                ->references('Transition')
                ->on('wf_transition')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreign('ActionID')
                ->references('ActionID')
                ->on('wf_action')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->unique(['Transition', 'ActionID']);

            $table->index('Transition');
            $table->index('ActionID');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wf_trans_action');
    }
};
