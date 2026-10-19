<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('sc_role', function (Blueprint $Table) {

            $Table->string('RoleID', 5)->primary();

            $Table->string('Role', 100);

            $Table->text('Description');

            $Table->boolean('IsActive')->default(true);

            $Table->auditColumns();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sc_role');
    }
};
