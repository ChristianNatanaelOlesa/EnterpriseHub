<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('sc_menu', function (Blueprint $Table) {

            $Table->string('MenuID', 8)->primary();

            $Table->string('ParentID', 8)->nullable();

            $Table->unsignedTinyInteger('Lvl')->default(1);

            $Table->string('MenuArea', 5)->default('TOP');

            $Table->string('Menu', 100);

            $Table->text('Description');

            $Table->string('Icon', 100)->nullable();

            $Table->string('Route', 255)->nullable();

            $Table->integer('SortOrder')->default(0);

            $Table->boolean('IsMenu')->default(true);

            $Table->boolean('IsActive')->default(true);

            $Table->auditColumns();

            $Table->index('ParentID');
            $Table->index('IsActive');
            $Table->index('SortOrder');
            $Table->index('MenuArea');

            $Table->foreign('ParentID')
               ->references('MenuID')
               ->on('sc_menu')
               ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sc_menu');
    }
};
