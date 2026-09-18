<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('wf_group_member', function (Blueprint $table) {
            $table->id('GroupMemberID');

            $table->string('GroupID', 50);

            $table->string('UserID', 50);

            $table->boolean('IsActive')->default(true);

            $table->boolean('IsDefault')->default(false);

            $table->dateTime('InputDate')->nullable();
            $table->string('InputUser', 100)->nullable();

            $table->dateTime('ModifDate')->nullable();
            $table->string('ModifUser', 100)->nullable();

            $table->foreign('GroupID')
                ->references('GroupID')
                ->on('wf_group')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->index('UserID');
            $table->index(['GroupID', 'UserID']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wf_group_member');
    }
};
