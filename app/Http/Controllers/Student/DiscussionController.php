<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Discussion;
use App\Models\DiscussionReply;
use Illuminate\Http\Request;

class DiscussionController extends Controller
{
    // List all discussions for a course
    public function index(Course $course)
    {
        // Must be enrolled
        auth()->user()->enrollments()->where('course_id', $course->id)->firstOrFail();

        $discussions = Discussion::where('course_id', $course->id)
            ->with('user')
            ->withCount('replies')
            ->orderByDesc('is_pinned')
            ->latest()
            ->paginate(15);

        return view('student.discussions.index', compact('course', 'discussions'));
    }

    // Show single discussion + all replies
    public function show(Course $course, Discussion $discussion)
    {
        auth()->user()->enrollments()->where('course_id', $course->id)->firstOrFail();

        $discussion->load(['user', 'replies.user']);

        return view('student.discussions.show', compact('course', 'discussion'));
    }

    // Post a new question
    public function store(Request $request, Course $course)
    {
        auth()->user()->enrollments()->where('course_id', $course->id)->firstOrFail();

        $request->validate([
            'title' => 'required|string|max:200',
            'body'  => 'required|string|max:3000',
        ]);

        Discussion::create([
            'course_id' => $course->id,
            'user_id'   => auth()->id(),
            'title'     => $request->title,
            'body'      => $request->body,
        ]);

        return redirect()
            ->route('student.discussions.index', $course)
            ->with('success', 'Your question has been posted.');
    }

    // Post a reply (student or admin)
    public function reply(Request $request, Course $course, Discussion $discussion)
    {
        $request->validate([
            'body' => 'required|string|max:3000',
        ]);

        $isTutor = auth()->user()->isAdmin();

        DiscussionReply::create([
            'discussion_id'  => $discussion->id,
            'user_id'        => auth()->id(),
            'body'           => $request->body,
            'is_tutor_reply' => $isTutor,
        ]);

        // Update replies count
        $discussion->increment('replies_count');

        return back()->with('success', 'Reply posted.');
    }

    // Delete own question
    public function destroy(Course $course, Discussion $discussion)
    {
        if ($discussion->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $discussion->delete();

        return redirect()
            ->route('student.discussions.index', $course)
            ->with('success', 'Question deleted.');
    }

    // Delete a reply
    public function destroyReply(Course $course, Discussion $discussion, DiscussionReply $reply)
    {
        if ($reply->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $reply->delete();
        $discussion->decrement('replies_count');

        return back()->with('success', 'Reply removed.');
    }
}


