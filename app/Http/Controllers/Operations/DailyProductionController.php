<?php

namespace App\Http\Controllers\Operations;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDailyProductionRequest;
use App\Models\Cage;
use App\Models\DailyProduction;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DailyProductionController extends Controller
{
    public function index(Request $request): View
    {
        $productions = DailyProduction::with('cage', 'product', 'recorder', 'validator')
            ->when($request->filled('date'), fn ($q) => $q->whereDate('date', $request->date))
            ->when($request->filled('cage_id'), fn ($q) => $q->where('cage_id', $request->cage_id))
            ->orderByDesc('date')
            ->orderByDesc('created_at')
            ->paginate(20)
            ->withQueryString();

        $cages = Cage::where('status', 'active')->orderBy('name')->get();

        return view('operations.productions.index', compact('productions', 'cages'));
    }

    public function create(): View
    {
        $cages = Cage::where('status', 'active')->orderBy('name')->get();
        $products = Product::where('is_active', true)->orderBy('name')->get();

        return view('operations.productions.create', compact('cages', 'products'));
    }

    public function store(StoreDailyProductionRequest $request): RedirectResponse
    {
        DailyProduction::create([
            ...$request->validated(),
            'recorded_by' => auth()->id(),
        ]);

        return redirect()->route('productions.index')
            ->with('success', 'Data produksi berhasil dicatat.');
    }

    public function edit(DailyProduction $production): View
    {
        $cages = Cage::where('status', 'active')->orderBy('name')->get();
        $products = Product::where('is_active', true)->orderBy('name')->get();

        return view('operations.productions.edit', compact('production', 'cages', 'products'));
    }

    public function update(StoreDailyProductionRequest $request, DailyProduction $production): RedirectResponse
    {
        $production->update($request->validated());

        return redirect()->route('productions.index')
            ->with('success', 'Data produksi berhasil diperbarui.');
    }

    public function markValidated(DailyProduction $production): RedirectResponse
    {
        if (! auth()->user()->can('validate-production')) {
            abort(403);
        }

        $production->update(['validated_by' => auth()->id()]);

        return back()->with('success', 'Data produksi berhasil divalidasi.');
    }

    public function destroy(DailyProduction $production): RedirectResponse
    {
        $production->delete();

        return redirect()->route('productions.index')
            ->with('success', 'Data produksi berhasil dihapus.');
    }
}
