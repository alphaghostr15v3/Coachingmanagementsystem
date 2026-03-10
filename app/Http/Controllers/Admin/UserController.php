<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index()
    {
        $users = User::whereIn('role', ['super_admin', 'coaching_admin'])->latest()->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email', 'unique:coachings,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:super_admin,coaching_admin'],
        ];

        if ($request->role === 'coaching_admin') {
            $rules['coaching_name'] = ['required', 'string', 'max:255', 'unique:coachings,coaching_name'];
            $rules['mobile'] = ['nullable', 'string', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10', 'max:20'];
        }

        $request->validate($rules);

        try {
            $coachingId = null;

            if ($request->role === 'coaching_admin') {
                $dbName = 'coaching_' . \Illuminate\Support\Str::slug($request->coaching_name) . '_' . time();
                
                $coaching = \App\Models\Coaching::create([
                    'coaching_name' => $request->coaching_name,
                    'owner_name' => $request->name,
                    'email' => $request->email,
                    'mobile' => $request->mobile,
                    'database_name' => $dbName,
                    'status' => 'active',
                ]);

                \App\Services\TenantService::createTenantDatabase($coaching);
                \App\Services\TenantService::switchToMain();
                $coachingId = $coaching->id;
            }

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'coaching_id' => $coachingId,
            ]);

            return redirect()->route('admin.users.index')->with('success', 'User created successfully with institute database.');

        } catch (\Exception $e) {
            if (isset($coaching)) {
                \App\Services\TenantService::dropTenantDatabase($coaching);
                $coaching->delete();
            }
            return back()->with('error', 'Critical deployment failure: ' . $e->getMessage())->withInput();
        }
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'role' => ['required', 'in:super_admin,coaching_admin'],
        ]);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $request->validate([
                'password' => ['confirmed', Rules\Password::defaults()],
            ]);
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete yourself.');
        }

        // If it's a coaching admin, cleanup their coaching and database
        if ($user->role === 'coaching_admin' && $user->coaching_id) {
            $coaching = \App\Models\Coaching::find($user->coaching_id);
            if ($coaching) {
                try {
                    \App\Services\TenantService::dropTenantDatabase($coaching);
                    $coaching->delete();
                } catch (\Exception $e) {
                    return back()->with('error', 'Failed to cleanup institute hardware: ' . $e->getMessage());
                }
            }
        }

        $user->delete();
        return back()->with('success', 'User and associated institute data deleted successfully.');
    }
}
