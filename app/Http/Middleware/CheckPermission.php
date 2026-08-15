<?php

namespace App\Http\Middleware;

use App\Support\Permission;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    public function handle(
        Request $request,
        Closure $next,
        string $routeName,
        string $permission = 'CanOpen'
    ): Response {
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        if (! Permission::can($permission, $routeName)) {
            abort(
                Response::HTTP_FORBIDDEN,
                'You do not have permission to access this resource.'
            );
        }

        return $next($request);
    }
}
