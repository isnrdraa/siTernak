<?php

namespace App\Http\Controllers\Operations;

use App\Enums\CageMovementType;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMortalityLogRequest;
use App\Models\Cage;
use App\Models\CageMovement;
use App\Models\MortalityLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MortalityLogController extends Controller
{
    public function index(Request $request): View
    {
        $mortalityLogs = MortalityLog::with('cage', 'recorder')
            ->when($request->filled('date'), fn ($q) => $q->whereDate('date', $request->date))
            ->when($request->filled('cage_id'), fn ($q) => $q->where('cage_id', $request->cage_id))
            ->orderByDesc('date')
            ->orderByDesc('created_at')
            ->paginate(20)
            ->withQueryString();

        $cages = Cage::where('status', 'active')->orderBy('name')->get();

        return view('operations.mortality.index', compact('mortalityLogs', 'cages'));
    }

    public function create(): View
    {
        $cages = Cage::where('status', 'active')->orderBy('name')->get();

        return view('operations.mortality.create', compact('cages'));
    }

    public function store(StoreMortalityLogRequest $request): RedirectResponse
    {
        $log = MortalityLog::create([
            ...$request->validated(),
            'recorded_by' => auth()->id(),
        ]);

        $log->cage->decrement('current_count', $log->count);

        CageMovement::create([
            'tenant_id' => $log->cage->tenant_id,
            'cage_id' => $log->cage_id,
            'date' => $log->date,
            'type' => CageMovementType::Mortality,
            'quantity' => $log->count,
            'description' => "Kematian: {$log->cause}",
            'recorded_by' => auth()->id(),
        ]);

        return redirect()->route('mortality-logs.index')
            ->with('success', 'Data kematian berhasil dicatat.');
    }

    public function edit(MortalityLog $mortalityLog): View
    {
        $cages = Cage::where('status', 'active')->orderBy('name')->get();

        return view('operations.mortality.edit', compact('mortalityLog', 'cages'));
    }

    public function update(StoreMortalityLogRequest $request, MortalityLog $mortalityLog): RedirectResponse
    {
        $mortalityLog->cage->increment('current_count', $mortalityLog->count);

        $mortalityLog->update($request->validated());
        $mortalityLog->refresh();

        $mortalityLog->cage->decrement('current_count', $mortalityLog->count);

        return redirect()->route('mortality-logs.index')
            ->with('success', 'Data kematian berhasil diperbarui.');
    }

    public function destroy(MortalityLog $mortalityLog): RedirectResponse
    {
        $mortalityLog->cage->increment('current_count', $mortalityLog->count);
        $mortalityLog->delete();

        return redirect()->route('mortality-logs.index')
            ->with('success', 'Data kematian berhasil dihapus.');
    }
}
