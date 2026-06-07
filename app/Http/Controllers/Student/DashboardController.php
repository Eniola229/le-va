<?php
namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Enrollment;

class DashboardController extends Controller
{
    public function index()
    {
        $user         = auth()->user();
        $enrollments  = $user->enrollments()->with('course')->get();
        $enrolledCount = $enrollments->count();
        $inProgress   = $enrollments->where('progress', '<', 100)->take(3);

        $completedLessons = \App\Models\LessonCompletion::where('user_id', $user->id)->count();

        $overallProgress = $enrollments->count()
            ? (int) round($enrollments->avg('progress'))
            : 0;

        $announcements = Announcement::latest()->limit(3)->get();

        return view('student.dashboard', compact(
            'inProgress',
            'enrollments',
            'enrolledCount',
            'completedLessons',
            'overallProgress',
            'announcements'
        ));
    }
}