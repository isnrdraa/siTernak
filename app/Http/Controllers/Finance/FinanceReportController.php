<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Sale;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class FinanceReportController extends Controller
{
    public function __invoke(Request $request): View
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));

        $totalSales = Sale::whereBetween('date', [$startDate, $endDate])->sum('total_amount');
        $totalExpenses = Expense::whereBetween('date', [$startDate, $endDate])->sum('amount');
        $profit = $totalSales - $totalExpenses;

        $salesByProduct = Sale::with('product')
            ->whereBetween('date', [$startDate, $endDate])
            ->select('product_id', DB::raw('SUM(quantity) as total_qty'), DB::raw('SUM(total_amount) as total_amount'))
            ->groupBy('product_id')
            ->orderByDesc('total_amount')
            ->get();

        $expensesByCategory = Expense::whereBetween('date', [$startDate, $endDate])
            ->select('category', DB::raw('SUM(amount) as total_amount'), DB::raw('COUNT(*) as entries'))
            ->groupBy('category')
            ->orderByDesc('total_amount')
            ->get();

        $period = CarbonPeriod::create($startDate, $endDate);
        $dates = collect($period)->map(fn ($d) => $d->format('Y-m-d'));
        $labels = collect($period)->map(fn ($d) => $d->translatedFormat('d M'));

        $dailySales = Sale::whereBetween('date', [$startDate, $endDate])
            ->select(DB::raw('DATE(date) as d'), DB::raw('SUM(total_amount) as total'))
            ->groupBy('d')
            ->pluck('total', 'd');

        $dailyExpenses = Expense::whereBetween('date', [$startDate, $endDate])
            ->select(DB::raw('DATE(date) as d'), DB::raw('SUM(amount) as total'))
            ->groupBy('d')
            ->pluck('total', 'd');

        $chartData = [
            'labels' => $labels->values(),
            'sales' => $dates->map(fn ($d) => (float) ($dailySales[$d] ?? 0))->values(),
            'expenses' => $dates->map(fn ($d) => (float) ($dailyExpenses[$d] ?? 0))->values(),
        ];

        $summary = compact('totalSales', 'totalExpenses', 'profit');

        return view('finance.summary', compact('summary', 'salesByProduct', 'expensesByCategory', 'chartData', 'startDate', 'endDate'));
    }
}
