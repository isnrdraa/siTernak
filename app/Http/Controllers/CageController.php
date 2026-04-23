<?php

namespace App\Http\Controllers;

use App\Enums\CageMovementType;
use App\Http\Requests\StoreCageRequest;
use App\Models\Cage;
use App\Models\CageMovement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CageController extends Controller
{
    public function index(): View
    {
        $cages = Cage::orderByDesc('created_at')->get();

        return view('cages.index', compact('cages'));
    }

    public function create(): View
    {
        return view('cages.create');
    }

    public function store(StoreCageRequest $request): RedirectResponse
    {
        Cage::create($request->validated());

        return redirect()->route('cages.index')
            ->with('success', 'Kandang berhasil ditambahkan.');
    }

    public function show(Cage $cage): View
    {
        $movements = $cage->cageMovements()
            ->with('recorder')
            ->orderByDesc('date')
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('cages.show', compact('cage', 'movements'));
    }

    public function edit(Cage $cage): View
    {
        return view('cages.edit', compact('cage'));
    }

    public function update(StoreCageRequest $request, Cage $cage): RedirectResponse
    {
        $cage->update($request->validated());

        return redirect()->route('cages.index')
            ->with('success', 'Kandang berhasil diperbarui.');
    }

    public function addStock(Request $request, Cage $cage): RedirectResponse
    {
        $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
            'description' => ['nullable', 'string', 'max:255'],
        ], [
            'quantity.required' => 'Jumlah wajib diisi.',
            'quantity.min' => 'Jumlah minimal 1.',
        ]);

        $qty = (int) $request->quantity;

        if (! $cage->canAddStock($qty)) {
            return back()->withErrors(['quantity' => "Melebihi kapasitas. Sisa ruang: {$cage->availableSpace()} ekor."]);
        }

        $cage->increment('current_count', $qty);

        CageMovement::create([
            'tenant_id' => $cage->tenant_id,
            'cage_id' => $cage->id,
            'date' => now()->toDateString(),
            'type' => CageMovementType::Addition,
            'quantity' => $qty,
            'description' => $request->description ?? 'Penambahan ternak',
            'recorded_by' => auth()->id(),
        ]);

        return back()->with('success', "Berhasil menambahkan {$qty} ekor ke kandang.");
    }

    public function destroy(Cage $cage): RedirectResponse
    {
        if ($cage->current_count > 0) {
            return back()->withErrors(['error' => 'Kandang tidak bisa dihapus karena masih berisi ternak.']);
        }

        $cage->delete();

        return redirect()->route('cages.index')
            ->with('success', 'Kandang berhasil dihapus.');
    }
}
