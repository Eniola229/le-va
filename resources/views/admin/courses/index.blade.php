@extends('layouts.admin')
@section('title', 'Courses')
@section('page-title', 'Courses')

@section('topbar-actions')
  <a href="{{ route('admin.courses.create') }}" class="btn btn-primary">+ New Course</a>
@endsection

@section('content')

<div class="card">
  <div class="card-body table-wrap">
    @if($courses->count())
    <table>
      <thead>
        <tr>
          <th>Course</th>
          <th>Lessons</th>
          <th>Students</th>
          <th>Status</th>
          <th>Created</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($courses as $course)
        <tr>
          <td>
            <div style="display:flex;align-items:center;gap:14px;">
              @if($course->cover_image)
                <img src="{{ $course->cover_image }}" alt=""
                     style="width:52px;height:36px;object-fit:cover;border-radius:4px;flex-shrink:0;">
              @else
                <div style="width:52px;height:36px;background:var(--ivory);border-radius:4px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                  <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" style="color:var(--beige-mid);"><path d="M4 19V6a2 2 0 012-2h13a1 1 0 011 1v13"/></svg>
                </div>
              @endif
              <div>
                <div style="font-weight:500;">{{ $course->title }}</div>
                <div class="cell-muted">{{ $course->duration ?? 'No duration set' }}</div>
              </div>
            </div>
          </td>
          <td>{{ $course->lesson_count }}</td>
          <td>{{ $course->enrollments_count }}</td>
          <td><span class="badge badge-{{ $course->status }}">{{ ucfirst($course->status) }}</span></td>
          <td>
            <div>{{ $course->created_at->format('d M Y') }}</div>
          </td>
          <td>
            <div style="display:flex;gap:6px;">
              <a href="{{ route('admin.courses.edit', $course) }}" class="btn-icon" title="Edit">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
              </a>
              <a href="{{ route('admin.courses.lessons.create', $course) }}" class="btn-icon" title="Add Lesson">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
              </a>
              <form method="POST" action="{{ route('admin.courses.destroy', $course) }}">
                @csrf @method('DELETE')
                <button type="submit" class="btn-icon" title="Delete" style="color:var(--danger);"
                  onclick="return confirm('Delete {{ addslashes($course->title) }} and all its lessons?')">
                  <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/></svg>
                </button>
              </form>
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <div class="pagination">
      {{ $courses->links('components.pagination') }}
      <span class="page-info">{{ $courses->total() }} courses total</span>
    </div>
    @else
      <div class="empty-state">
        <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M4 19V6a2 2 0 012-2h13a1 1 0 011 1v13"/><path d="M4 19a2 2 0 002 2h13a1 1 0 001-1v-1"/><path d="M8 10h8M8 14h5"/></svg>
        <h3>No courses yet</h3>
        <p><a href="{{ route('admin.courses.create') }}">Create your first course</a> to get started.</p>
      </div>
    @endif
  </div>
</div>

@endsection