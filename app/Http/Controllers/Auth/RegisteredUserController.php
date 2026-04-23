<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'tenant_name' => ['required', 'string', 'max:255'],
        ]);

        $user = DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $slug = Str::slug($request->tenant_name);
            $originalSlug = $slug;
            $counter = 1;
            while (Tenant::where('slug', $slug)->exists()) {
                $slug = $originalSlug.'-'.$counter++;
            }

            $tenant = Tenant::create([
                'name' => $request->tenant_name,
                'slug' => $slug,
                'status' => 'active',
            ]);

            Subscription::create([
                'tenant_id' => $tenant->id,
                'plan' => 'free',
                'status' => 'active',
                'starts_at' => now(),
            ]);

            $tenant->users()->attach($user, ['joined_at' => now()]);

            setPermissionsTeamId($tenant->id);
            $user->assignRole('owner');

            return $user;
        });

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('tenant.select');
    }
}
