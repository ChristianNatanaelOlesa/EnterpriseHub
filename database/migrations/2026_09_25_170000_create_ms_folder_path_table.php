<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Ms_FolderPath', function (Blueprint $table) {
            $table->string('FolderPathID', 10)->primary();
            $table->string('FolderName', 150);
            $table->string('FolderPath', 500)->unique();
            $table->string('ParentFolderPathID', 10)->nullable();

            $table->boolean('IsActive')->default(true);

            $table->dateTime('InputDate')->useCurrent();
            $table->string('InputUser', 50)->default('Admin');
            $table->dateTime('ModifDate')->useCurrent();
            $table->string('ModifUser', 50)->default('Admin');

            $table->string('DeletedBy', 50)->nullable();
            $table->dateTime('DeletedDate')->nullable();

            $table->index('ParentFolderPathID');

            $table->foreign('ParentFolderPathID')
                ->references('FolderPathID')
                ->on('Ms_FolderPath')
                ->nullOnDelete()
                ->cascadeOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Ms_FolderPath');
    }
};
