<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('sc_login_log', function (Blueprint $table) {

            $table->bigIncrements('ID');

            $table->unsignedBigInteger('UserID');

            $table->string('IPAddress', 45);

            $table->string('Browser', 100)->nullable();

            $table->string('Platform', 100)->nullable();

            $table->dateTime('LoginDate')->useCurrent();

            $table->dateTime('LogoutDate')->nullable();

            $table->boolean('IsSuccess')->default(true);

            $table->text('Remarks')->nullable();

            $table->auditColumns();

            $table->foreign('UserID')
                ->references('ID')
                ->on('sc_user');

            $table->index('UserID');
            $table->index('LoginDate');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sc_login_log');
    }
};
