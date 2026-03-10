<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Coaching;
use App\Services\TenantService;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $coachings = Coaching::all();
        $totalCoachings = $coachings->count();
        $activeCoachings = $coachings->where('status', 'active')->count();
        $expiredCoachings = $coachings->where('status', 'inactive')->count(); // Assuming inactive = expired

        $totalStudents = 0;
        $totalRevenue = 0;

        foreach ($coachings as $coaching) {
            try {
                TenantService::switchToTenant($coaching);
                
                // Assuming we can query students table for count
                $studentsCount = DB::connection('tenant')->table('students')->count();
                $totalStudents += $studentsCount;

                // Sum all paid fees in this tenant DB
                $fees = DB::connection('tenant')->table('fees')->where('status', 'paid')->sum('amount');
                $totalRevenue += (float) $fees;

            } catch (\Exception $e) {
                // If DB doesn't exist yet or connection fails, skip
                continue;
            }
        }

        // Switch back to main DB just in case
        TenantService::switchToMain();

        return view('admin.dashboard', compact(
            'totalCoachings', 
            'activeCoachings', 
            'expiredCoachings', 
            'totalStudents', 
            'totalRevenue'
        ));
    }
}
