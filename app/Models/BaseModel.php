<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    public $timestamps = false;

    protected static function booted(): void
    {
        static::creating(function ($model) {

            if (auth()->check()) {

                $userId = auth()->user()->UserID;

                if (empty($model->CreatedBy)) {
                    $model->CreatedBy = $userId;
                }
            }

            if (empty($model->CreatedDate)) {
                $model->CreatedDate = now();
            }
        });

        static::updating(function ($model) {

            if (auth()->check()) {

                $model->UpdatedBy = auth()->user()->UserID;
            }

            $model->UpdatedDate = now();
        });
    }
}
