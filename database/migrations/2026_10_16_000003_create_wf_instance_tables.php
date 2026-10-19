<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('wf_instance', function (Blueprint $table) {
            $table->uuid('WorkflowInstanceID')->primary();
            $table->string('ProcessID', 50);
            $table->unsignedBigInteger('ApprovalRuleID');
            $table->string('Module', 100);
            $table->string('TransactionID', 100);
            $table->unsignedBigInteger('RequesterUserID');
            $table->string('RequesterEmpFormID', 30)->nullable();
            $table->string('TargetEmpFormID', 30)->nullable();
            $table->unsignedInteger('CurrentStepNo')->nullable();
            $table->string('Status', 50);
            $table->unsignedInteger('RevisionNo')->default(0);
            $table->dateTime('StartedAt')->nullable();
            $table->dateTime('CompletedAt')->nullable();
            $table->auditColumns();

            $table->foreign('ProcessID')
                ->references('ProcessID')->on('wf_process')
                ->cascadeOnUpdate();
            $table->foreign('ApprovalRuleID')
                ->references('ApprovalRuleID')->on('wf_approval_rule')
                ->cascadeOnUpdate();
            $table->foreign('RequesterUserID')
                ->references('UserID')->on('sc_user')
                ->cascadeOnUpdate();
            $table->index(['Module', 'TransactionID']);
            $table->index(['RequesterUserID', 'Status']);
        });

        Schema::create('wf_instance_step', function (Blueprint $table) {
            $table->bigIncrements('WorkflowInstanceStepID');
            $table->uuid('WorkflowInstanceID');
            $table->unsignedBigInteger('ApprovalStepID')->nullable();
            $table->unsignedInteger('RevisionNo')->default(0);
            $table->unsignedInteger('StepNo');
            $table->string('StepCode', 100);
            $table->string('StepName', 255);
            $table->string('ResolverType', 100);
            $table->json('ResolverConfig')->nullable();
            $table->unsignedBigInteger('ApproverUserID')->nullable();
            $table->string('ApproverEmpFormID', 30)->nullable();
            $table->string('Status', 50);
            $table->string('Action', 50)->nullable();
            $table->text('Comments')->nullable();
            $table->dateTime('DueDate')->nullable();
            $table->dateTime('StartedAt')->nullable();
            $table->dateTime('CompletedAt')->nullable();
            $table->boolean('IsSkipped')->default(false);
            $table->string('SkipReason', 255)->nullable();
            $table->auditColumns();

            $table->foreign('WorkflowInstanceID')
                ->references('WorkflowInstanceID')->on('wf_instance')
                ->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('ApprovalStepID')
                ->references('ApprovalStepID')->on('wf_approval_step')
                ->nullOnDelete();
            $table->foreign('ApproverUserID')
                ->references('UserID')->on('sc_user')
                ->nullOnDelete();
            $table->unique(['WorkflowInstanceID', 'RevisionNo', 'StepNo']);
            $table->index(['Status', 'ApproverUserID']);
            $table->index(['WorkflowInstanceID', 'RevisionNo', 'Status']);
        });

        Schema::create('wf_instance_revision', function (Blueprint $table) {
            $table->bigIncrements('WorkflowRevisionID');
            $table->uuid('WorkflowInstanceID');
            $table->unsignedInteger('RevisionNo');
            $table->unsignedBigInteger('RequestedByUserID');
            $table->dateTime('RequestedAt');
            $table->string('RevisionTargetType', 50);
            $table->unsignedBigInteger('RevisionTargetUserID')->nullable();
            $table->unsignedInteger('RevisionStepNo')->nullable();
            $table->text('Reason');
            $table->dateTime('ResolvedAt')->nullable();
            $table->auditColumns();

            $table->foreign('WorkflowInstanceID')
                ->references('WorkflowInstanceID')->on('wf_instance')
                ->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('RequestedByUserID')
                ->references('UserID')->on('sc_user')
                ->cascadeOnUpdate();
            $table->foreign('RevisionTargetUserID')
                ->references('UserID')->on('sc_user')
                ->nullOnDelete();
            $table->unique(['WorkflowInstanceID', 'RevisionNo']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wf_instance_revision');
        Schema::dropIfExists('wf_instance_step');
        Schema::dropIfExists('wf_instance');
    }
};
