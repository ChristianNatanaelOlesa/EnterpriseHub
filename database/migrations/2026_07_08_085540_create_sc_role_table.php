<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('sc_role', function (Blueprint $Table) {

            $Table->id('RoleID');

            $Table->string('Code', 30)->unique();

            $Table->string('Name', 100);

            $Table->string('Description', 255)->nullable();

            $Table->boolean('IsActive')->default(true);

            $Table->auditColumns();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sc_role');
    }
};
