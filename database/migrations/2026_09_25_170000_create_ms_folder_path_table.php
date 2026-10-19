<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('ms_folderpath', function (Blueprint $table) {
            $table->string('FolderPathID', 10)->primary();
            $table->string('FolderName', 150);
            $table->string('FolderPath', 500)->unique();
            $table->string('ParentFolderID', 10)->nullable();

            $table->boolean('IsActive')->default(true);

            $table->dateTime('InputDate')->useCurrent();
            $table->string('InputUser', 50)->default('Admin');
            $table->dateTime('ModifDate')->useCurrent();
            $table->string('ModifUser', 50)->default('Admin');

            $table->string('DeletedBy', 50)->nullable();
            $table->dateTime('DeletedDate')->nullable();

            $table->index('ParentFolderID', 'ms_folderpath_parentfolderid_index');

            $table->foreign('ParentFolderID', 'ms_folderpath_parentfolderid_foreign')
                ->references('ParentFolderID')
                ->on('ms_parentfolder')
                ->nullOnDelete()
                ->cascadeOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ms_folderpath');
    }
};
