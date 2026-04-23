<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SuperAdminDashboardController extends Controller
{
    public function __invoke(): View
    {
        $stats = [
            'total_tenants' => Tenant::count(),
            'active_tenants' => Tenant::where('status', 'active')->count(),
            'suspended_tenants' => Tenant::where('status', 'suspended')->count(),
            'total_users' => User::where('is_super_admin', false)->count(),
            'new_tenants_this_month' => Tenant::where('created_at', '>=', now()->startOfMonth())->count(),
            'new_users_this_month' => User::where('is_super_admin', false)
                ->where('created_at', '>=', now()->startOfMonth())->count(),
        ];

        $recentTenants = Tenant::withCount('users')
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        $tenantGrowth = Tenant::select(
            DB::raw('DATE(created_at) as d'),
            DB::raw('COUNT(*) as total')
        )
            ->where('created_at', '>=', now()->subDays(29))
            ->groupBy('d')
            ->orderBy('d')
            ->pluck('total', 'd');

        $userGrowth = User::select(
            DB::raw('DATE(created_at) as d'),
            DB::raw('COUNT(*) as total')
        )
            ->where('is_super_admin', false)
            ->where('created_at', '>=', now()->subDays(29))
            ->groupBy('d')
            ->orderBy('d')
            ->pluck('total', 'd');

        $tenantsByStatus = [
            'active' => $stats['active_tenants'],
            'suspended' => $stats['suspended_tenants'],
            'inactive' => Tenant::where('status', 'inactive')->count(),
        ];

        $topTenantsByUsers = Tenant::withCount('users')
            ->where('status', 'active')
            ->orderByDesc('users_count')
            ->limit(5)
            ->get();

        return view('super-admin.dashboard', compact(
            'stats',
            'recentTenants',
            'tenantGrowth',
            'userGrowth',
            'tenantsByStatus',
            'topTenantsByUsers',
        ));
    }
}
