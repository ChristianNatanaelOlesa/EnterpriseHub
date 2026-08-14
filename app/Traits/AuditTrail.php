<?php

namespace App\Traits;

trait AuditTrail
{
    protected static function bootAuditTrail()
    {
        static::creating(function ($model) {

            if (auth()->check()) {

                if (property_exists($model, 'auditColumns')) {

                    $model->CreatedBy = auth()->user()->UserName;
                    $model->CreatedDate = now();

                }

            }

        });

        static::updating(function ($model) {

            if (auth()->check()) {

                if (property_exists($model, 'auditColumns')) {

                    $model->UpdatedBy = auth()->user()->UserName;
                    $model->UpdatedDate = now();

                }

            }

        });

    }
}
