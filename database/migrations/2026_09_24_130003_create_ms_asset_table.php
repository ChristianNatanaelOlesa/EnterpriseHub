<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('ms_asset', function (Blueprint $table) {
            $table->string('AssetID', 50)->primary();
            $table->string('AssTypeID', 50);
            $table->string('QRCode', 255)->unique();
            $table->text('AssetDesc');
            $table->string('Brand', 150);
            $table->string('Model', 150);
            $table->string('SerialNo', 150);
            $table->string('Color', 100);
            $table->text('Specification');
            $table->text('Notes')->default('-');
            $table->string('VendorID', 50)->nullable();
            $table->date('PurchaseDate')->nullable();
            $table->string('CcyID', 10)->default('IDR');
            $table->decimal('ExchRate', 20, 4)->default(1);
            $table->decimal('AcqCost', 20, 2)->default(0);
            $table->decimal('AcqCostIDR', 20, 2)->default(0);
            $table->boolean('IsWarranty')->default(false);
            $table->date('WarrantyDate')->default('1900-01-01');
            $table->boolean('IsISO')->default(false);
            $table->boolean('IsActive')->default(true);

            $table->auditColumns();

            $table->foreign('AssTypeID')
               ->references('AssTypeID')
               ->on('ms_asset_type');

            $table->foreign('CcyID')
                ->references('CcyID')
                ->on('ms_currency');

            $table->foreign('VendorID')
                ->references('VendorID')
                ->on('ms_vendor');

            $table->index('AssTypeID');
            $table->index('VendorID');
            $table->index('CcyID');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ms_asset');
    }
};
