<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TenantContextMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $user = auth()->user();
            $coaching = null;

            // Resolve coaching based on role and available data
            if ($user->role === 'coaching_admin') {
                $coaching = \App\Models\Coaching::where('email', $user->email)->first();
                // Fix: Update user record with coaching_id if missing for performance
                if ($coaching && is_null($user->coaching_id)) {
                    $user->update(['coaching_id' => $coaching->id]);
                }
            } elseif (in_array($user->role, ['teacher', 'student', 'faculty'])) {
                if ($user->coaching_id) {
                    $coaching = \App\Models\Coaching::find($user->coaching_id);
                } else {
                    // Critical failure: User exists but has no coaching assigned.
                    auth()->logout();
                    return redirect()->route('login')->withErrors(['email' => 'Your account is not linked to any coaching institute.']);
                }
            }

            if ($coaching) {
                // Check Subscription Expiry
                if ($coaching->expiry_date && \Carbon\Carbon::parse($coaching->expiry_date)->isPast()) {
                    auth()->logout();
                    return redirect()->route('login')->withErrors(['email' => 'Your subscription has expired. Please contact the administrator to renew.']);
                }

                if ($coaching->status === 'active') {
                    \App\Services\TenantService::switchToTenant($coaching);
                    view()->share('currentCoaching', $coaching);

                    // Share role-specific record
                    if ($user->role === 'student') {
                        $student = \App\Models\Student::where('email', $user->email)->first();
                        view()->share('currentStudent', $student);
                    }
                } else {
                    auth()->logout();
                    return redirect()->route('login')->withErrors(['email' => 'Your coaching account is deactivated.']);
                }
            } else {
                // Critical failure: Coaching record not found even if coaching_id was set
                if (in_array($user->role, ['coaching_admin', 'teacher', 'student', 'faculty'])) {
                    auth()->logout();
                    return redirect()->route('login')->withErrors(['email' => 'Assigned coaching data not found.']);
                }
            }
        }

        return $next($request);
    }
}
