<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('tr_empnetwork', function (Blueprint $table) {
            $table->string('EmpNetworkID', 13)->primary();
            $table->string('EmpFormID', 13);
            $table->date('ReqDate');

            $table->string('ReqType', 30)->default('Permanent');
            $table->date('DateFrom');
            $table->date('DateUntil')->default('1900-01-01');

            // INTERNET
            $table->boolean('InternetAccess')->default(false);
            $table->string('InternetCocID', 6)->nullable();
            $table->boolean('InternetIsConfirm')->default(false);
            $table->string('InternetQRAppCoc', 300)->nullable();

            // WLAN
            $table->boolean('WLANAccess')->default(false);
            $table->string('WLANCocID', 6)->nullable();
            $table->boolean('WLANIsConfirm')->default(false);
            $table->string('WLANQRAppCoc', 300)->nullable();

            // VPN
            $table->boolean('VPNAccess')->default(false);
            $table->string('VPNCocID', 6)->nullable();
            $table->boolean('VPNIsConfirm')->default(false);
            $table->string('VPNQRAppCoc', 300)->nullable();

            $table->string('Purpose', 3000)->default('Kebutuhan Pekerjaan');
            $table->string('Notes', 1000)->default('-');

            $table->boolean('IsGiven')->default(false);
            $table->date('GivenDate')->default('1900-01-01');
            $table->string('GivenNote', 1000)->default('-');

            $table->boolean('IsTakeOut')->default(false);
            $table->date('TakeOutDate')->default('1900-01-01');
            $table->string('TakeOutNote', 1000)->default('-');

            $table->string('Status', 30)->default('DRAFT');

            $table->string('InputUser', 50)->default('Admin');
            $table->dateTime('InputDate')->useCurrent();
            $table->string('ModifUser', 50)->default('Admin');
            $table->dateTime('ModifDate')->useCurrent();

            $table->foreign('EmpFormID')
                ->references('EmpFormID')
                ->on('tr_empform')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->index('EmpFormID');
            $table->index('Status');
            $table->index('ReqType');
            $table->index('DateFrom');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tr_empnetwork');
    }
};
