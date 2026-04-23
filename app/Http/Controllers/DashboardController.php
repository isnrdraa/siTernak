<?php

namespace App\Http\Controllers;

use App\Models\Cage;
use App\Models\DailyProduction;
use App\Models\Expense;
use App\Models\FeedLog;
use App\Models\FeedStock;
use App\Models\HealthLog;
use App\Models\LivestockSale;
use App\Models\MortalityLog;
use App\Models\Sale;
use App\Services\TenantManager;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(TenantManager $tenantManager): View
    {
        $tenant = $tenantManager->get();
        $today = today();

        $stats = [
            'total_cages' => Cage::count(),
            'total_ternak' => Cage::sum('current_count'),
            'today_feed_kg' => FeedLog::whereDate('date', $today)->sum('quantity_kg'),
            'today_mortality' => MortalityLog::whereDate('date', $today)->sum('count'),
            'week_mortality' => MortalityLog::whereBetween('date', [now()->subDays(7), $today])->sum('count'),
            'pending_health' => HealthLog::where('type', 'Disease')->whereDate('date', '>=', now()->subDays(7))->count(),
            'member_count' => $tenant->users()->count(),
        ];

        $todayProductions = DailyProduction::with('product')
            ->whereDate('date', $today)
            ->select('product_id', DB::raw('SUM(quantity) as total_qty'), DB::raw('SUM(damaged_count) as total_damaged'))
            ->groupBy('product_id')
            ->get();

        $period = CarbonPeriod::create(now()->subDays(6), $today);
        $dates = collect($period)->map(fn ($d) => $d->format('Y-m-d'));
        $labels = collect($period)->map(fn ($d) => $d->translatedFormat('d M'));

        $productionTrend = DailyProduction::select(
            DB::raw('DATE(date) as d'),
            DB::raw('COUNT(*) as total')
        )
            ->whereBetween('date', [now()->subDays(6), $today])
            ->groupBy('d')
            ->pluck('total', 'd');

        $feedTrend = FeedLog::select(
            DB::raw('DATE(date) as d'),
            DB::raw('SUM(quantity_kg) as total')
        )
            ->whereBetween('date', [now()->subDays(6), $today])
            ->groupBy('d')
            ->pluck('total', 'd');

        $mortalityTrend = MortalityLog::select(
            DB::raw('DATE(date) as d'),
            DB::raw('SUM(count) as total')
        )
            ->whereBetween('date', [now()->subDays(6), $today])
            ->groupBy('d')
            ->pluck('total', 'd');

        $chartData = [
            'labels' => $labels->values(),
            'production' => $dates->map(fn ($d) => $productionTrend[$d] ?? 0)->values(),
            'feed' => $dates->map(fn ($d) => (float) ($feedTrend[$d] ?? 0))->values(),
            'mortality' => $dates->map(fn ($d) => $mortalityTrend[$d] ?? 0)->values(),
        ];

        $recentProductions = DailyProduction::with('cage', 'product', 'recorder')
            ->orderByDesc('date')
            ->limit(5)
            ->get();

        $recentHealthAlerts = HealthLog::with('cage')
            ->where('type', 'Disease')
            ->orderByDesc('date')
            ->limit(5)
            ->get();

        $lowStocks = FeedStock::whereColumn('current_stock_kg', '<=', 'min_stock_kg')->get();

        $monthStart = now()->startOfMonth()->format('Y-m-d');
        $monthEnd = now()->format('Y-m-d');
        $monthLivestockSales = LivestockSale::whereBetween('date', [$monthStart, $monthEnd])->sum('total_amount');
        $financeSummary = [
            'month_sales' => Sale::whereBetween('date', [$monthStart, $monthEnd])->sum('total_amount') + $monthLivestockSales,
            'month_expenses' => Expense::whereBetween('date', [$monthStart, $monthEnd])->sum('amount'),
        ];
        $financeSummary['month_profit'] = $financeSummary['month_sales'] - $financeSummary['month_expenses'];

        return view('dashboard', compact('tenant', 'stats', 'todayProductions', 'chartData', 'recentProductions', 'recentHealthAlerts', 'lowStocks', 'financeSummary'));
    }
}
