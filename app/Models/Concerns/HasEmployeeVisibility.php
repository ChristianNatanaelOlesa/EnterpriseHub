<?php

namespace App\Models\Concerns;

use App\Models\Scopes\EmployeeVisibilityScope;

trait HasEmployeeVisibility
{
    protected static function bootHasEmployeeVisibility(): void
    {
        static::addGlobalScope(
            new EmployeeVisibilityScope()
        );
    }
}
