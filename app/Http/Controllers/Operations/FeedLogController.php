<?php

namespace App\Http\Controllers\Operations;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFeedLogRequest;
use App\Models\Cage;
use App\Models\FeedLog;
use App\Models\FeedStock;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FeedLogController extends Controller
{
    public function index(Request $request): View
    {
        $feedLogs = FeedLog::with('cage', 'recorder', 'feedStock')
            ->when($request->filled('date'), fn ($q) => $q->whereDate('date', $request->date))
            ->when($request->filled('cage_id'), fn ($q) => $q->where('cage_id', $request->cage_id))
            ->orderByDesc('date')
            ->orderByDesc('created_at')
            ->paginate(20)
            ->withQueryString();

        $cages = Cage::where('status', 'active')->orderBy('name')->get();

        return view('operations.feeds.index', compact('feedLogs', 'cages'));
    }

    public function create(): View
    {
        $cages = Cage::where('status', 'active')->orderBy('name')->get();
        $feedStocks = FeedStock::orderBy('feed_type')->get();

        return view('operations.feeds.create', compact('cages', 'feedStocks'));
    }

    public function store(StoreFeedLogRequest $request): RedirectResponse
    {
        $feedLog = FeedLog::create([
            ...$request->validated(),
            'recorded_by' => auth()->id(),
        ]);

        if ($feedLog->feed_stock_id) {
            $feedLog->feedStock->decrement('current_stock_kg', $feedLog->quantity_kg);
        }

        return redirect()->route('feed-logs.index')
            ->with('success', 'Data pakan berhasil dicatat.');
    }

    public function edit(FeedLog $feedLog): View
    {
        $cages = Cage::where('status', 'active')->orderBy('name')->get();
        $feedStocks = FeedStock::orderBy('feed_type')->get();

        return view('operations.feeds.edit', compact('feedLog', 'cages', 'feedStocks'));
    }

    public function update(StoreFeedLogRequest $request, FeedLog $feedLog): RedirectResponse
    {
        if ($feedLog->feed_stock_id) {
            $feedLog->feedStock->increment('current_stock_kg', $feedLog->quantity_kg);
        }

        $feedLog->update($request->validated());
        $feedLog->refresh();

        if ($feedLog->feed_stock_id) {
            $feedLog->feedStock->decrement('current_stock_kg', $feedLog->quantity_kg);
        }

        return redirect()->route('feed-logs.index')
            ->with('success', 'Data pakan berhasil diperbarui.');
    }

    public function destroy(FeedLog $feedLog): RedirectResponse
    {
        if ($feedLog->feed_stock_id) {
            $feedLog->feedStock->increment('current_stock_kg', $feedLog->quantity_kg);
        }

        $feedLog->delete();

        return redirect()->route('feed-logs.index')
            ->with('success', 'Data pakan berhasil dihapus.');
    }
}
