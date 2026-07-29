<?php

namespace App\Support;

use Illuminate\Database\Schema\Blueprint;

class BlueprintMacros
{
    public static function register(): void
    {
        Blueprint::macro('auditColumns', function () {

            /** @var Blueprint $this */

            $this->unsignedBigInteger('CreatedBy')->nullable();
            $this->dateTime('CreatedDate')->useCurrent();

            $this->unsignedBigInteger('UpdatedBy')->nullable();
            $this->dateTime('UpdatedDate')->nullable();

            $this->unsignedBigInteger('DeletedBy')->nullable();
            $this->dateTime('DeletedDate')->nullable();
        });
    }
}
