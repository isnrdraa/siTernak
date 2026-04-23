<?php

namespace App\Http\Controllers\Finance;

use App\Enums\CageMovementType;
use App\Http\Controllers\Controller;
use App\Models\Cage;
use App\Models\CageMovement;
use App\Models\LivestockSale;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class LivestockSaleController extends Controller
{
    public function index(Request $request): View
    {
        $sales = LivestockSale::with('cage', 'recorder')
            ->when($request->filled('date'), fn ($q) => $q->whereDate('date', $request->date))
            ->when($request->filled('cage_id'), fn ($q) => $q->where('cage_id', $request->cage_id))
            ->orderByDesc('date')
            ->orderByDesc('created_at')
            ->paginate(20)
            ->withQueryString();

        $cages = Cage::where('status', 'active')->orderBy('name')->get();

        return view('finance.livestock-sales.index', compact('sales', 'cages'));
    }

    public function create(): View
    {
        $cages = Cage::where('status', 'active')
            ->where('current_count', '>', 0)
            ->orderBy('name')
            ->get();

        return view('finance.livestock-sales.create', compact('cages'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'cage_id' => ['required', 'exists:cages,id'],
            'date' => ['required', 'date'],
            'quantity' => ['required', 'integer', 'min:1'],
            'price_per_unit' => ['required', 'numeric', 'min:0'],
            'buyer_name' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ], [
            'cage_id.required' => 'Kandang wajib dipilih.',
            'date.required' => 'Tanggal wajib diisi.',
            'quantity.required' => 'Jumlah wajib diisi.',
            'quantity.min' => 'Jumlah minimal 1 ekor.',
            'price_per_unit.required' => 'Harga per ekor wajib diisi.',
        ]);

        $cage = Cage::findOrFail($request->cage_id);

        if ($request->quantity > $cage->current_count) {
            return back()->withInput()->withErrors(['quantity' => "Jumlah melebihi isi kandang ({$cage->current_count} ekor)."]);
        }

        DB::transaction(function () use ($request, $cage) {
            $totalAmount = $request->quantity * $request->price_per_unit;

            $sale = LivestockSale::create([
                'tenant_id' => $cage->tenant_id,
                'cage_id' => $cage->id,
                'date' => $request->date,
                'quantity' => $request->quantity,
                'price_per_unit' => $request->price_per_unit,
                'total_amount' => $totalAmount,
                'buyer_name' => $request->buyer_name,
                'notes' => $request->notes,
                'recorded_by' => auth()->id(),
            ]);

            $cage->decrement('current_count', $sale->quantity);

            CageMovement::create([
                'tenant_id' => $cage->tenant_id,
                'cage_id' => $cage->id,
                'date' => $sale->date,
                'type' => CageMovementType::Sale,
                'quantity' => $sale->quantity,
                'description' => "Penjualan {$sale->quantity} ekor".($sale->buyer_name ? " ke {$sale->buyer_name}" : ''),
                'recorded_by' => auth()->id(),
            ]);
        });

        return redirect()->route('livestock-sales.index')
            ->with('success', 'Penjualan hewan berhasil dicatat.');
    }

    public function edit(LivestockSale $livestockSale): View
    {
        $cages = Cage::where('status', 'active')->orderBy('name')->get();

        return view('finance.livestock-sales.edit', compact('livestockSale', 'cages'));
    }

    public function update(Request $request, LivestockSale $livestockSale): RedirectResponse
    {
        $request->validate([
            'cage_id' => ['required', 'exists:cages,id'],
            'date' => ['required', 'date'],
            'quantity' => ['required', 'integer', 'min:1'],
            'price_per_unit' => ['required', 'numeric', 'min:0'],
            'buyer_name' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        DB::transaction(function () use ($request, $livestockSale) {
            $livestockSale->cage->increment('current_count', $livestockSale->quantity);

            $newCage = Cage::findOrFail($request->cage_id);

            if ($request->quantity > $newCage->current_count) {
                throw new \Exception("Jumlah melebihi isi kandang ({$newCage->current_count} ekor).");
            }

            $livestockSale->update([
                'cage_id' => $request->cage_id,
                'date' => $request->date,
                'quantity' => $request->quantity,
                'price_per_unit' => $request->price_per_unit,
                'total_amount' => $request->quantity * $request->price_per_unit,
                'buyer_name' => $request->buyer_name,
                'notes' => $request->notes,
            ]);

            $newCage->decrement('current_count', $request->quantity);
        });

        return redirect()->route('livestock-sales.index')
            ->with('success', 'Data penjualan hewan berhasil diperbarui.');
    }

    public function destroy(LivestockSale $livestockSale): RedirectResponse
    {
        DB::transaction(function () use ($livestockSale) {
            $livestockSale->cage->increment('current_count', $livestockSale->quantity);
            $livestockSale->delete();
        });

        return redirect()->route('livestock-sales.index')
            ->with('success', 'Data penjualan hewan berhasil dihapus.');
    }
}
