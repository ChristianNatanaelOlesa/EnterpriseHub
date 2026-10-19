<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('wf_approval_rule', function (Blueprint $table) {
            $table->bigIncrements('ApprovalRuleID');
            $table->string('ProcessID', 50);
            $table->string('RuleCode', 50);
            $table->string('RuleName', 255);
            $table->string('ConditionType', 50);
            $table->string('ConditionValue', 100)->nullable();
            $table->unsignedInteger('Priority')->default(1);
            $table->string('RevisionMode', 50)->default('RETURN_TO_REVISION_APPROVER');
            $table->date('EffectiveDate')->nullable();
            $table->boolean('IsActive')->default(true);
            $table->auditColumns();

            $table->foreign('ProcessID')
                ->references('ProcessID')->on('wf_process')
                ->cascadeOnUpdate()->cascadeOnDelete();
            $table->unique(['ProcessID', 'RuleCode']);
            $table->index(['ProcessID', 'IsActive', 'Priority']);
        });

        Schema::create('wf_approval_step', function (Blueprint $table) {
            $table->bigIncrements('ApprovalStepID');
            $table->unsignedBigInteger('ApprovalRuleID');
            $table->unsignedInteger('StepNo');
            $table->string('StepCode', 100);
            $table->string('StepName', 255);
            $table->string('ResolverType', 100);
            $table->json('ResolverConfig')->nullable();
            $table->boolean('IsMandatory')->default(true);
            $table->boolean('AllowSelfSkip')->default(false);
            $table->unsignedInteger('SLADays')->nullable();
            $table->boolean('IsActive')->default(true);
            $table->auditColumns();

            $table->foreign('ApprovalRuleID')
                ->references('ApprovalRuleID')->on('wf_approval_rule')
                ->cascadeOnUpdate()->cascadeOnDelete();
            $table->unique(['ApprovalRuleID', 'StepNo']);
            $table->index(['ApprovalRuleID', 'IsActive']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wf_approval_step');
        Schema::dropIfExists('wf_approval_rule');
    }
};
