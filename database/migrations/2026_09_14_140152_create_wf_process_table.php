<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('wf_process', function (Blueprint $table) {
            $table->string('ProcessID', 50)->primary();

            $table->string('Process', 255);

            $table->text('ProcessDesc')->nullable();

            $table->string('CcyID', 10)->nullable();

            $table->date('EffectiveDate')->nullable();

            $table->integer('SLADays')->nullable();

            $table->boolean('IsActive')->default(true);

            $table->auditColumns();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wf_process');
    }
};
