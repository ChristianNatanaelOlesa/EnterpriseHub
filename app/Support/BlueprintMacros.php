<?php

namespace App\Support;

use Illuminate\Database\Schema\Blueprint;

class BlueprintMacros
{
    public static function register(): void
    {
        Blueprint::macro('auditColumns', function () {
            /** @var Blueprint $this */

            $this->dateTime('InputDate')->useCurrent();
            $this->string('InputUser', 50)->default('Admin');

            $this->dateTime('ModifDate')->useCurrent();
            $this->string('ModifUser', 50)->default('Admin');

            $this->string('DeletedBy', 50)->nullable();
            $this->dateTime('DeletedDate')->nullable();
        });
    }
}
