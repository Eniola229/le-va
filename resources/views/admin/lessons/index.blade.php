@extends('layouts.admin')
@section('title', 'Lessons — ' . $course->title)
@section('page-title', 'Lessons')

@section('topbar-actions')
  <a href="{{ route('admin.courses.edit', $course) }}" class="btn btn-secondary btn-sm">← Course</a>
  <a href="{{ route('admin.courses.lessons.create', $course) }}" class="btn btn-primary">+ Add Lesson</a>
@endsection

@section('content')

{{-- Course context bar --}}
<div style="display:flex;align-items:center;gap:14px;margin-bottom:24px;padding:16px 20px;background:var(--warm-white);border:1px solid var(--beige);border-radius:var(--radius-md);">
  @if($course->cover_image)
    <img src="{{ $course->cover_image }}" alt="" style="width:56px;height:40px;object-fit:cover;border-radius:4px;flex-shrink:0;">
  @endif
  <div>
    <div style="font-family:var(--font-serif);font-size:17px;">{{ $course->title }}</div>
    <div style="font-size:12px;color:var(--text-hint);">{{ $course->lesson_count }} lessons &nbsp;·&nbsp; {{ $course->duration ?? 'No duration' }}</div>
  </div>
  <span class="badge badge-{{ $course->status }}" style="margin-left:auto;">{{ ucfirst($course->status) }}</span>
</div>

<div class="card">
  <div class="card-body table-wrap">
    @if($lessons->count())
    <table>
      <thead>
        <tr>
          <th style="width:48px;">#</th>
          <th>Lesson</th>
          <th>Duration</th>
          <th>Video</th>
          <th>Resources</th>
          <th>Preview</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody id="lessonRows">
        @foreach($lessons as $lesson)
        <tr data-id="{{ $lesson->id }}">
          <td style="color:var(--text-hint);font-size:13px;">{{ $lesson->order }}</td>
          <td>
            <div style="font-weight:500;">{{ $lesson->title }}</div>
            @if($lesson->description)
              <div class="cell-muted">{{ Str::limit($lesson->description, 70) }}</div>
            @endif
          </td>
          <td>{{ $lesson->duration_minutes ? $lesson->duration_minutes.' min' : '—' }}</td>
          <td>
            @if($lesson->video_url)
              <span style="display:inline-flex;align-items:center;gap:5px;font-size:12px;color:var(--success);">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                Uploaded
              </span>
            @else
              <span style="font-size:12px;color:var(--text-hint);">No video</span>
            @endif
          </td>
          <td>
            @if($lesson->resources_count > 0)
              <span class="badge badge-gold">{{ $lesson->resources_count }} file(s)</span>
            @else
              <span style="font-size:12px;color:var(--text-hint);">—</span>
            @endif
          </td>
          <td>
            @if($lesson->is_preview)
              <span class="badge badge-gold">Free</span>
            @else
              <span style="font-size:12px;color:var(--text-hint);">—</span>
            @endif
          </td>
          <td>
            <div style="display:flex;gap:6px;">
              <a href="{{ route('admin.lessons.edit', $lesson) }}" class="btn-icon" title="Edit">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
              </a>
              <form method="POST" action="{{ route('admin.lessons.destroy', $lesson) }}">
                @csrf @method('DELETE')
                <button type="submit" class="btn-icon" title="Delete" style="color:var(--danger);"
                  onclick="return confirm('Delete this lesson?')">
                  <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/></svg>
                </button>
              </form>
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    @else
      <div class="empty-state">
        <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><polygon points="5 3 19 12 5 21 5 3"/></svg>
        <h3>No lessons yet</h3>
        <p><a href="{{ route('admin.courses.lessons.create', $course) }}">Add the first lesson</a> to this course.</p>
      </div>
    @endif
  </div>
</div>

@endsection