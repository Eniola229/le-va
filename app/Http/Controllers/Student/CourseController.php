<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Services\BrevoMailService;
use App\Services\EmailTemplates;

class CourseController extends Controller
{
    public function __construct(private BrevoMailService $brevo) {}

    public function index()
    {
        $enrollments = auth()->user()
            ->enrollments()
            ->with('course')
            ->latest()
            ->get();

        return view('student.courses.index', compact('enrollments'));
    }

    public function show(Course $course)
    {
        // Must be enrolled
        $enrollment = auth()->user()
            ->enrollments()
            ->where('course_id', $course->id)
            ->firstOrFail();

        $lessons = $course->lessons()->orderBy('order')->with('resources')->get();

        // IDs of lessons the student has completed
        $completedIds = \App\Models\LessonCompletion::where('user_id', auth()->id())
            ->whereIn('lesson_id', $lessons->pluck('id'))
            ->pluck('lesson_id')
            ->toArray();

        // Resume: first incomplete lesson, or first lesson
        $currentLesson = $lessons->first(fn($l) => !in_array($l->id, $completedIds))
                      ?? $lessons->first();

        return view('student.courses.show', compact(
            'course', 'enrollment', 'lessons', 'currentLesson', 'completedIds'
        ));
    }

    // Called from public courses page
    public function enroll(Course $course)
    {
        $user = auth()->user();

        // Already enrolled?
        if ($user->enrollments()->where('course_id', $course->id)->exists()) {
            return redirect()->route('student.courses.show', $course);
        }

        \App\Models\Enrollment::create([
            'user_id'   => $user->id,
            'course_id' => $course->id,
        ]);

        $courseUrl = route('student.courses.show', $course);

        $this->brevo->send(
            ['email' => $user->email, 'name' => $user->name],
            "You're enrolled in {$course->title}",
            EmailTemplates::newCourseEnrolled($user->name, $course->title, $courseUrl)
        );

        return redirect()->route('student.courses.show', $course)
                         ->with('success', "You're enrolled in {$course->title}. Welcome!");
    }
}

