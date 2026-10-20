<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Hanya insert jika Workflow menu sudah ada dan Approval History belum ada.
        $workflow = DB::table('sc_menu')
            ->where('Menu', 'Workflow')
            ->whereNull('ParentID')
            ->first();

        if ($workflow && ! DB::table('sc_menu')->where('Menu', 'Approval History')->where('ParentID', $workflow->MenuID)->exists()) {
            DB::table('sc_menu')->insert([
                'MenuID' => '07-02-00',
                'Menu' => 'Approval History',
                'Description' => 'Riwayat seluruh aktivitas approval yang telah dilakukan oleh user login.',
                'MenuArea' => 'TOP',
                'ParentID' => $workflow->MenuID,
                'Lvl' => 2,
                'Route' => 'workflow.approval-history',
                'Icon' => 'bi bi-clock-history',
                'SortOrder' => 2,
                'IsMenu' => true,
                'IsActive' => true,
                'InputUser' => 'System',
                'InputDate' => now(),
                'ModifUser' => 'System',
                'ModifDate' => now(),
                'DeletedBy' => null,
                'DeletedDate' => null,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('sc_menu')
            ->where('Menu', 'Approval History')
            ->where('ParentID', function ($query) {
                $query->select('MenuID')
                    ->from('sc_menu')
                    ->where('Menu', 'Workflow')
                    ->whereNull('ParentID')
                    ->limit(1);
            })
            ->delete();
    }
};
