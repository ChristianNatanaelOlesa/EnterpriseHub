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
                if (empty($model->InputUser)) {
                    $model->InputUser = auth()->user()->Username;
                }
            }

            if (empty($model->InputDate)) {
                $model->InputDate = now();
            }
        });

        static::updating(function ($model) {
            if (auth()->check()) {
                $model->ModifUser = auth()->user()->Username;
            }

            $model->ModifDate = now();
        });
    }
}
