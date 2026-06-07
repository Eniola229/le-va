<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalStudents'   => User::where('role', 'student')->count(),
            'pendingApprovals'=> User::where('role', 'student')->where('status', 'pending')->count(),
            'totalCourses'    => Course::count(),
            'totalEnrollments'=> Enrollment::count(),
            'recentPending'   => User::where('role','student')->where('status','pending')
                                     ->latest()->limit(5)->get(),
            'recentCourses'   => Course::withCount('enrollments')->latest()->limit(5)->get(),
        ]);
    }
}
