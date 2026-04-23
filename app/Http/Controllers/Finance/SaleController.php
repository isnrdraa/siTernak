<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSaleRequest;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SaleController extends Controller
{
    public function index(Request $request): View
    {
        $sales = Sale::with('product', 'recorder')
            ->when($request->filled('date'), fn ($q) => $q->whereDate('date', $request->date))
            ->when($request->filled('product_id'), fn ($q) => $q->where('product_id', $request->product_id))
            ->orderByDesc('date')
            ->orderByDesc('created_at')
            ->paginate(20)
            ->withQueryString();

        $products = Product::where('is_active', true)->orderBy('name')->get();

        return view('finance.sales.index', compact('sales', 'products'));
    }

    public function create(): View
    {
        $products = Product::where('is_active', true)->orderBy('name')->get();

        return view('finance.sales.create', compact('products'));
    }

    public function store(StoreSaleRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['total_amount'] = $data['quantity'] * $data['unit_price'];
        $data['recorded_by'] = auth()->id();

        Sale::create($data);

        return redirect()->route('sales.index')
            ->with('success', 'Penjualan berhasil dicatat.');
    }

    public function edit(Sale $sale): View
    {
        $products = Product::where('is_active', true)->orderBy('name')->get();

        return view('finance.sales.edit', compact('sale', 'products'));
    }

    public function update(StoreSaleRequest $request, Sale $sale): RedirectResponse
    {
        $data = $request->validated();
        $data['total_amount'] = $data['quantity'] * $data['unit_price'];

        $sale->update($data);

        return redirect()->route('sales.index')
            ->with('success', 'Data penjualan berhasil diperbarui.');
    }

    public function destroy(Sale $sale): RedirectResponse
    {
        $sale->delete();

        return redirect()->route('sales.index')
            ->with('success', 'Data penjualan berhasil dihapus.');
    }
}
