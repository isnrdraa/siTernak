<?php

namespace App\Http\Middleware;

use App\Services\TenantManager;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTenantAccess
{
    public function __construct(private TenantManager $tenantManager) {}

    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        $tenant = $this->tenantManager->get();

        if (! $user || ! $tenant) {
            abort(403, 'Akses ditolak.');
        }

        if ($user->isSuperAdmin()) {
            return $next($request);
        }

        if (! $user->belongsToTenant($tenant)) {
            abort(403, 'Anda tidak memiliki akses ke tenant ini.');
        }

        return $next($request);
    }
}
