@extends('layouts.admin')
@section('title', isset($lesson) ? 'Edit Lesson' : 'New Lesson')
@section('page-title', isset($lesson) ? 'Edit Lesson' : 'New Lesson')

@section('topbar-actions')
  <a href="{{ route('admin.courses.edit', $course) }}" class="btn btn-secondary btn-sm">← Back to Course</a>
@endsection

@section('content')

<form method="POST"
      action="{{ isset($lesson) ? route('admin.lessons.update', $lesson) : route('admin.courses.lessons.store', $course) }}"
      enctype="multipart/form-data">
  @csrf
  @if(isset($lesson)) @method('PUT') @endif

  <div style="display:grid;grid-template-columns:1fr 320px;gap:24px;">

    <div>
      <div class="card" style="margin-bottom:20px;">
        <div class="card-header"><span class="card-title">Lesson Details</span></div>
        <div style="padding:24px;">
          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Lesson Title</label>
              <input type="text" name="title" class="form-control"
                     value="{{ old('title', $lesson->title ?? '') }}" required>
              @error('title')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
              <label class="form-label">Order</label>
              <input type="number" name="order" class="form-control" min="1"
                     value="{{ old('order', $lesson->order ?? ($course->lessons->count() + 1)) }}">
            </div>
          </div>

          <div class="form-group">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3"
                      placeholder="Brief overview of this lesson">{{ old('description', $lesson->description ?? '') }}</textarea>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Duration (minutes)</label>
              <input type="number" name="duration_minutes" class="form-control" min="1"
                     value="{{ old('duration_minutes', $lesson->duration_minutes ?? '') }}">
            </div>
            <div class="form-group" style="display:flex;align-items:flex-end;padding-bottom:22px;">
              <label style="display:flex;align-items:center;gap:10px;cursor:pointer;">
                <input type="checkbox" name="is_preview" value="1"
                       {{ old('is_preview', $lesson->is_preview ?? false) ? 'checked' : '' }}
                       style="width:16px;height:16px;accent-color:var(--brown);">
                <span style="font-size:14px;">Free preview lesson</span>
              </label>
            </div>
          </div>
        </div>
      </div>

      {{-- Video Upload --}}
      <div class="card" style="margin-bottom:20px;">
        <div class="card-header"><span class="card-title">Video</span></div>
        <div style="padding:24px;">
          @if(isset($lesson) && $lesson->video_url)
          <div style="margin-bottom:16px;padding:14px;background:var(--cream);border-radius:var(--radius-sm);display:flex;align-items:center;gap:12px;">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="color:var(--gold);flex-shrink:0;"><polygon points="5 3 19 12 5 21 5 3"/></svg>
            <span style="font-size:13px;color:var(--text-muted);">Video uploaded via Cloudinary</span>
            <a href="{{ $lesson->video_url }}" target="_blank" class="btn btn-secondary btn-sm" style="margin-left:auto;">Preview</a>
          </div>
          <p style="font-size:13px;color:var(--text-hint);margin-bottom:12px;">Upload a new video to replace the existing one:</p>
          @endif
          <label class="upload-zone" for="video">
            <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" style="color:var(--beige-mid);"><polygon points="5 3 19 12 5 21 5 3"/></svg>
            <p>Click to upload video<br><span>MP4, MOV, WebM — max 2GB</span></p>
            <input type="file" name="video" id="video" accept="video/*" style="display:none;" id="videoInput">
          </label>
          <div id="videoProgress" style="display:none;margin-top:12px;">
            <div style="height:4px;background:var(--beige);border-radius:2px;overflow:hidden;">
              <div id="videoProgressBar" style="height:100%;width:0%;background:var(--gold);transition:width 0.3s;"></div>
            </div>
            <p style="font-size:12px;color:var(--text-hint);margin-top:6px;" id="videoProgressText">Uploading…</p>
          </div>
        </div>
      </div>

      {{-- Resources --}}
      @isset($lesson)
      <div class="card">
        <div class="card-header">
          <span class="card-title">Downloadable Resources</span>
          <button type="button" class="btn btn-secondary btn-sm" onclick="document.getElementById('resourceInput').click()">+ Attach File</button>
        </div>
        <div style="padding:20px;">
          <input type="file" id="resourceInput" name="resource_files[]" multiple
                 accept=".pdf,.docx,.xlsx,.pptx,.zip" style="display:none;"
                 form="resourceForm">

          @if($lesson->resources->count())
            @foreach($lesson->resources as $res)
            <div style="display:flex;align-items:center;gap:12px;padding:10px 0;border-bottom:1px solid var(--ivory);">
              <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="color:var(--brown-light);flex-shrink:0;"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
              <div style="flex:1;">
                <div style="font-size:14px;">{{ $res->title }}</div>
                <div style="font-size:12px;color:var(--text-hint);">{{ strtoupper($res->file_type) }}</div>
              </div>
              <a href="{{ $res->file_url }}" target="_blank" class="btn-icon">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
              </a>
              <form method="POST" action="{{ route('admin.resources.destroy', $res) }}">
                @csrf @method('DELETE')
                <button type="submit" class="btn-icon" style="color:var(--danger);"
                  onclick="return confirm('Remove this resource?')">
                  <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/></svg>
                </button>
              </form>
            </div>
            @endforeach
          @else
            <p style="font-size:14px;color:var(--text-hint);">No resources attached yet.</p>
          @endif
        </div>
      </div>
      @endisset
    </div>

    {{-- Sidebar --}}
    <div>
      <div class="card">
        <div style="padding:20px;">
          <div style="font-size:13px;color:var(--text-hint);margin-bottom:16px;">Part of course:</div>
          <div style="font-family:var(--font-serif);font-size:16px;color:var(--text-primary);margin-bottom:20px;">
            {{ $course->title }}
          </div>
          <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;">
            {{ isset($lesson) ? 'Update Lesson' : 'Save Lesson' }}
          </button>
        </div>
      </div>
    </div>

  </div>
</form>

@endsection
