<?php

namespace App\Http\Controllers\Operations;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHealthLogRequest;
use App\Models\Cage;
use App\Models\HealthLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HealthLogController extends Controller
{
    public function index(Request $request): View
    {
        $healthLogs = HealthLog::with('cage', 'recorder')
            ->when($request->filled('date'), fn ($q) => $q->whereDate('date', $request->date))
            ->when($request->filled('cage_id'), fn ($q) => $q->where('cage_id', $request->cage_id))
            ->when($request->filled('type'), fn ($q) => $q->where('type', $request->type))
            ->orderByDesc('date')
            ->orderByDesc('created_at')
            ->paginate(20)
            ->withQueryString();

        $cages = Cage::where('status', 'active')->orderBy('name')->get();

        return view('operations.health.index', compact('healthLogs', 'cages'));
    }

    public function create(): View
    {
        $cages = Cage::where('status', 'active')->orderBy('name')->get();

        return view('operations.health.create', compact('cages'));
    }

    public function store(StoreHealthLogRequest $request): RedirectResponse
    {
        HealthLog::create([
            ...$request->validated(),
            'recorded_by' => auth()->id(),
        ]);

        return redirect()->route('health-logs.index')
            ->with('success', 'Data kesehatan berhasil dicatat.');
    }

    public function edit(HealthLog $healthLog): View
    {
        $cages = Cage::where('status', 'active')->orderBy('name')->get();

        return view('operations.health.edit', compact('healthLog', 'cages'));
    }

    public function update(StoreHealthLogRequest $request, HealthLog $healthLog): RedirectResponse
    {
        $healthLog->update($request->validated());

        return redirect()->route('health-logs.index')
            ->with('success', 'Data kesehatan berhasil diperbarui.');
    }

    public function destroy(HealthLog $healthLog): RedirectResponse
    {
        $healthLog->delete();

        return redirect()->route('health-logs.index')
            ->with('success', 'Data kesehatan berhasil dihapus.');
    }
}
