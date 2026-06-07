<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Services\CloudinaryService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    public function __construct(private CloudinaryService $cloudinary) {}

    public function index()
    {
        $courses = Course::withCount('enrollments')->latest()->paginate(15);
        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        return view('admin.courses.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'               => 'required|string|max:200',
            'description'         => 'required|string',
            'what_you_will_learn' => 'nullable|string',
            'duration'            => 'nullable|string|max:50',
            'status'              => 'in:draft,published',
            'cover_image'         => 'nullable|image|max:5120',
        ]);

        $validated['slug']       = Str::slug($validated['title']);
        $validated['created_by'] = auth()->id();
        $validated['status']     = $request->action === 'publish' ? 'published' : 'draft';

        if ($request->hasFile('cover_image')) {
            $upload = $this->cloudinary->uploadImage($request->file('cover_image'), 'lev-av/courses');
            $validated['cover_image'] = $upload['url'];
        }

        $course = Course::create($validated);

        return redirect()->route('admin.courses.edit', $course)
                         ->with('success', 'Course created. Add lessons below.');
    }

    public function edit(Course $course)
    {
        $course->load('lessons');
        return view('admin.courses.form', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title'               => 'required|string|max:200',
            'description'         => 'required|string',
            'what_you_will_learn' => 'nullable|string',
            'duration'            => 'nullable|string|max:50',
            'status'              => 'in:draft,published',
            'cover_image'         => 'nullable|image|max:5120',
        ]);

        $validated['status'] = $request->action === 'publish' ? 'published' : $validated['status'];

        if ($request->hasFile('cover_image')) {
            $upload = $this->cloudinary->uploadImage($request->file('cover_image'), 'lev-av/courses');
            $validated['cover_image'] = $upload['url'];
        }

        $course->update($validated);
        $course->update(['lesson_count' => $course->lessons()->count()]);

        return back()->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('admin.courses.index')->with('success', 'Course deleted.');
    }
}


