<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('sc_user_dir', function (Blueprint $table) {

            $table->bigIncrements('ID');

            $table->unsignedBigInteger('UserID');
            $table->unsignedBigInteger('DirectorateID');

            $table->boolean('IsActive')->default(true);

            $table->unsignedBigInteger('CreatedBy')->nullable();
            $table->dateTime('CreatedDate')->useCurrent();

            $table->unsignedBigInteger('UpdatedBy')->nullable();
            $table->dateTime('UpdatedDate')->nullable();

            $table->unsignedBigInteger('DeletedBy')->nullable();
            $table->dateTime('DeletedDate')->nullable();

            $table->foreign('UserID')
                ->references('ID')
                ->on('sc_user');

            $table->foreign('DirectorateID')
                ->references('ID')
                ->on('ms_directorate');

            $table->unique(['UserID', 'DirectorateID']);

            $table->index('UserID');
            $table->index('DirectorateID');
            $table->index('IsActive');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sc_user_dir');
    }
};
