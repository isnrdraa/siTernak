<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFeedStockRequest;
use App\Models\FeedStock;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FeedStockController extends Controller
{
    public function index(): View
    {
        $stocks = FeedStock::orderBy('feed_type')->get();

        return view('inventory.stocks.index', compact('stocks'));
    }

    public function create(): View
    {
        return view('inventory.stocks.create');
    }

    public function store(StoreFeedStockRequest $request): RedirectResponse
    {
        FeedStock::create($request->validated());

        return redirect()->route('feed-stocks.index')
            ->with('success', 'Jenis pakan berhasil ditambahkan.');
    }

    public function edit(FeedStock $feedStock): View
    {
        return view('inventory.stocks.edit', compact('feedStock'));
    }

    public function update(StoreFeedStockRequest $request, FeedStock $feedStock): RedirectResponse
    {
        $feedStock->update($request->validated());

        return redirect()->route('feed-stocks.index')
            ->with('success', 'Data pakan berhasil diperbarui.');
    }

    public function destroy(FeedStock $feedStock): RedirectResponse
    {
        if ($feedStock->purchases()->exists() || $feedStock->feedLogs()->exists()) {
            return back()->withErrors(['error' => 'Tidak dapat menghapus pakan yang sudah memiliki data transaksi.']);
        }

        $feedStock->delete();

        return redirect()->route('feed-stocks.index')
            ->with('success', 'Jenis pakan berhasil dihapus.');
    }
}
