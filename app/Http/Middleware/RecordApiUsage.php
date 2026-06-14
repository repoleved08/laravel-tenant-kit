<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use App\Services\UsageMeter;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RecordApiUsage
{
    public function __construct(private UsageMeter $usageMeter) {}

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (! config('usage.enabled') || ! $request->user() || $response->getStatusCode() >= 400) {
            return $response;
        }

        $tenant = $this->resolveTenant($request);

        if ($tenant instanceof Tenant) {
            $this->usageMeter->record($tenant, 'api_calls');
        }

        return $response;
    }

    private function resolveTenant(Request $request): ?Tenant
    {
        if (tenancy()->initialized) {
            $tenant = tenant();

            return $tenant instanceof Tenant ? $tenant : null;
        }

        $routeTenant = $request->route('tenant');

        return $routeTenant instanceof Tenant ? $routeTenant : null;
    }
}
