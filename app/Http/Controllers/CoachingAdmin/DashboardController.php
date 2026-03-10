<?php

namespace App\Http\Controllers\CoachingAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Connection is already pointed to tenant DB via TenantContextMiddleware
        $totalStudents = DB::connection('tenant')->table('students')->count();
        $totalTeachers = DB::connection('tenant')->table('teachers')->count();
        $totalCourses = DB::connection('tenant')->table('courses')->count();
        $totalBatches = DB::connection('tenant')->table('batches')->count();
        
        $totalRevenue = DB::connection('tenant')->table('fees')->where('status', 'paid')->sum('amount');
        $unpaidFees = DB::connection('tenant')->table('fees')->where('status', 'unpaid')->sum('amount');

        return view('coaching.dashboard', compact(
            'totalStudents',
            'totalTeachers',
            'totalCourses',
            'totalBatches',
            'totalRevenue',
            'unpaidFees'
        ));
    }
}
