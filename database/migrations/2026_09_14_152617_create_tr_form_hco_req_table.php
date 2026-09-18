<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('tr_form_hco_req', function (Blueprint $table) {

            $table->string('FormHCOReqID', 12)->primary();

            // HCO Request Category
            $table->string('CategoryHCID', 5);

            $table->string('ReqDivID', 3)->nullable();

            $table->string('PayReqID', 18)->nullable();

            $table->string('CBTransType', 1);

            $table->string('BankID', 4);

            $table->string('RefAccNo', 50);

            $table->string('RefAccName', 500);

            $table->string('PaidTo', 500);

            $table->string('ReqUser', 50)->nullable();

            $table->date('RequestDate');

            // Emergency Flexible Allowance
            $table->string('EFAType', 200)->nullable();

            $table->string('Purpose', 500)->nullable();

            // Child Scholarship
            $table->string('Relation', 20)->nullable();

            // Glasses Replacement
            $table->string('GlassesType', 100)->nullable();

            $table->decimal('TotalCost', 18, 2)->default(0);

            // Parking Subscription
            $table->string('ParkingType', 50)->nullable();

            $table->string('PlateNo', 10)->nullable();

            // Child Scholarship
            $table->string('Name', 100)->nullable();

            $table->string('BirthPlace', 100)->nullable();

            $table->date('BirthDate');

            $table->string('Education', 50)->nullable();

            $table->string('EduLevel', 50)->nullable();

            $table->string('SchoolName', 200)->nullable();

            // Leave Extension
            $table->string('LeaveYear', 4)->nullable();

            $table->smallInteger('LeaveTotal')->nullable();

            $table->string('LeaveNote', 3000)->nullable();

            // Workflow
            $table->string('Status', 10)->nullable();

            $table->string('UserID', 3)->nullable();

            $table->string('ProcessID', 9)->nullable();

            $table->string('CurrentStateID', 11)->nullable();

            // Audit
            $table->dateTime('InputDate')->nullable();

            $table->string('InputUser', 50)->nullable();

            $table->dateTime('ModifDate')->nullable();

            $table->string('ModifUser', 50)->nullable();

            // Index
            $table->index('CategoryHCID');
            $table->index('ReqUser');
            $table->index('PayReqID');
            $table->index('UserID');
            $table->index('ProcessID');
            $table->index('CurrentStateID');
            $table->index('Status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tr_form_hco_req');
    }
};
