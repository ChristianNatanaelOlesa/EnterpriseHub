<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('sc_role_menu', function (Blueprint $Table) {

            $Table->bigIncrements('RoleMenuID');

            $Table->unsignedBigInteger('RoleID');
            $Table->unsignedBigInteger('MenuID');

            $Table->boolean('CanOpen')->default(false);
            $Table->boolean('CanAdd')->default(false);
            $Table->boolean('CanEdit')->default(false);
            $Table->boolean('CanDelete')->default(false);
            $Table->boolean('CanPrint')->default(false);
            $Table->boolean('CanExport')->default(false);
            $Table->boolean('CanApprove')->default(false);

            $Table->boolean('IsActive')->default(true);

            $Table->auditColumns();

            $Table->foreign('RoleID')
                ->references('RoleID')
                ->on('Sc_Role');

            $Table->foreign('MenuID')
                ->references('MenuID')
                ->on('Sc_Menu');

            $Table->unique(['RoleID', 'MenuID']);

            $Table->index('RoleID');
            $Table->index('MenuID');
            $Table->index('IsActive');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sc_role_menu');
    }
};
