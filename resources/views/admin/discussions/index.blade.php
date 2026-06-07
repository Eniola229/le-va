@extends('layouts.admin')
@section('title', 'Discussions')
@section('page-title', 'Course Discussions')

@section('topbar-actions')
  {{-- Filter by course --}}
  <form method="GET" style="display:flex;gap:8px;">
    <select name="course_id" class="form-control" style="width:220px;padding:8px 12px;background:#faf8f5;border:1px solid #ddd6cc;border-radius:6px;font-family:'Jost',sans-serif;font-size:13px;" onchange="this.form.submit()">
      <option value="">All Courses</option>
      @foreach($courses as $c)
        <option value="{{ $c->id }}" {{ request('course_id') == $c->id ? 'selected' : '' }}>
          {{ $c->title }}
        </option>
      @endforeach
    </select>
  </form>
@endsection

@section('content')

<style>
.card {
  background: #fff;
  border: 1px solid #ede8e0;
  border-radius: 10px;
  overflow: hidden;
}
.card-body {
  padding: 0;
}
.table-wrap {
  overflow-x: auto;
}
table {
  width: 100%;
  border-collapse: collapse;
}
th {
  text-align: left;
  padding: 14px 16px;
  font-family: 'Jost', sans-serif;
  font-size: 12px;
  font-weight: 500;
  letter-spacing: 0.07em;
  text-transform: uppercase;
  color: #8a7d72;
  background: #faf8f5;
  border-bottom: 1px solid #ede8e0;
}
td {
  padding: 14px 16px;
  font-family: 'Jost', sans-serif;
  font-size: 13px;
  color: #3a2e26;
  border-bottom: 1px solid #f5f0ea;
}
tr:hover td {
  background: #fefcf9;
}
.cell-muted {
  font-size: 12px;
  color: #9e9080;
  margin-top: 4px;
}
.badge {
  display: inline-block;
  padding: 3px 10px;
  font-family: 'Jost', sans-serif;
  font-size: 11px;
  font-weight: 500;
  letter-spacing: 0.05em;
  text-transform: uppercase;
  border-radius: 20px;
}
.badge-approved {
  background: #e8f5e9;
  color: #2e7d32;
}
.badge-pending {
  background: #fff3e0;
  color: #e65100;
}
.btn-icon {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 32px;
  height: 32px;
  background: transparent;
  border: 1px solid #ede8e0;
  border-radius: 6px;
  cursor: pointer;
  color: #9e9080;
  transition: all .2s;
}
.btn-icon:hover {
  background: #faf8f5;
  border-color: #b89b6a;
  color: #b89b6a;
}
.pagination {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 16px 20px;
  border-top: 1px solid #ede8e0;
  flex-wrap: wrap;
  gap: 12px;
}
.page-info {
  font-size: 12px;
  color: #9e9080;
}
.empty-state {
  text-align: center;
  padding: 60px 20px;
}
.empty-state svg {
  width: 48px;
  height: 48px;
  color: #b89b6a;
  margin-bottom: 16px;
}
.empty-state h3 {
  font-family: 'Cormorant Garamond', serif;
  font-size: 18px;
  font-weight: 500;
  color: #3a2e26;
  margin-bottom: 8px;
}
.empty-state p {
  font-size: 13px;
  color: #9e9080;
}
</style>

<div class="card">
  <div class="card-body table-wrap">
    @if($discussions->count())
    <table>
      <thead>
        <tr>
          <th>Question</th>
          <th>Course</th>
          <th>Student</th>
          <th>Replies</th>
          <th>Asked</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($discussions as $discussion)
        <tr>
          <td>
            <div style="display:flex;align-items:center;gap:8px;">
              @if($discussion->is_pinned)
                <span style="font-size:14px;" title="Pinned">📌</span>
              @endif
              <div>
                <div style="font-weight:500;max-width:280px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                  {{ $discussion->title }}
                </div>
                <div class="cell-muted">{{ Str::limit($discussion->body, 60) }}</div>
              </div>
            </div>
          </td>
          <td>
            <div style="font-size:13px;max-width:200px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $discussion->course->title }}</div>
          </td>
          <td>
            <div style="font-size:13px;">{{ $discussion->user->name }}</div>
          </td>
          <td>
            <span class="{{ $discussion->replies_count == 0 ? 'badge badge-pending' : 'badge badge-approved' }}">
              {{ $discussion->replies_count }} {{ $discussion->replies_count == 1 ? 'reply' : 'replies' }}
            </span>
          </td>
          <td>{{ $discussion->created_at->format('d M Y') }}</td>
          <td>
            <div style="display:flex;gap:6px;">
              <a href="{{ route('admin.discussions.show', $discussion) }}" class="btn-icon" title="View & Reply">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
              </a>
              <form method="POST" action="{{ route('admin.discussions.pin', $discussion) }}" style="display:inline;">
                @csrf
                <button type="submit" class="btn-icon" title="{{ $discussion->is_pinned ? 'Unpin' : 'Pin' }}"
                  style="{{ $discussion->is_pinned ? 'color:#b89b6a;border-color:#b89b6a;' : '' }}">
                  <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="17" x2="12" y2="22"/><path d="M5 17h14v-1.76a2 2 0 00-1.11-1.79l-1.78-.9A2 2 0 0115 10.76V6h1a2 2 0 000-4H8a2 2 0 000 4h1v4.76a2 2 0 01-1.11 1.79l-1.78.9A2 2 0 005 15.24V17z"/></svg>
                </button>
              </form>
              <form method="POST" action="{{ route('admin.discussions.destroy', $discussion) }}" style="display:inline;">
                @csrf @method('DELETE')
                <button type="submit" class="btn-icon" title="Delete" style="color:#c0392b;"
                  onclick="return confirm('Delete this discussion?')">
                  <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/></svg>
                </button>
              </form>
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <div class="pagination">
      {{ $discussions->links('components.pagination') }}
      <span class="page-info">{{ $discussions->total() }} questions total</span>
    </div>
    @else
      <div class="empty-state">
        <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
        <h3>No discussions yet</h3>
        <p>Questions from students will appear here.</p>
      </div>
    @endif
  </div>
</div>

@endsection