<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('ms_parentfolder', function (Blueprint $table) {
            $table->string('ParentFolderID', 10)->primary();
            $table->string('ParentFolderName', 150)->unique();
            $table->string('ParentFolderPath', 500)->unique();
            $table->boolean('IsActive')->default(true);
            $table->dateTime('InputDate')->useCurrent();
            $table->string('InputUser', 50)->default('Admin');
            $table->dateTime('ModifDate')->useCurrent();
            $table->string('ModifUser', 50)->default('Admin');
            $table->string('DeletedBy', 50)->nullable();
            $table->dateTime('DeletedDate')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ms_parentfolder');
    }
};
