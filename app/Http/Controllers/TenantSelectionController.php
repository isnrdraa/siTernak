<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class TenantSelectionController extends Controller
{
    public function index(Request $request): View|RedirectResponse
    {
        $user = $request->user();
        $tenants = $user->tenants()->withCount('users', 'cages')->get();

        if ($tenants->isEmpty()) {
            return redirect()->route('tenant.create');
        }

        return view('tenant.select', compact('tenants'));
    }

    public function switch(Request $request): RedirectResponse
    {
        $request->validate([
            'tenant_id' => ['required', 'exists:tenants,id'],
        ]);

        $user = $request->user();
        $tenantId = $request->input('tenant_id');

        if (! $user->isSuperAdmin() && ! $user->belongsToTenant($tenantId)) {
            abort(403);
        }

        session(['current_tenant_id' => $tenantId]);

        return redirect()->route('dashboard');
    }

    public function create(): View
    {
        return view('tenant.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $slug = Str::slug($request->name);
        $originalSlug = $slug;
        $counter = 1;
        while (Tenant::where('slug', $slug)->exists()) {
            $slug = $originalSlug.'-'.$counter++;
        }

        $tenant = Tenant::create([
            'name' => $request->name,
            'slug' => $slug,
            'status' => 'active',
        ]);

        $user = $request->user();
        $tenant->users()->attach($user, ['joined_at' => now()]);

        setPermissionsTeamId($tenant->id);
        $user->assignRole('owner');

        session(['current_tenant_id' => $tenant->id]);

        return redirect()->route('dashboard');
    }
}
