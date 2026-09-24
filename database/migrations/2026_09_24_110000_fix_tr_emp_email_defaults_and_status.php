<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('Tr_EmpEmail')) {
            return;
        }

        // Normalize existing NULL/legacy values first.
        DB::table('Tr_EmpEmail')->whereNull('Notes')->update(['Notes' => '-']);
        DB::table('Tr_EmpEmail')->whereNull('CocID')->update(['CocID' => 'COC003']);
        DB::table('Tr_EmpEmail')->whereNull('QRAppCoc')->update(['QRAppCoc' => '-']);
        DB::table('Tr_EmpEmail')->whereNull('GivenNote')->update(['GivenNote' => '-']);
        DB::table('Tr_EmpEmail')->whereNull('TakeOutNote')->update(['TakeOutNote' => '-']);
        DB::table('Tr_EmpEmail')->where('Status', '-')->orWhereNull('Status')->update(['Status' => 'DRAFT']);

        // Keep new transaction records consistent with the four workflow statuses.
        DB::statement("ALTER TABLE `Tr_EmpEmail` MODIFY `Notes` TEXT NOT NULL DEFAULT '-'");
        DB::statement("ALTER TABLE `Tr_EmpEmail` MODIFY `CocID` VARCHAR(6) NOT NULL DEFAULT 'COC003'");
        DB::statement("ALTER TABLE `Tr_EmpEmail` MODIFY `QRAppCoc` VARCHAR(200) NOT NULL DEFAULT '-'");
        DB::statement("ALTER TABLE `Tr_EmpEmail` MODIFY `GivenNote` TEXT NOT NULL DEFAULT '-'");
        DB::statement("ALTER TABLE `Tr_EmpEmail` MODIFY `TakeOutNote` TEXT NOT NULL DEFAULT '-'");
        DB::statement("ALTER TABLE `Tr_EmpEmail` MODIFY `Status` VARCHAR(10) NOT NULL DEFAULT 'DRAFT'");
    }

    public function down(): void
    {
        if (!Schema::hasTable('Tr_EmpEmail')) {
            return;
        }

        DB::statement("ALTER TABLE `Tr_EmpEmail` MODIFY `Notes` TEXT NULL");
        DB::statement("ALTER TABLE `Tr_EmpEmail` MODIFY `CocID` VARCHAR(6) NULL");
        DB::statement("ALTER TABLE `Tr_EmpEmail` MODIFY `QRAppCoc` VARCHAR(200) NULL");
        DB::statement("ALTER TABLE `Tr_EmpEmail` MODIFY `GivenNote` TEXT NULL");
        DB::statement("ALTER TABLE `Tr_EmpEmail` MODIFY `TakeOutNote` TEXT NULL");
        DB::statement("ALTER TABLE `Tr_EmpEmail` MODIFY `Status` VARCHAR(10) NOT NULL DEFAULT '-'");
    }
};
