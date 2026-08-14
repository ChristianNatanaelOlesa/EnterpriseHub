<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('sc_user_div', function (Blueprint $table) {

            $table->bigIncrements('UserDivID');

            $table->unsignedBigInteger('UserID');
            $table->unsignedBigInteger('DivisionID');

            $table->boolean('IsActive')->default(true);

            $table->auditColumns();

            $table->foreign('UserID')
                ->references('UserID')
                ->on('sc_user');

            $table->foreign('DivisionID')
                ->references('DivisionID')
                ->on('ms_division');

            $table->unique(['UserID', 'DivisionID']);

            $table->index('UserID');
            $table->index('DivisionID');
            $table->index('IsActive');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sc_user_div');
    }
};
