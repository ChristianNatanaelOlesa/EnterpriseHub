<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        $foreignKeys = Schema::getForeignKeys('wf_trans_action');

        $hasTransitionForeignKey = collect($foreignKeys)
            ->contains(
                fn ($foreign) =>
                    in_array('TransitionID', $foreign['columns'] ?? [])
            );

        if ($hasTransitionForeignKey) {
            Schema::table('wf_trans_action', function (Blueprint $table) {
                $table->dropForeign(['TransitionID']);
            });
        }
    }

    public function down(): void
    {
        $foreignKeys = Schema::getForeignKeys('wf_trans_action');

        $hasTransitionForeignKey = collect($foreignKeys)
            ->contains(
                fn ($foreign) =>
                    in_array('TransitionID', $foreign['columns'] ?? [])
            );

        if (! $hasTransitionForeignKey) {
            Schema::table('wf_trans_action', function (Blueprint $table) {
                $table->foreign('TransitionID')
                    ->references('Transition')
                    ->on('wf_transition')
                    ->cascadeOnUpdate()
                    ->restrictOnDelete();
            });
        }
    }
};
