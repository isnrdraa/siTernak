<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Enums\TenantStatus;
use App\Http\Controllers\Controller;
use App\Models\Cage;
use App\Models\DailyProduction;
use App\Models\Tenant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TenantManagementController extends Controller
{
    public function index(Request $request): View
    {
        $tenants = Tenant::withCount('users', 'cages')
            ->when($request->filled('search'), fn ($q) => $q->where('name', 'like', "%{$request->search}%"))
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->orderByDesc('created_at')
            ->paginate(20)
            ->withQueryString();

        return view('super-admin.tenants.index', compact('tenants'));
    }

    public function show(Tenant $tenant): View
    {
        $tenant->loadCount('users', 'cages');

        $members = $tenant->users()->withPivot('joined_at')->get();

        $stats = [
            'total_ternak' => Cage::withoutGlobalScopes()->where('tenant_id', $tenant->id)->sum('current_count'),
            'total_production' => DailyProduction::withoutGlobalScopes()->where('tenant_id', $tenant->id)->count(),
            'last_activity' => DailyProduction::withoutGlobalScopes()->where('tenant_id', $tenant->id)->max('created_at'),
        ];

        return view('super-admin.tenants.show', compact('tenant', 'members', 'stats'));
    }

    public function suspend(Tenant $tenant): RedirectResponse
    {
        $tenant->update(['status' => TenantStatus::Suspended]);

        return back()->with('success', "Tenant \"{$tenant->name}\" berhasil di-suspend.");
    }

    public function activate(Tenant $tenant): RedirectResponse
    {
        $tenant->update(['status' => TenantStatus::Active]);

        return back()->with('success', "Tenant \"{$tenant->name}\" berhasil diaktifkan.");
    }
}
