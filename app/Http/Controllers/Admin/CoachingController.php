<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coaching;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Services\TenantService;

class CoachingController extends Controller
{
    public function index()
    {
        $coachings = Coaching::latest()->get();
        return view('admin.coachings.index', compact('coachings'));
    }

    public function create()
    {
        return view('admin.coachings.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'coaching_name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'owner_name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'email' => 'required|email|unique:coachings,email',
            'mobile' => 'required|string|regex:/^[0-9]{10}$/',
            'state' => 'required|string|max:100',
            'gst_number' => 'nullable|string|regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/',
            'password' => 'required|string|min:8',
            'subscription_plan' => 'required|string|in:monthly,quarterly,half-yearly,annual',
        ]);

        $dbName = 'coaching_' . Str::slug($request->coaching_name) . '_' . time();

        $expiryDate = now();
        if ($request->subscription_plan == 'monthly') $expiryDate = $expiryDate->addMonth();
        elseif ($request->subscription_plan == 'quarterly') $expiryDate = $expiryDate->addMonths(3);
        elseif ($request->subscription_plan == 'half-yearly') $expiryDate = $expiryDate->addMonths(6);
        elseif ($request->subscription_plan == 'annual') $expiryDate = $expiryDate->addYear();

        $coaching = Coaching::create([
            'coaching_name' => $request->coaching_name,
            'address' => $request->address,
            'owner_name' => $request->owner_name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'state' => $request->state,
            'gst_number' => $request->gst_number,
            'database_name' => $dbName,
            'status' => 'active',
            'subscription_plan' => $request->subscription_plan,
            'expiry_date' => $expiryDate,
        ]);

        // Create Tenant DB and Run Migrations
        try {
            TenantService::createTenantDatabase($coaching);

            // Also create the Coaching Admin user in the main database
            TenantService::switchToMain();
            User::create([
                'name' => $request->owner_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'coaching_admin',
                'coaching_id' => $coaching->id
            ]);

        } catch (\Exception $e) {
            // Rollback if DB creation fails
            $coaching->delete();
            return back()->with('error', 'Failed to create tenant database: ' . $e->getMessage());
        }
        
        TenantService::switchToMain();

        return redirect()->route('admin.coachings.index')->with('success', 'Coaching Account created successfully.');
    }

    public function show(Coaching $coaching)
    {
        return view('admin.coachings.show', compact('coaching'));
    }

    public function edit(Coaching $coaching)
    {
        return view('admin.coachings.edit', compact('coaching'));
    }

    public function update(Request $request, Coaching $coaching)
    {
        $request->validate([
            'coaching_name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'owner_name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'email' => 'required|email|unique:coachings,email,'.$coaching->id,
            'mobile' => 'required|string|regex:/^[0-9]{10}$/',
            'state' => 'required|string|max:100',
            'gst_number' => 'nullable|string|regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/',
            'subscription_plan' => 'required|string|in:monthly,quarterly,half-yearly,annual',
        ]);

        $expiryDate = $coaching->expiry_date ? \Carbon\Carbon::parse($coaching->expiry_date) : now();
        if ($request->subscription_plan != $coaching->subscription_plan) {
            $expiryDate = now();
            if ($request->subscription_plan == 'monthly') $expiryDate = $expiryDate->addMonth();
            elseif ($request->subscription_plan == 'quarterly') $expiryDate = $expiryDate->addMonths(3);
            elseif ($request->subscription_plan == 'half-yearly') $expiryDate = $expiryDate->addMonths(6);
            elseif ($request->subscription_plan == 'annual') $expiryDate = $expiryDate->addYear();
        }

        $coaching->update([
            'coaching_name' => $request->coaching_name,
            'address' => $request->address,
            'owner_name' => $request->owner_name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'state' => $request->state,
            'gst_number' => $request->gst_number,
            'subscription_plan' => $request->subscription_plan,
            'expiry_date' => $expiryDate,
        ]);

        // Also update user email if exists
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $user->update(['name' => $request->owner_name]);
        }

        return redirect()->route('admin.coachings.index')->with('success', 'Coaching Account updated successfully.');
    }

    public function destroy(Coaching $coaching)
    {
        try {
            TenantService::dropTenantDatabase($coaching);
            $coaching->delete();
            
            // Delete associated coaching admin user
            User::where('email', $coaching->email)->delete();

            return back()->with('success', 'Coaching Account and Database deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete account: ' . $e->getMessage());
        }
    }

    public function activate(Coaching $coaching)
    {
        $coaching->update(['status' => 'active']);
        return back()->with('success', 'Coaching activated.');
    }

    public function deactivate(Coaching $coaching)
    {
        $coaching->update(['status' => 'inactive']);
        return back()->with('success', 'Coaching deactivated.');
    }
}
