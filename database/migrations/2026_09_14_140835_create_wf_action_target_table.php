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
        Schema::create('wf_action_target', function (Blueprint $table) {
            $table->id('ActionTargetID');

            $table->string('ActionID', 50);

            $table->string('TargetID', 20);

            $table->string('GroupID', 50);

            $table->boolean('IsActive')->default(true);

            $table->dateTime('InputDate')->nullable();
            $table->string('InputUser', 100)->nullable();

            $table->dateTime('ModifDate')->nullable();
            $table->string('ModifUser', 100)->nullable();

            $table->foreign('ActionID')
                ->references('ActionID')
                ->on('wf_action')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreign('GroupID')
                ->references('GroupID')
                ->on('wf_group')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->index('TargetID');
            $table->index(['ActionID', 'GroupID']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wf_action_target');
    }
};
