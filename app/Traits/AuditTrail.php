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

            $username = auth()->user()->Username;

            $model->InputUser = $username;
            $model->InputDate = now();
        });

        static::updating(function ($model) {
            if (! auth()->check()) {
                return;
            }

            $username = auth()->user()->Username;

            $model->ModifUser = $username;
            $model->ModifDate = now();
        });
    }
}
