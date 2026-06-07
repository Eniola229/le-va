<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\LessonCompletion;
use App\Models\Enrollment;

class LessonController extends Controller
{
    public function show(Course $course, Lesson $lesson)
    {
        // Must be enrolled
        $enrollment = auth()->user()
            ->enrollments()
            ->where('course_id', $course->id)
            ->firstOrFail();

        $lessons = $course->lessons()->orderBy('order')->with('resources')->get();

        $completedIds = LessonCompletion::where('user_id', auth()->id())
            ->whereIn('lesson_id', $lessons->pluck('id'))
            ->pluck('lesson_id')
            ->toArray();

        $currentLesson = $lesson->load('resources');

        return view('student.courses.show', compact(
            'course', 'enrollment', 'lessons', 'currentLesson', 'completedIds'
        ));
    }

    public function complete(Course $course, Lesson $lesson)
    {
        $userId = auth()->id();

        // Idempotent — mark complete once
        LessonCompletion::firstOrCreate([
            'user_id'   => $userId,
            'lesson_id' => $lesson->id,
        ]);

        // Update enrollment progress
        $this->updateProgress($userId, $course);

        return back()->with('success', 'Lesson marked as complete.');
    }

    private function updateProgress(string $userId, Course $course): void
    {
        $totalLessons = $course->lessons()->count();
        if ($totalLessons === 0) return;

        $completedCount = LessonCompletion::where('user_id', $userId)
            ->whereIn('lesson_id', $course->lessons()->pluck('id'))
            ->count();

        $progress = (int) round(($completedCount / $totalLessons) * 100);

        Enrollment::where('user_id', $userId)
                  ->where('course_id', $course->id)
                  ->update(['progress' => $progress]);
    }
}

