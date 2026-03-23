<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    $role = auth()->user()->role;
    if ($role === 'super_admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($role === 'coaching_admin') {
        return redirect()->route('coaching.dashboard');
    } elseif ($role === 'teacher') {
        return redirect()->route('teacher.dashboard');
    } elseif ($role === 'faculty') {
        return redirect()->route('faculty.dashboard');
    } elseif ($role === 'student') {
        return redirect()->route('student.dashboard');
    }
    return redirect('/');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:super_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('coachings', \App\Http\Controllers\Admin\CoachingController::class);
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::resource('system-users', \App\Http\Controllers\Admin\SystemUserController::class);
    Route::patch('coachings/{coaching}/activate', [\App\Http\Controllers\Admin\CoachingController::class, 'activate'])->name('coachings.activate');
    Route::patch('coachings/{coaching}/deactivate', [\App\Http\Controllers\Admin\CoachingController::class, 'deactivate'])->name('coachings.deactivate');
});

Route::middleware(['auth', 'role:coaching_admin'])->prefix('coaching')->name('coaching.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\CoachingAdmin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('students', \App\Http\Controllers\CoachingAdmin\StudentController::class);
    Route::get('students/{student}/id-card', [\App\Http\Controllers\CoachingAdmin\StudentController::class, 'idCard'])->name('students.id-card');
    Route::resource('teachers', \App\Http\Controllers\CoachingAdmin\TeacherController::class);
    Route::resource('faculties', \App\Http\Controllers\CoachingAdmin\FacultyController::class);
    Route::resource('departments', \App\Http\Controllers\CoachingAdmin\DepartmentController::class);
    Route::resource('designations', \App\Http\Controllers\CoachingAdmin\DesignationController::class);
    Route::resource('courses', \App\Http\Controllers\CoachingAdmin\CourseController::class);
    Route::resource('batches', \App\Http\Controllers\CoachingAdmin\BatchController::class);
    Route::resource('fees', \App\Http\Controllers\CoachingAdmin\FeeController::class);
    Route::get('fees/{fee}/download', [\App\Http\Controllers\CoachingAdmin\FeeController::class, 'downloadInvoice'])->name('fees.download');
    Route::resource('attendance', \App\Http\Controllers\CoachingAdmin\AttendanceController::class);
    Route::resource('teacher-attendance', \App\Http\Controllers\CoachingAdmin\TeacherAttendanceController::class);
    Route::resource('faculty-attendance', \App\Http\Controllers\CoachingAdmin\FacultyAttendanceController::class);
    Route::resource('exams', \App\Http\Controllers\CoachingAdmin\ExamController::class);
    Route::resource('notices', \App\Http\Controllers\CoachingAdmin\NoticeController::class);
    Route::get('salary-slips/attendance-count', [\App\Http\Controllers\Coaching\SalarySlipController::class, 'getAttendanceCount'])->name('salary-slips.attendance-count');
    Route::resource('salary-slips', \App\Http\Controllers\Coaching\SalarySlipController::class);
    Route::get('salary-slips/{salarySlip}/download', [\App\Http\Controllers\Coaching\SalarySlipController::class, 'download'])->name('salary-slips.download');
    
    // Marks routes
    Route::get('marks', [\App\Http\Controllers\CoachingAdmin\MarkController::class, 'index'])->name('marks.index');
    Route::get('marks/create', [\App\Http\Controllers\CoachingAdmin\MarkController::class, 'create'])->name('marks.create');
    Route::post('marks', [\App\Http\Controllers\CoachingAdmin\MarkController::class, 'store'])->name('marks.store');

    // Institute Settings
    Route::get('settings', [\App\Http\Controllers\CoachingAdmin\SettingController::class, 'edit'])->name('settings.edit');
    Route::patch('settings', [\App\Http\Controllers\CoachingAdmin\SettingController::class, 'update'])->name('settings.update');
});

