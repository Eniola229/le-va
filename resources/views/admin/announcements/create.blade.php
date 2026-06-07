@extends('layouts.admin')
@section('title', 'New Announcement')
@section('page-title', 'New Announcement')

@section('topbar-actions')
  <a href="{{ route('admin.announcements.index') }}" class="btn btn-secondary btn-sm">← Back</a>
@endsection

@section('content')

<div style="max-width:680px;">
  <div class="card">
    <div class="card-header"><span class="card-title">Compose Announcement</span></div>
    <div style="padding:28px;">
      <form method="POST" action="{{ route('admin.announcements.store') }}">
        @csrf

        <div class="form-group">
          <label class="form-label">Subject</label>
          <input type="text" name="title" class="form-control"
                 value="{{ old('title') }}" required
                 placeholder="e.g. New Course Available — Walking with God">
          @error('title')<div class="form-error">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
          <label class="form-label">Message</label>
          <textarea name="body" class="form-control" rows="8"
                    placeholder="Write your announcement here…" required>{{ old('body') }}</textarea>
          @error('body')<div class="form-error">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
          <label class="form-label">Send To</label>
          <select name="audience" class="form-control" required>
            <option value="all"      {{ old('audience')=='all'      ? 'selected':'' }}>All approved students</option>
            <option value="enrolled" {{ old('audience')=='enrolled' ? 'selected':'' }}>Enrolled students only</option>
          </select>
          <div class="form-hint">Emails are queued and sent in batches to avoid timeouts.</div>
        </div>

        <div style="display:flex;gap:10px;margin-top:8px;">
          <button type="submit" class="btn btn-primary">Send Announcement</button>
          <a href="{{ route('admin.announcements.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection


