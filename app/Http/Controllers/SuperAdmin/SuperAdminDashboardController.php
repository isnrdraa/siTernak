<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Cage;
use App\Models\DailyProduction;
use App\Models\MortalityLog;
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
            'total_ternak' => Cage::withoutGlobalScopes()->sum('current_count'),
            'today_production' => DailyProduction::withoutGlobalScopes()->whereDate('date', today())->count(),
            'today_mortality' => MortalityLog::withoutGlobalScopes()->whereDate('date', today())->sum('count'),
        ];

        $topTenants = Tenant::withCount('users')
            ->withCount(['dailyProductions as total_records' => fn ($q) => $q->withoutGlobalScopes()->whereBetween('date', [now()->subDays(6), today()])])
            ->orderByDesc('total_records')
            ->limit(5)
            ->get();

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

        return view('super-admin.dashboard', compact('stats', 'topTenants', 'recentTenants', 'tenantGrowth'));
    }
}
