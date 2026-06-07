<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Discussion;
use App\Models\DiscussionReply;
use Illuminate\Http\Request;

class DiscussionController extends Controller
{
    // All discussions across all courses
    public function index(Request $request)
    {
        $discussions = Discussion::with(['course','user'])
            ->withCount('replies')
            ->when($request->course_id, fn($q) => $q->where('course_id', $request->course_id))
            ->latest()
            ->paginate(20);

        $courses = Course::orderBy('title')->get();

        return view('admin.discussions.index', compact('discussions', 'courses'));
    }

    // Show discussion + reply as tutor
    public function show(Discussion $discussion)
    {
        $discussion->load(['course','user','replies.user']);
        return view('admin.discussions.show', compact('discussion'));
    }

    // Admin/tutor reply
    public function reply(Request $request, Discussion $discussion)
    {
        $request->validate(['body' => 'required|string|max:3000']);

        DiscussionReply::create([
            'discussion_id'  => $discussion->id,
            'user_id'        => auth()->id(),
            'body'           => $request->body,
            'is_tutor_reply' => true,
        ]);

        $discussion->increment('replies_count');

        return back()->with('success', 'Reply posted.');
    }

    // Pin / unpin a discussion
    public function togglePin(Discussion $discussion)
    {
        $discussion->update(['is_pinned' => !$discussion->is_pinned]);
        return back()->with('success', $discussion->is_pinned ? 'Question pinned.' : 'Question unpinned.');
    }

    // Delete any discussion
    public function destroy(Discussion $discussion)
    {
        $discussion->delete();
        return back()->with('success', 'Discussion deleted.');
    }

    // Delete any reply
    public function destroyReply(DiscussionReply $reply)
    {
        $reply->discussion->decrement('replies_count');
        $reply->delete();
        return back()->with('success', 'Reply deleted.');
    }
}
