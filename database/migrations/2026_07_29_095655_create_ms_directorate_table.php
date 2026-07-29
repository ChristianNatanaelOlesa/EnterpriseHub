<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('ms_directorate', function (Blueprint $table) {

            $table->bigIncrements('ID');

            $table->unsignedBigInteger('CompanyID');

            $table->string('DirectorateCode', 20);
            $table->string('DirectorateName', 200);

            $table->boolean('IsActive')->default(true);

            $table->auditColumns();

            $table->foreign('CompanyID')
                ->references('ID')
                ->on('ms_company')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->unique(['CompanyID', 'DirectorateCode']);

            $table->index('CompanyID');
            $table->index('IsActive');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ms_directorate');
    }
};
