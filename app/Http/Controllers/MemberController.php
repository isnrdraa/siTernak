<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\TenantManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class MemberController extends Controller
{
    public function index(TenantManager $tenantManager): View
    {
        $tenant = $tenantManager->get();

        $members = $tenant->users()
            ->with('roles')
            ->orderBy('name')
            ->get();

        return view('tenant.members.index', compact('members', 'tenant'));
    }

    public function create(): View
    {
        return view('tenant.members.create');
    }

    public function store(Request $request, TenantManager $tenantManager): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:admin,supervisor,staff'],
        ]);

        $tenant = $tenantManager->get();

        $user = User::where('email', $request->email)->first();

        if ($user && $user->belongsToTenant($tenant)) {
            return back()->withErrors(['email' => 'User ini sudah menjadi anggota tenant.']);
        }

        if (! $user) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
        }

        $tenant->users()->syncWithoutDetaching([
            $user->id => ['joined_at' => now()],
        ]);

        setPermissionsTeamId($tenant->id);
        $user->syncRoles([$request->role]);

        return redirect()->route('members.index')
            ->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function edit(User $user, TenantManager $tenantManager): View
    {
        $tenant = $tenantManager->get();

        abort_unless($user->belongsToTenant($tenant), 404);

        setPermissionsTeamId($tenant->id);
        $currentRole = $user->roles->first()?->name;

        return view('tenant.members.edit', compact('user', 'currentRole'));
    }

    public function update(Request $request, User $user, TenantManager $tenantManager): RedirectResponse
    {
        $request->validate([
            'role' => ['required', 'in:owner,admin,supervisor,staff'],
        ]);

        $tenant = $tenantManager->get();

        abort_unless($user->belongsToTenant($tenant), 404);

        setPermissionsTeamId($tenant->id);
        $user->syncRoles([$request->role]);

        return redirect()->route('members.index')
            ->with('success', 'Role anggota berhasil diubah.');
    }

    public function destroy(User $user, TenantManager $tenantManager): RedirectResponse
    {
        $tenant = $tenantManager->get();

        abort_unless($user->belongsToTenant($tenant), 404);

        if ($user->id === auth()->id()) {
            return back()->withErrors(['error' => 'Anda tidak bisa menghapus diri sendiri.']);
        }

        setPermissionsTeamId($tenant->id);
        $user->roles()->detach();
        $tenant->users()->detach($user);

        return redirect()->route('members.index')
            ->with('success', 'Anggota berhasil dihapus dari tenant.');
    }
}
