<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('ms_vendor', function (Blueprint $table) {
            $table->string('VendorID', 50)->primary();
            $table->string('Vendor', 200);
            $table->text('Description');
            $table->string('Address', 500)->nullable();
            $table->string('ContactPerson', 150)->nullable();
            $table->string('Phone', 50)->nullable();
            $table->string('Email', 150)->nullable();
            $table->boolean('IsActive')->default(true);
            $table->auditColumns();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ms_vendor');
    }
};