// Teacher Panel Routes
Route::middleware(['auth', 'role:teacher'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Teacher\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/batches', [\App\Http\Controllers\Teacher\DashboardController::class, 'batches'])->name('batches');
    Route::get('/exams', [\App\Http\Controllers\Teacher\DashboardController::class, 'exams'])->name('exams');
    Route::get('/notices', [\App\Http\Controllers\Teacher\DashboardController::class, 'notices'])->name('notices');
    Route::get('/students', [\App\Http\Controllers\Teacher\DashboardController::class, 'students'])->name('students');
    Route::get('/students/{student}', [\App\Http\Controllers\Teacher\DashboardController::class, 'showStudent'])->name('students.show');
    Route::resource('attendance', \App\Http\Controllers\Teacher\AttendanceController::class);
    Route::get('my-attendance', [\App\Http\Controllers\Teacher\AttendanceController::class, 'myAttendance'])->name('my-attendance');
    
    // Teacher Marks Routes
    Route::get('marks', [\App\Http\Controllers\Teacher\MarkController::class, 'index'])->name('marks.index');
    Route::get('marks/create', [\App\Http\Controllers\Teacher\MarkController::class, 'create'])->name('marks.create');
    Route::post('marks', [\App\Http\Controllers\Teacher\MarkController::class, 'store'])->name('marks.store');

    // Salary Slips
    Route::get('salary-slips', [\App\Http\Controllers\Teacher\SalarySlipController::class, 'index'])->name('salary-slips.index');
    Route::get('salary-slips/{salarySlip}', [\App\Http\Controllers\Teacher\SalarySlipController::class, 'show'])->name('salary-slips.show');
    Route::get('salary-slips/{salarySlip}/download', [\App\Http\Controllers\Teacher\SalarySlipController::class, 'download'])->name('salary-slips.download');

    Route::get('/profile', [\App\Http\Controllers\Teacher\DashboardController::class, 'profile'])->name('profile');
    Route::post('/profile', [\App\Http\Controllers\Teacher\DashboardController::class, 'updateProfile'])->name('profile.update');
});

// Student Panel Routes
Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Student\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/attendance', [\App\Http\Controllers\Student\DashboardController::class, 'attendance'])->name('attendance');
    Route::get('/fees', [\App\Http\Controllers\Student\FeeViewController::class, 'index'])->name('fees');
    Route::get('/fees/{fee}/download', [\App\Http\Controllers\Student\FeeViewController::class, 'downloadReceipt'])->name('fees.download');
    Route::get('/marks', [\App\Http\Controllers\Student\DashboardController::class, 'marks'])->name('marks');
    Route::get('/notices', [\App\Http\Controllers\Student\DashboardController::class, 'notices'])->name('notices');
    Route::get('/profile', [\App\Http\Controllers\Student\DashboardController::class, 'profile'])->name('profile');
    Route::post('/profile', [\App\Http\Controllers\Student\DashboardController::class, 'updateProfile'])->name('profile.update');
});

// Faculty Panel Routes
Route::middleware(['auth', 'role:faculty'])->prefix('faculty')->name('faculty.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Faculty\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/attendance', [\App\Http\Controllers\Faculty\DashboardController::class, 'attendance'])->name('attendance');
    Route::get('/notices', [\App\Http\Controllers\Faculty\DashboardController::class, 'notices'])->name('notices');
    
    // Salary Slips
    Route::get('salary-slips', [\App\Http\Controllers\Faculty\SalarySlipController::class, 'index'])->name('salary-slips.index');
    Route::get('salary-slips/{salarySlip}', [\App\Http\Controllers\Faculty\SalarySlipController::class, 'show'])->name('salary-slips.show');
    Route::get('salary-slips/{salarySlip}/download', [\App\Http\Controllers\Faculty\SalarySlipController::class, 'download'])->name('salary-slips.download');

    Route::get('/profile', [\App\Http\Controllers\Faculty\DashboardController::class, 'profile'])->name('profile');
    Route::post('/profile', [\App\Http\Controllers\Faculty\DashboardController::class, 'updateProfile'])->name('profile.update');
});


require __DIR__.'/auth.php';
