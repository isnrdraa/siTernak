<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use App\Services\TenantManager;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ResolveTenant
{
    public function __construct(private TenantManager $tenantManager) {}

    public function handle(Request $request, Closure $next): Response
    {
        $tenantId = session('current_tenant_id');

        if (! $tenantId) {
            return redirect()->route('tenant.select');
        }

        $tenant = Tenant::find($tenantId);

        if (! $tenant || ! $tenant->isActive()) {
            session()->forget('current_tenant_id');

            return redirect()->route('tenant.select');
        }

        $this->tenantManager->set($tenant);

        view()->share('currentTenant', $tenant);

        return $next($request);
    }
}
