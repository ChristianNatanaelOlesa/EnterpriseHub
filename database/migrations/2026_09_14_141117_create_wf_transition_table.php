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
        Schema::create('wf_transition', function (Blueprint $table) {
            $table->string('Transition', 100)->primary();

            $table->string('ProcessID', 50);

            $table->string('CurrentStateID', 50);
            $table->string('NextStateID', 50);

            $table->string('TransitionDesc', 500)->nullable();

            $table->integer('SLADays')->default(0);

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

            $table->foreign('CurrentStateID')
                ->references('StateID')
                ->on('wf_state')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreign('NextStateID')
                ->references('StateID')
                ->on('wf_state')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->index('ProcessID');
            $table->index('CurrentStateID');
            $table->index('NextStateID');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wf_transition');
    }
};
