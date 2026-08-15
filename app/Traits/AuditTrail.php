<?php

namespace App\Traits;

trait AuditTrail
{
    protected static function bootAuditTrail(): void
    {
        static::creating(function ($model) {

            if (! auth()->check()) {
                return;
            }

            if (! $model->auditColumns) {
                return;
            }

            $userId = auth()->user()->UserID;

            $model->CreatedBy = $userId;
            $model->CreatedDate = now();

        });

        static::updating(function ($model) {

            if (! auth()->check()) {
                return;
            }

            if (! $model->auditColumns) {
                return;
            }

            $userId = auth()->user()->UserID;

            $model->UpdatedBy = $userId;
            $model->UpdatedDate = now();

        });
    }
}
