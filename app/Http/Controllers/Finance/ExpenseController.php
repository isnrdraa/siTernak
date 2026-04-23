<?php

namespace App\Http\Controllers\Finance;

use App\Enums\ExpenseCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreExpenseRequest;
use App\Models\Expense;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExpenseController extends Controller
{
    public function index(Request $request): View
    {
        $expenses = Expense::with('recorder')
            ->when($request->filled('date'), fn ($q) => $q->whereDate('date', $request->date))
            ->when($request->filled('category'), fn ($q) => $q->where('category', $request->category))
            ->orderByDesc('date')
            ->orderByDesc('created_at')
            ->paginate(20)
            ->withQueryString();

        return view('finance.expenses.index', compact('expenses'));
    }

    public function create(): View
    {
        $categories = ExpenseCategory::cases();

        return view('finance.expenses.create', compact('categories'));
    }

    public function store(StoreExpenseRequest $request): RedirectResponse
    {
        Expense::create([
            ...$request->validated(),
            'recorded_by' => auth()->id(),
        ]);

        return redirect()->route('expenses.index')
            ->with('success', 'Pengeluaran berhasil dicatat.');
    }

    public function edit(Expense $expense): View
    {
        if ($expense->reference_type) {
            return back()->withErrors(['error' => 'Pengeluaran otomatis tidak dapat diedit langsung.']);
        }

        $categories = ExpenseCategory::cases();

        return view('finance.expenses.edit', compact('expense', 'categories'));
    }

    public function update(StoreExpenseRequest $request, Expense $expense): RedirectResponse
    {
        if ($expense->reference_type) {
            return back()->withErrors(['error' => 'Pengeluaran otomatis tidak dapat diedit langsung.']);
        }

        $expense->update($request->validated());

        return redirect()->route('expenses.index')
            ->with('success', 'Data pengeluaran berhasil diperbarui.');
    }

    public function destroy(Expense $expense): RedirectResponse
    {
        if ($expense->reference_type) {
            return back()->withErrors(['error' => 'Pengeluaran otomatis tidak dapat dihapus langsung.']);
        }

        $expense->delete();

        return redirect()->route('expenses.index')
            ->with('success', 'Data pengeluaran berhasil dihapus.');
    }
}
