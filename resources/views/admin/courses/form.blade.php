@extends('layouts.admin')
@section('title', isset($course) ? 'Edit Course' : 'New Course')
@section('page-title', isset($course) ? 'Edit Course' : 'New Course')

@section('topbar-actions')
  <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary btn-sm">← Back</a>
@endsection

@section('content')

<form method="POST"
      action="{{ isset($course) ? route('admin.courses.update', $course) : route('admin.courses.store') }}"
      enctype="multipart/form-data">
  @csrf
  @if(isset($course)) @method('PUT') @endif

  <div style="display:grid;grid-template-columns:1fr 360px;gap:24px;">

    {{-- Main --}}
    <div>
      <div class="card" style="margin-bottom:20px;">
        <div class="card-header"><span class="card-title">Course Details</span></div>
        <div style="padding:24px;">
          <div class="form-group">
            <label class="form-label">Course Title</label>
            <input type="text" name="title" class="form-control"
                   value="{{ old('title', $course->title ?? '') }}" required
                   placeholder="e.g. Walking with God: A 6-Week Journey">
            @error('title')<div class="form-error">{{ $message }}</div>@enderror
          </div>

          <div class="form-group">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="5"
                      placeholder="What is this course about?">{{ old('description', $course->description ?? '') }}</textarea>
            @error('description')<div class="form-error">{{ $message }}</div>@enderror
          </div>

          <div class="form-group">
            <label class="form-label">What Students Will Learn</label>
            <textarea name="what_you_will_learn" class="form-control" rows="4"
                      placeholder="Key outcomes — one per line">{{ old('what_you_will_learn', $course->what_you_will_learn ?? '') }}</textarea>
            <div class="form-hint">One learning outcome per line.</div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Duration</label>
              <input type="text" name="duration" class="form-control"
                     value="{{ old('duration', $course->duration ?? '') }}"
                     placeholder="e.g. 8 Weeks">
            </div>
            <div class="form-group">
              <label class="form-label">Status</label>
              <select name="status" class="form-control">
                <option value="draft"     {{ old('status', $course->status ?? 'draft') == 'draft'     ? 'selected' : '' }}>Draft</option>
                <option value="published" {{ old('status', $course->status ?? '') == 'published' ? 'selected' : '' }}>Published</option>
              </select>
            </div>
          </div>
        </div>
      </div>

      {{-- Lessons list (only on edit) --}}
      @isset($course)
      <div class="card">
        <div class="card-header">
          <span class="card-title">Lessons ({{ $course->lessons->count() }})</span>
          <a href="{{ route('admin.courses.lessons.create', $course) }}" class="btn btn-primary btn-sm">+ Add Lesson</a>
        </div>
        <div class="card-body table-wrap">
          @if($course->lessons->count())
          <table>
            <thead><tr><th>#</th><th>Title</th><th>Duration</th><th>Preview</th><th></th></tr></thead>
            <tbody>
              @foreach($course->lessons->sortBy('order') as $lesson)
              <tr>
                <td style="color:var(--text-hint);">{{ $lesson->order }}</td>
                <td>{{ $lesson->title }}</td>
                <td>{{ $lesson->duration_minutes ? $lesson->duration_minutes.' min' : '—' }}</td>
                <td>
                  @if($lesson->is_preview)
                    <span class="badge badge-gold">Preview</span>
                  @else
                    <span style="color:var(--text-hint);font-size:12px;">—</span>
                  @endif
                </td>
                <td>
                  <div style="display:flex;gap:6px;">
                    <a href="{{ route('admin.lessons.edit', $lesson) }}" class="btn-icon" title="Edit">
                      <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    </a>
                    <form method="POST" action="{{ route('admin.lessons.destroy', $lesson) }}">
                      @csrf @method('DELETE')
                      <button type="submit" class="btn-icon" title="Delete"
                        onclick="return confirm('Delete this lesson?')" style="color:var(--danger);">
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
            <div class="empty-state" style="padding:40px;">
              <p>No lessons yet. <a href="{{ route('admin.courses.lessons.create', $course) }}">Add the first lesson.</a></p>
            </div>
          @endif
        </div>
      </div>
      @endisset
    </div>

    {{-- Sidebar --}}
    <div>
      <div class="card" style="margin-bottom:20px;">
        <div class="card-header"><span class="card-title">Cover Image</span></div>
        <div style="padding:20px;">
          @if(isset($course) && $course->cover_image)
          <img src="{{ $course->cover_image }}" alt="Cover"
               style="width:100%;border-radius:var(--radius-sm);margin-bottom:14px;aspect-ratio:16/9;object-fit:cover;">
          @endif
          <label class="upload-zone" for="cover_image">
            <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
            <p>Click to upload<br><span>JPG, PNG — max 5MB</span></p>
            <input type="file" name="cover_image" id="cover_image" accept="image/*" style="display:none;">
          </label>
        </div>
      </div>

      <div class="card">
        <div style="padding:20px;">
          <button type="submit" name="action" value="save_draft" class="btn btn-secondary" style="width:100%;margin-bottom:10px;justify-content:center;">
            Save Draft
          </button>
          <button type="submit" name="action" value="publish" class="btn btn-primary" style="width:100%;justify-content:center;">
            {{ isset($course) && $course->status === 'published' ? 'Update Course' : 'Publish Course' }}
          </button>
        </div>
      </div>
    </div>

  </div>
</form>

@endsection