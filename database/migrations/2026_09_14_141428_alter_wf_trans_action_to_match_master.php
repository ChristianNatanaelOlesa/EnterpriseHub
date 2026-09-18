<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('wf_trans_action', function (Blueprint $table) {
            $table->dropForeign(['Transition']);

            $table->dropUnique([
                'Transition',
                'ActionID',
            ]);

            $table->renameColumn('Transition', 'TransitionID');

            $table->dropColumn('IsActive');

            $table->text('Keterangan')
                ->nullable()
                ->after('ActionID');
        });

        Schema::table('wf_trans_action', function (Blueprint $table) {
            $table->foreign('TransitionID')
                ->references('Transition')
                ->on('wf_transition')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->unique([
                'TransitionID',
                'ActionID',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('wf_trans_action', function (Blueprint $table) {
            $table->dropForeign(['TransitionID']);

            $table->dropUnique([
                'TransitionID',
                'ActionID',
            ]);

            $table->dropColumn('Keterangan');

            $table->renameColumn('TransitionID', 'Transition');

            $table->boolean('IsActive')
                ->default(true)
                ->after('ActionID');
        });

        Schema::table('wf_trans_action', function (Blueprint $table) {
            $table->foreign('Transition')
                ->references('Transition')
                ->on('wf_transition')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->unique([
                'Transition',
                'ActionID',
            ]);
        });
    }
};
