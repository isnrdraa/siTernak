<?php

namespace App\Http\Controllers;

use App\Models\Cage;
use App\Models\DailyProduction;
use App\Models\FeedLog;
use App\Models\HealthLog;
use App\Models\MortalityLog;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function production(Request $request): View
    {
        $startDate = $request->input('start_date', now()->subDays(29)->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));
        $cageId = $request->input('cage_id');

        $query = DailyProduction::query()
            ->whereBetween('date', [$startDate, $endDate]);

        if ($cageId) {
            $query->where('cage_id', $cageId);
        }

        $dailyData = (clone $query)->select(
            DB::raw('DATE(date) as d'),
            DB::raw('COUNT(*) as total_records'),
            DB::raw('SUM(quantity) as total_qty'),
            DB::raw('SUM(damaged_count) as total_damaged')
        )->groupBy('d')->orderBy('d')->get();

        $byProduct = (clone $query)->with('product')
            ->select('product_id', DB::raw('SUM(quantity) as total_qty'), DB::raw('SUM(damaged_count) as total_damaged'), DB::raw('COUNT(*) as records'))
            ->groupBy('product_id')
            ->get();

        $summary = [
            'total_records' => $dailyData->sum('total_records'),
            'total_quantity' => $dailyData->sum('total_qty'),
            'total_damaged' => $dailyData->sum('total_damaged'),
            'avg_daily_records' => $dailyData->count() > 0 ? round($dailyData->avg('total_records')) : 0,
        ];

        $period = CarbonPeriod::create($startDate, $endDate);
        $dates = collect($period)->map(fn ($d) => $d->format('Y-m-d'));
        $labels = collect($period)->map(fn ($d) => $d->translatedFormat('d M'));
        $recordsMap = $dailyData->pluck('total_records', 'd');
        $qtyMap = $dailyData->pluck('total_qty', 'd');

        $chartData = [
            'labels' => $labels->values(),
            'records' => $dates->map(fn ($d) => $recordsMap[$d] ?? 0)->values(),
            'quantity' => $dates->map(fn ($d) => (float) ($qtyMap[$d] ?? 0))->values(),
        ];

        $perCage = (clone $query)->with('cage')
            ->select('cage_id', DB::raw('SUM(quantity) as total_qty'), DB::raw('SUM(damaged_count) as total_damaged'), DB::raw('COUNT(DISTINCT date) as days'))
            ->groupBy('cage_id')
            ->get();

        $cages = Cage::where('status', 'active')->orderBy('name')->get();

        return view('reports.production', compact('summary', 'chartData', 'byProduct', 'perCage', 'cages', 'startDate', 'endDate', 'cageId'));
    }

    public function feed(Request $request): View
    {
        $startDate = $request->input('start_date', now()->subDays(29)->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));
        $cageId = $request->input('cage_id');

        $query = FeedLog::query()
            ->whereBetween('date', [$startDate, $endDate]);

        if ($cageId) {
            $query->where('cage_id', $cageId);
        }

        $dailyData = (clone $query)->select(
            DB::raw('DATE(date) as d'),
            DB::raw('SUM(quantity_kg) as total_kg')
        )->groupBy('d')->orderBy('d')->get();

        $byType = (clone $query)->select(
            'feed_type',
            DB::raw('SUM(quantity_kg) as total_kg'),
            DB::raw('COUNT(*) as entries')
        )->groupBy('feed_type')->orderByDesc('total_kg')->get();

        $totalTernak = Cage::when($cageId, fn ($q) => $q->where('id', $cageId))->sum('current_count');

        $summary = [
            'total_kg' => $dailyData->sum('total_kg'),
            'avg_daily_kg' => $dailyData->count() > 0 ? round($dailyData->avg('total_kg'), 1) : 0,
            'peak_day' => $dailyData->sortByDesc('total_kg')->first(),
            'total_entries' => $byType->sum('entries'),
            'avg_per_ekor' => $totalTernak > 0 && $dailyData->count() > 0
                ? round(($dailyData->avg('total_kg') / $totalTernak) * 1000, 1)
                : 0,
        ];

        $period = CarbonPeriod::create($startDate, $endDate);
        $dates = collect($period)->map(fn ($d) => $d->format('Y-m-d'));
        $labels = collect($period)->map(fn ($d) => $d->translatedFormat('d M'));
        $feedMap = $dailyData->pluck('total_kg', 'd');

        $chartData = [
            'labels' => $labels->values(),
            'feed' => $dates->map(fn ($d) => (float) ($feedMap[$d] ?? 0))->values(),
        ];

        $cages = Cage::where('status', 'active')->orderBy('name')->get();

        return view('reports.feed', compact('summary', 'chartData', 'byType', 'cages', 'startDate', 'endDate', 'cageId'));
    }

    public function mortality(Request $request): View
    {
        $startDate = $request->input('start_date', now()->subDays(29)->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));
        $cageId = $request->input('cage_id');

        $query = MortalityLog::query()
            ->whereBetween('date', [$startDate, $endDate]);

        if ($cageId) {
            $query->where('cage_id', $cageId);
        }

        $dailyData = (clone $query)->select(
            DB::raw('DATE(date) as d'),
            DB::raw('SUM(count) as total')
        )->groupBy('d')->orderBy('d')->get();

        $byCause = (clone $query)->select(
            DB::raw("COALESCE(cause, 'Tidak Diketahui') as cause_label"),
            DB::raw('SUM(count) as total')
        )->groupBy('cause_label')->orderByDesc('total')->get();

        $totalTernak = Cage::when($cageId, fn ($q) => $q->where('id', $cageId))->sum('current_count');

        $summary = [
            'total_mortality' => $dailyData->sum('total'),
            'avg_daily' => $dailyData->count() > 0 ? round($dailyData->avg('total'), 1) : 0,
            'peak_day' => $dailyData->sortByDesc('total')->first(),
            'mortality_rate' => $totalTernak > 0
                ? round(($dailyData->sum('total') / $totalTernak) * 100, 2)
                : 0,
        ];

        $period = CarbonPeriod::create($startDate, $endDate);
        $dates = collect($period)->map(fn ($d) => $d->format('Y-m-d'));
        $labels = collect($period)->map(fn ($d) => $d->translatedFormat('d M'));
        $mortalityMap = $dailyData->pluck('total', 'd');

        $chartData = [
            'labels' => $labels->values(),
            'mortality' => $dates->map(fn ($d) => $mortalityMap[$d] ?? 0)->values(),
        ];

        $cages = Cage::where('status', 'active')->orderBy('name')->get();

        return view('reports.mortality', compact('summary', 'chartData', 'byCause', 'cages', 'startDate', 'endDate', 'cageId'));
    }

    public function health(Request $request): View
    {
        $startDate = $request->input('start_date', now()->subDays(29)->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));

        $byType = HealthLog::select(
            'type',
            DB::raw('COUNT(*) as total')
        )
            ->whereBetween('date', [$startDate, $endDate])
            ->groupBy('type')
            ->orderByDesc('total')
            ->get();

        $recentLogs = HealthLog::with('cage', 'recorder')
            ->whereBetween('date', [$startDate, $endDate])
            ->orderByDesc('date')
            ->limit(20)
            ->get();

        $summary = [
            'total_events' => $byType->sum('total'),
            'diseases' => $byType->where('type', 'Disease')->first()?->total ?? 0,
            'vaccinations' => $byType->where('type', 'Vaccination')->first()?->total ?? 0,
            'treatments' => $byType->where('type', 'Treatment')->first()?->total ?? 0,
            'checkups' => $byType->where('type', 'Checkup')->first()?->total ?? 0,
        ];

        $chartData = [
            'labels' => $byType->map(fn ($i) => match ($i->type) {
                'Vaccination' => 'Vaksinasi',
                'Treatment' => 'Perawatan',
                'Checkup' => 'Pemeriksaan',
                'Disease' => 'Penyakit',
                default => $i->type,
            })->values(),
            'data' => $byType->pluck('total')->values(),
        ];

        return view('reports.health', compact('summary', 'chartData', 'byType', 'recentLogs', 'startDate', 'endDate'));
    }
}
