<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('tr_empequip')) {
            return;
        }

        Schema::create('tr_empequip', function (Blueprint $table) {
            $table->string('EmpEquipID', 13)->primary();
            $table->string('EmpFormID', 13);
            $table->date('ReqDate');

            $table->string('AssetID', 50);

            $table->string('ReqType', 20)->default('Permanent');
            $table->date('DateFrom');
            $table->date('DateUntil')->default('1900-01-01');

            $table->string('Purpose', 3000);
            $table->text('Notes');

            $table->boolean('IsGiven')->default(false);
            $table->date('GivenDate')->default('1900-01-01');
            $table->string('GivenNote', 1000)->default('-');

            $table->boolean('IsReturn')->default(false);
            $table->date('ReturnDate')->default('1900-01-01');
            $table->string('ReturnNote', 1000)->default('-');

            $table->string('CocID', 6)->default('COC001');
            $table->boolean('IsConfirm')->default(false);
            $table->string('QRAppCoc', 200)->default('-');

            $table->string('Status', 20)->default('DRAFT');

            $table->string('InputUser', 50)->default('Admin');
            $table->dateTime('InputDate')->useCurrent();
            $table->string('ModifUser', 50)->default('Admin');
            $table->dateTime('ModifDate')->useCurrent();

            $table->index('EmpFormID');
            $table->index('AssetID');
            $table->index('DateFrom');
            $table->index('Status');

            $table->foreign('EmpFormID')
                ->references('EmpFormID')
                ->on('tr_empform')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('AssetID')
                ->references('AssetID')
                ->on('ms_asset')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

        });
    }
    public function down(): void
    {
        Schema::dropIfExists('tr_empequip');
    }
};
