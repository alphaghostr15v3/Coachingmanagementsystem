<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Coaching;
use App\Models\Student;
use App\Models\Teacher;
use App\Services\TenantService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class SystemUserController extends Controller
{
    public function index()
    {
        $users = User::whereIn('role', ['teacher', 'student'])->with('coaching')->latest()->get();
        return view('admin.system_users.index', compact('users'));
    }

    public function create()
    {
        $coachings = Coaching::where('status', 'active')->get();
        return view('admin.system_users.create', compact('coachings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:teacher,student'],
            'coaching_id' => ['required', 'exists:coachings,id'],
            'phone' => ['nullable', 'string', 'max:20'],
            'subject' => ['nullable', 'string', 'max:255'], // For teachers
            'address' => ['nullable', 'string', 'max:500'], // For students
        ]);

        $coaching = Coaching::findOrFail($request->coaching_id);

        // 1. Create User in Main DB
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'coaching_id' => $coaching->id,
        ]);

        // 2. Create Record in Tenant DB
        try {
            TenantService::switchToTenant($coaching);
            
            if ($request->role === 'student') {
                Student::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'address' => $request->address,
                ]);
            } else {
                Teacher::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'subject' => $request->subject,
                ]);
            }
            
            TenantService::switchToMain();
        } catch (\Exception $e) {
            TenantService::switchToMain();
            $user->delete();
            return back()->with('error', 'Failed to create record in tenant database: ' . $e->getMessage());
        }

        return redirect()->route('admin.system-users.index')->with('success', 'System user created successfully.');
    }

    public function edit(User $system_user)
    {
        // Only allow editing students and teachers here
        if (!in_array($system_user->role, ['teacher', 'student'])) {
            return redirect()->route('admin.system-users.index')->with('error', 'Invalid user role.');
        }

        $coachings = Coaching::where('status', 'active')->get();
        
        // Fetch extra data from tenant
        $extraData = [];
        $coaching = Coaching::find($system_user->coaching_id);
        if ($coaching) {
            try {
                TenantService::switchToTenant($coaching);
                if ($system_user->role === 'student') {
                    $extraData = Student::where('email', $system_user->email)->first();
                } else {
                    $extraData = Teacher::where('email', $system_user->email)->first();
                }
                TenantService::switchToMain();
            } catch (\Exception $e) {
                TenantService::switchToMain();
            }
        }

        return view('admin.system_users.edit', compact('system_user', 'coachings', 'extraData'));
    }

    public function update(Request $request, User $system_user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,'.$system_user->id],
            'role' => ['required', 'in:teacher,student'],
            'coaching_id' => ['required', 'exists:coachings,id'],
            'phone' => ['nullable', 'string', 'max:20'],
            'subject' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:500'],
        ]);

        $oldEmail = $system_user->email;
        $oldRole = $system_user->role;

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'coaching_id' => $request->coaching_id,
        ];

        if ($request->filled('password')) {
            $request->validate([
                'password' => ['confirmed', Rules\Password::defaults()],
            ]);
            $userData['password'] = Hash::make($request->password);
        }

        $coaching = Coaching::findOrFail($request->coaching_id);
        
        try {
            TenantService::switchToTenant($coaching);
            
            if ($request->role === 'student') {
                $record = Student::where('email', $oldEmail)->first();
                $data = [
                    'name' => $request->name, 
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'address' => $request->address
                ];
                if ($record) {
                    $record->update($data);
                } else {
                    Student::create($data);
                }
            } else {
                $record = Teacher::where('email', $oldEmail)->first();
                $data = [
                    'name' => $request->name, 
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'subject' => $request->subject
                ];
                if ($record) {
                    $record->update($data);
                } else {
                    Teacher::create($data);
                }
            }
            
            TenantService::switchToMain();
            $system_user->update($userData);

        } catch (\Exception $e) {
            TenantService::switchToMain();
            return back()->with('error', 'Failed to update tenant record: ' . $e->getMessage());
        }

        return redirect()->route('admin.system-users.index')->with('success', 'System user updated successfully.');
    }

    public function destroy(User $system_user)
    {
        if (!in_array($system_user->role, ['teacher', 'student'])) {
            return back()->with('error', 'Invalid user role for deletion here.');
        }

        $coaching = Coaching::find($system_user->coaching_id);
        
        if ($coaching) {
            try {
                TenantService::switchToTenant($coaching);
                if ($system_user->role === 'student') {
                    Student::where('email', $system_user->email)->delete();
                } else {
                    Teacher::where('email', $system_user->email)->delete();
                }
                TenantService::switchToMain();
            } catch (\Exception $e) {
                TenantService::switchToMain();
            }
        }

        $system_user->delete();
        return back()->with('success', 'System user deleted successfully.');
    }
}
