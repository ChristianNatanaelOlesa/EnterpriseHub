<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        $indexes = Schema::getIndexes('wf_transition');

        $hasPrimary = collect($indexes)
            ->contains(fn ($index) => $index['name'] === 'PRIMARY');

        $hasUnique = collect($indexes)
            ->contains(
                fn ($index) =>
                    $index['name'] === 'wf_transition_process_state_unique'
            );

        if ($hasPrimary) {
            Schema::table('wf_transition', function (Blueprint $table) {
                $table->dropPrimary();
            });
        }

        if (! $hasUnique) {
            Schema::table('wf_transition', function (Blueprint $table) {
                $table->unique(
                    [
                        'ProcessID',
                        'CurrentStateID',
                        'NextStateID',
                    ],
                    'wf_transition_process_state_unique'
                );
            });
        }
    }

    public function down(): void
    {
        $indexes = Schema::getIndexes('wf_transition');

        $hasUnique = collect($indexes)
            ->contains(
                fn ($index) =>
                    $index['name'] === 'wf_transition_process_state_unique'
            );

        $hasPrimary = collect($indexes)
            ->contains(fn ($index) => $index['name'] === 'PRIMARY');

        if ($hasUnique) {
            Schema::table('wf_transition', function (Blueprint $table) {
                $table->dropUnique(
                    'wf_transition_process_state_unique'
                );
            });
        }

        if (! $hasPrimary) {
            Schema::table('wf_transition', function (Blueprint $table) {
                $table->primary('Transition');
            });
        }
    }
};
