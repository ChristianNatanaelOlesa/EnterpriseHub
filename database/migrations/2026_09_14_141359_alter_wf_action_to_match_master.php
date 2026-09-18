<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('wf_action', function (Blueprint $table) {
            $table->text('Keterangan')
                ->nullable()
                ->after('ActionID');

            $table->string('ActionTypeID', 20)
                ->nullable()
                ->after('ProcessID');

            $table->renameColumn('ActionName', 'Action');

            $table->text('ActionDesc')
                ->nullable()
                ->after('Action');
        });
    }

    public function down(): void
    {
        Schema::table('wf_action', function (Blueprint $table) {
            $table->dropColumn([
                'Keterangan',
                'ActionTypeID',
                'ActionDesc',
            ]);

            $table->renameColumn('Action', 'ActionName');
        });
    }
};
