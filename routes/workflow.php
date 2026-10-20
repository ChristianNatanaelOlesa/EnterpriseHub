<?php

use App\Http\Controllers\WorkflowController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('workflow')->group(function () {
    Route::get('/', [WorkflowController::class, 'index'])
        ->middleware('permission:workflow.index,View')
        ->name('workflow.index');

    // My Approval detail: requires the My Approval menu permission.
    Route::get('/{instance}', [WorkflowController::class, 'show'])
        ->middleware('permission:workflow.index,View')
        ->name('workflow.show');

    // Approval History: seluruh aktivitas approval yang pernah dilakukan oleh user login.
    Route::get('/approval-history', [WorkflowController::class, 'approvalHistory'])
        ->middleware('permission:workflow.index,View')
        ->name('workflow.approval-history');

    // Read-only transaction detail for requesters and workflow participants.
    // Authorization is performed inside WorkflowController@detail().
    Route::get('/detail/{instance}', [WorkflowController::class, 'detail'])
        ->name('workflow.detail');

    // Read-only transaction detail fragment used by list-page modals.
    // Authorization is performed inside WorkflowController@detailModal().
    Route::get('/detail-modal/{instance}', [WorkflowController::class, 'detailModal'])
        ->name('workflow.detail-modal');

    Route::post('/{instance}/approve', [WorkflowController::class, 'approve'])
        ->middleware('permission:workflow.index,Approve')
        ->name('workflow.approve');

    Route::post('/{instance}/revision', [WorkflowController::class, 'revision'])
        ->middleware('permission:workflow.index,Approve')
        ->name('workflow.revision');

    Route::post('/{instance}/reject', [WorkflowController::class, 'reject'])
        ->middleware('permission:workflow.index,Approve')
        ->name('workflow.reject');

    // Request Approval is authorized against the underlying transaction
    // permission (Update), not the My Approval menu permission.
    Route::post('/request-approval', [WorkflowController::class, 'requestApproval'])
        ->name('workflow.request-approval');

    Route::post('/{instance}/cancel', [WorkflowController::class, 'cancel'])
        ->middleware('permission:employee-email.index,Update')
        ->name('workflow.cancel');
});
