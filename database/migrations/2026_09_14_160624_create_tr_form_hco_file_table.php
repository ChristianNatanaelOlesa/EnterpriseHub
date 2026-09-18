<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('tr_form_hco_file', function (Blueprint $table) {

            $table->string('FormHCOFileID', 16)->primary();

            $table->string('FormHCOReqID', 13);

            $table->integer('FolderPathID');

            $table->string('UserID', 3);

            $table->date('UploadDate');

            $table->string('FileName', 500);

            $table->smallInteger('ExtID');

            $table->double('FileSize');

            $table->string('Remarks', 500);

            $table->string('GDriveID', 300);

            $table->string('UrlPath', 300);

            $table->dateTime('InputDate');

            $table->string('InputUser', 50);

            $table->dateTime('ModifDate');

            $table->string('ModifUser', 50);

            $table->index('FormHCOReqID');

            $table->index('UserID');

            $table->index('FolderPathID');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tr_form_hco_file');
    }
};
