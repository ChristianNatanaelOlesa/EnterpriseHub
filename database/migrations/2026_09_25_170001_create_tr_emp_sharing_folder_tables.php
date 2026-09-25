<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Tr_EmpSharingFolder', function (Blueprint $table) {
            $table->string('EmpSharingFolderID', 13)->primary();
            $table->string('EmpFormID', 13);
            $table->unsignedBigInteger('ReqDivID')->nullable();
            $table->string('ReqUser', 50);
            $table->date('ReqDate');
            $table->string('ReqType', 20)->default('Permanent');
            $table->date('DateFrom');
            $table->date('DateUntil');

            $table->string('FolderRequestType', 20);
            $table->text('Purpose');
            $table->string('Notes', 1000)->default('-');

            $table->string('CocID', 20)->default('COC006');
            $table->boolean('IsConfirm')->default(false);
            $table->string('QRAppCoc', 255)->default('-');
            $table->boolean('IsGiven')->default(false);
            $table->date('GivenDate')->default('1900-01-01');
            $table->string('GivenNote', 1000)->default('-');
            $table->boolean('IsTakeOut')->default(false);
            $table->date('TakeOutDate')->default('1900-01-01');
            $table->string('TakeOutNote', 1000)->default('-');

            $table->string('Status', 30)->default('DRAFT');

            $table->string('InputUser', 50)->default('Admin');
            $table->dateTime('InputDate')->useCurrent();
            $table->string('ModifUser', 50)->default('Admin');
            $table->dateTime('ModifDate')->useCurrent();

            $table->index('EmpFormID');
            $table->index('ReqDivID');
            $table->index('Status');

            $table->foreign('EmpFormID')
                ->references('EmpFormID')
                ->on('Tr_EmpForm')
                ->cascadeOnUpdate();

            $table->foreign('ReqDivID')
                ->references('DivisionID')
                ->on('Ms_Division')
                ->nullOnDelete()
                ->cascadeOnUpdate();
        });

        Schema::create('Tr_EmpSharingFolderDetail', function (Blueprint $table) {
            $table->bigIncrements('EmpSharingFolderDetailID');
            $table->string('EmpSharingFolderID', 13);
            $table->string('FolderPathID', 10)->nullable();
            $table->string('ParentFolderPathID', 10)->nullable();
            $table->string('FolderName', 150)->nullable();
            $table->string('RequestedPath', 500)->nullable();
            $table->string('AccessType', 20)->default('Read');

            $table->dateTime('InputDate')->useCurrent();
            $table->string('InputUser', 50)->default('Admin');
            $table->dateTime('ModifDate')->useCurrent();
            $table->string('ModifUser', 50)->default('Admin');

            $table->index('EmpSharingFolderID');
            $table->index('FolderPathID');

            $table->foreign('EmpSharingFolderID')
                ->references('EmpSharingFolderID')
                ->on('Tr_EmpSharingFolder')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('FolderPathID')
                ->references('FolderPathID')
                ->on('Ms_FolderPath')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('ParentFolderPathID')
                ->references('FolderPathID')
                ->on('Ms_FolderPath')
                ->nullOnDelete()
                ->cascadeOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Tr_EmpSharingFolderDetail');
        Schema::dropIfExists('Tr_EmpSharingFolder');
    }
};
