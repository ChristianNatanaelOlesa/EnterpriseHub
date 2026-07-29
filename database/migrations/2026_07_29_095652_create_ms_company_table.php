<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('ms_company', function (Blueprint $table) {

            $table->bigIncrements('ID');

            $table->string('CompanyCode', 20)->unique();
            $table->string('CompanyName', 200);
            $table->string('CompanyAlias', 100)->nullable();

            $table->boolean('IsActive')->default(true);

            $table->auditColumns();

            $table->index('CompanyCode');
            $table->index('CompanyName');
            $table->index('IsActive');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ms_company');
    }
};
