<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use App\Services\CloudinaryService;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function __construct(private CloudinaryService $cloudinary) {}

    public function index(Course $course)
    {
        $lessons = $course->lessons()
                          ->withCount('resources')
                          ->orderBy('order')
                          ->get();
 
        return view('admin.lessons.index', compact('course', 'lessons'));
    }
 
    public function create(Course $course)
    {
        return view('admin.lessons.form', compact('course'));
    }

    public function store(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title'            => 'required|string|max:200',
            'description'      => 'nullable|string',
            'order'            => 'required|integer|min:1',
            'duration_minutes' => 'nullable|integer|min:1',
            'is_preview'       => 'boolean',
            'video'            => 'nullable|file|mimetypes:video/mp4,video/quicktime,video/webm|max:2097152',
        ]);

        $validated['course_id']  = $course->id;
        $validated['is_preview'] = $request->has('is_preview');

        if ($request->hasFile('video')) {
            $upload = $this->cloudinary->uploadVideo($request->file('video'), 'lev-av/lessons');
            $validated['video_url']       = $upload['url'];
            $validated['video_public_id'] = $upload['public_id'];
        }

        Lesson::create($validated);
        $course->update(['lesson_count' => $course->lessons()->count()]);

        return redirect()->route('admin.courses.edit', $course)
                         ->with('success', 'Lesson added successfully.');
    }

    public function edit(Lesson $lesson)
    {
        $lesson->load('resources');
        $course = $lesson->course;
        return view('admin.lessons.form', compact('lesson', 'course'));
    }

    public function update(Request $request, Lesson $lesson)
    {
        $validated = $request->validate([
            'title'            => 'required|string|max:200',
            'description'      => 'nullable|string',
            'order'            => 'required|integer|min:1',
            'duration_minutes' => 'nullable|integer|min:1',
            'is_preview'       => 'boolean',
            'video'            => 'nullable|file|mimetypes:video/mp4,video/quicktime,video/webm|max:2097152',
        ]);

        $validated['is_preview'] = $request->has('is_preview');

        if ($request->hasFile('video')) {
            // Delete old from Cloudinary
            if ($lesson->video_public_id) {
                $this->cloudinary->delete($lesson->video_public_id, 'video');
            }
            $upload = $this->cloudinary->uploadVideo($request->file('video'), 'lev-av/lessons');
            $validated['video_url']       = $upload['url'];
            $validated['video_public_id'] = $upload['public_id'];
        }

        $lesson->update($validated);

        return back()->with('success', 'Lesson updated.');
    }

    public function destroy(Lesson $lesson)
    {
        $course = $lesson->course;
        if ($lesson->video_public_id) {
            $this->cloudinary->delete($lesson->video_public_id, 'video');
        }
        $lesson->delete();
        $course->update(['lesson_count' => $course->lessons()->count()]);

        return redirect()->route('admin.courses.edit', $course)
                         ->with('success', 'Lesson deleted.');
    }
}


