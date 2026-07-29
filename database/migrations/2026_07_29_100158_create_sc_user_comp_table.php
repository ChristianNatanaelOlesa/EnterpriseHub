<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('sc_user_comp', function (Blueprint $table) {

            $table->bigIncrements('ID');

            $table->unsignedBigInteger('UserID');
            $table->unsignedBigInteger('CompanyID');

            $table->boolean('IsActive')->default(true);

            $table->auditColumns();

            $table->foreign('UserID')
                ->references('ID')
                ->on('sc_user');

            $table->foreign('CompanyID')
                ->references('ID')
                ->on('ms_company');

            $table->unique(['UserID', 'CompanyID']);

            $table->index('UserID');
            $table->index('CompanyID');
            $table->index('IsActive');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sc_user_comp');
    }
};
