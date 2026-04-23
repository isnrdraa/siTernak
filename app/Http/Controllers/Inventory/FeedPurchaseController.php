<?php

namespace App\Http\Controllers\Inventory;

use App\Enums\ExpenseCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFeedPurchaseRequest;
use App\Models\Expense;
use App\Models\FeedPurchase;
use App\Models\FeedStock;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class FeedPurchaseController extends Controller
{
    public function index(Request $request): View
    {
        $purchases = FeedPurchase::with('feedStock', 'recorder')
            ->when($request->filled('feed_stock_id'), fn ($q) => $q->where('feed_stock_id', $request->feed_stock_id))
            ->orderByDesc('date')
            ->orderByDesc('created_at')
            ->paginate(20)
            ->withQueryString();

        $feedStocks = FeedStock::orderBy('feed_type')->get();

        return view('inventory.purchases.index', compact('purchases', 'feedStocks'));
    }

    public function create(): View
    {
        $feedStocks = FeedStock::orderBy('feed_type')->get();

        return view('inventory.purchases.create', compact('feedStocks'));
    }

    public function store(StoreFeedPurchaseRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            $purchase = FeedPurchase::create([
                ...$request->validated(),
                'recorded_by' => auth()->id(),
            ]);

            $stock = $purchase->feedStock;
            $stock->increment('current_stock_kg', $purchase->quantity_kg);

            if ($purchase->quantity_kg > 0) {
                $stock->update([
                    'unit_price' => round($purchase->total_cost / $purchase->quantity_kg, 2),
                ]);
            }

            Expense::create([
                'tenant_id' => $purchase->tenant_id,
                'date' => $purchase->date,
                'category' => ExpenseCategory::Pakan,
                'description' => "Pembelian {$stock->feed_type} ({$purchase->quantity_kg} kg)",
                'amount' => $purchase->total_cost,
                'reference_type' => FeedPurchase::class,
                'reference_id' => $purchase->id,
                'recorded_by' => auth()->id(),
            ]);
        });

        return redirect()->route('feed-purchases.index')
            ->with('success', 'Pembelian pakan berhasil dicatat.');
    }

    public function edit(FeedPurchase $feedPurchase): View
    {
        $feedStocks = FeedStock::orderBy('feed_type')->get();

        return view('inventory.purchases.edit', compact('feedPurchase', 'feedStocks'));
    }

    public function update(StoreFeedPurchaseRequest $request, FeedPurchase $feedPurchase): RedirectResponse
    {
        DB::transaction(function () use ($request, $feedPurchase) {
            $oldStock = $feedPurchase->feedStock;
            $oldStock->decrement('current_stock_kg', $feedPurchase->quantity_kg);

            $feedPurchase->update($request->validated());
            $feedPurchase->refresh();

            $newStock = $feedPurchase->feedStock;
            $newStock->increment('current_stock_kg', $feedPurchase->quantity_kg);

            $feedPurchase->expense?->update([
                'date' => $feedPurchase->date,
                'description' => "Pembelian {$newStock->feed_type} ({$feedPurchase->quantity_kg} kg)",
                'amount' => $feedPurchase->total_cost,
            ]);
        });

        return redirect()->route('feed-purchases.index')
            ->with('success', 'Data pembelian berhasil diperbarui.');
    }

    public function destroy(FeedPurchase $feedPurchase): RedirectResponse
    {
        DB::transaction(function () use ($feedPurchase) {
            $feedPurchase->feedStock->decrement('current_stock_kg', $feedPurchase->quantity_kg);
            $feedPurchase->expense?->delete();
            $feedPurchase->delete();
        });

        return redirect()->route('feed-purchases.index')
            ->with('success', 'Data pembelian berhasil dihapus.');
    }
}
