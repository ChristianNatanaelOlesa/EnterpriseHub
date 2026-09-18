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

            $table->decimal('LimitMin', 18, 2)->default(0);
            $table->decimal('LimitMax', 18, 2)->default(0);

            $table->date('EffectiveDate')->nullable();

            $table->integer('SLADays')->nullable();

            $table->boolean('IsActive')->default(true);

            $table->dateTime('InputDate')->nullable();
            $table->unsignedBigInteger('InputUser')->nullable();

            $table->dateTime('ModifDate')->nullable();
            $table->unsignedBigInteger('ModifUser')->nullable();
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
