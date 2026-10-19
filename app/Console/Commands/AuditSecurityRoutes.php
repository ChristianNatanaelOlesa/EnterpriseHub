<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Route;

class AuditSecurityRoutes extends Command
{
    protected $signature = 'security:audit-routes {--all : Include public routes and routes already protected by permission middleware}';

    protected $description = 'Audit route authentication, permission middleware, and Security menu registration.';

    /**
     * Routes intentionally authorized inside their controller rather than by
     * a generic menu permission. Keep this list small and review it whenever
     * those controller methods change.
     */
    private const CONTROLLER_AUTHORIZED_ROUTES = [
        'workflow.detail' => 'Requester/workflow-participant check in WorkflowController::detail',
        'workflow.detail-modal' => 'Requester/workflow-participant check in WorkflowController::detailModal',
        'workflow.request-approval' => 'Transaction permission and requester check in WorkflowController::requestApproval',
    ];

    private const AUTH_ONLY_ROUTES = [
        'logout' => 'Authenticated session logout does not require a business permission',
    ];

    public function handle(): int
    {
        $registeredPages = DB::table('sc_menu')
            ->whereNotNull('Route')->where('IsActive', true)->whereNull('DeletedDate')
            ->pluck('Route')->map(fn ($name) => (string) $name)->all();

        $rows = [];
        $reviewCount = 0;
        $controllerGuardCount = 0;
        $permissionCount = 0;
        $unregisteredCount = 0;

        foreach (app('router')->getRoutes() as $route) {
            /** @var Route $route */
            $name = $route->getName() ?: '(unnamed)';
            $methods = implode('|', array_diff($route->methods(), ['HEAD', 'OPTIONS']));
            $middleware = $route->gatherMiddleware();

            $hasAuth = collect($middleware)->contains(function (string $item): bool {
                return $item === 'auth'
                    || str_contains($item, 'Illuminate\\Auth\\Middleware\\Authenticate');
            });

            $permissionMiddleware = collect($middleware)
                ->filter(function (string $item): bool {
                    return str_starts_with($item, 'permission:')
                        || str_contains($item, 'App\\Http\\Middleware\\CheckPermission');
                })
                ->values();

            $hasPermission = $permissionMiddleware->isNotEmpty();

            if (! $this->option('all') && ! $hasAuth && ! $hasPermission) {
                continue;
            }

            $pageStatus = '-';
            if ($hasPermission) {
                $permissionTargets = $this->permissionRouteTargets($permissionMiddleware->all());

                if ($permissionTargets === []) {
                    // Custom CheckPermission middleware may not expose a route target
                    // in the same format as the "permission:route,operation" alias.
                    $pageStatus = 'VERIFY MIDDLEWARE TARGET';
                    $unregisteredCount++;
                } else {
                    $registeredTargets = array_values(array_filter(
                        $permissionTargets,
                        fn (string $target): bool => in_array($target, $registeredPages, true)
                    ));

                    if ($registeredTargets !== []) {
                        $pageStatus = 'REGISTERED VIA '.implode(', ', array_unique($registeredTargets));
                    } else {
                        $pageStatus = 'UNREGISTERED MENU — FAIL CLOSED (target: '.implode(', ', array_unique($permissionTargets)).')';
                        $unregisteredCount++;
                    }
                }
            }

            if ($hasPermission) {
                $status = 'PERMISSION MIDDLEWARE';
                $permissionCount++;
            } elseif (isset(self::CONTROLLER_AUTHORIZED_ROUTES[$name])) {
                $status = 'CONTROLLER GUARD - VERIFY';
                $pageStatus = self::CONTROLLER_AUTHORIZED_ROUTES[$name];
                $controllerGuardCount++;
            } elseif (isset(self::AUTH_ONLY_ROUTES[$name])) {
                $status = 'AUTH-ONLY EXEMPT';
                $pageStatus = self::AUTH_ONLY_ROUTES[$name];
            } elseif ($hasAuth) {
                $status = 'REVIEW: NO PERMISSION MIDDLEWARE';
                $reviewCount++;
            } else {
                $status = 'PUBLIC / GUEST';
            }

            $rows[] = [$status, $methods, $route->uri(), $name, $pageStatus];
        }

        $this->table(['Status', 'Method', 'URI', 'Route name', 'Page mapping / rationale'], $rows);

        $this->newLine();
        $this->line('Routes with permission middleware: '.$permissionCount);
        $this->line('Controller-guarded routes requiring code review: '.$controllerGuardCount);
        $this->line('Authenticated routes needing permission review: '.$reviewCount);
        $this->line('Permission routes with unregistered targets / requiring verification: '.$unregisteredCount);

        if ($reviewCount > 0) {
            $this->warn('Review each REVIEW row. Do not add generic permission middleware blindly; determine the correct business permission first.');
        } else {
            $this->info('No authenticated routes without permission middleware were detected outside the explicit exemptions.');
        }

        if ($unregisteredCount > 0) {
            $this->comment('UNREGISTERED MENU means the permission target could not be matched to an active sc_menu.Route. Authorization fails closed; this command does not change permission data.');
        }

        return self::SUCCESS;
    }

    /**
     * Extract the route name referenced by permission middleware.
     *
     * Example:
     * permission:employee-email.index,Create
     * maps employee-email.create to employee-email.index.
     *
     * If multiple permission middleware entries exist, collect all targets.
     *
     * @param array<int, string> $middleware
     * @return array<int, string>
     */
    private function permissionRouteTargets(array $middleware): array
    {
        $targets = [];

        foreach ($middleware as $item) {
            if (str_starts_with($item, 'permission:')) {
                $arguments = substr($item, strlen('permission:'));
                $parts = array_map('trim', explode(',', $arguments));
                $target = $parts[0] ?? '';

                if ($target !== '') {
                    $targets[] = $target;
                }

                continue;
            }

            // For a custom middleware class/alias, do not assume the current route
            // name is its permission target. Without an explicit target, flag it.
        }

        return array_values(array_unique($targets));
    }
}
