<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('sc_user_dir', function (Blueprint $table) {

            $table->bigIncrements('UserDirID');

            $table->unsignedBigInteger('UserID');
            $table->unsignedBigInteger('DirectorateID');

            $table->boolean('IsActive')->default(true);

            $table->string('InputUser', 50)->nullable();
            $table->dateTime('InputDate')->useCurrent();

            $table->string('ModifUser', 50)->nullable();
            $table->dateTime('ModifDate')->nullable();

            $table->string('DeletedBy', 50)->nullable();
            $table->dateTime('DeletedDate')->nullable();

            $table->foreign('UserID')
                ->references('UserID')
                ->on('sc_user');

            $table->foreign('DirectorateID')
                ->references('DirectorateID')
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
