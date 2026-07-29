<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('sc_user_role', function (Blueprint $table) {

            $table->bigIncrements('ID');

            $table->unsignedBigInteger('UserID');
            $table->unsignedBigInteger('RoleID');

            $table->boolean('IsActive')->default(true);

            $table->auditColumns();

            $table->foreign('UserID')
                ->references('ID')
                ->on('sc_user');

            $table->foreign('RoleID')
                ->references('ID')
                ->on('sc_role');

            $table->unique(['UserID', 'RoleID']);

            $table->index('UserID');
            $table->index('RoleID');
            $table->index('IsActive');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sc_user_role');
    }
};
