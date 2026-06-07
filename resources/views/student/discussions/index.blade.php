@extends('layouts.student')
@section('title', 'Discussions — ' . $course->title)
@section('page-title', 'Course Discussions')

@section('topbar-actions')
  <a href="{{ route('student.courses.show', $course) }}" style="font-size:13px;color:var(--text-muted);text-decoration:none;">← Back to Course</a>
@endsection

@section('content')

<style>
/* Inline CSS fixes for modal and empty state */
.modal-overlay {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0,0,0,0.5);
  z-index: 9999;
  align-items: center;
  justify-content: center;
}
.modal-overlay.open {
  display: flex;
}
.modal {
  background: white;
  border-radius: 12px;
  width: 90%;
  max-width: 560px;
  max-height: 90vh;
  overflow-y: auto;
  box-shadow: 0 20px 60px rgba(0,0,0,0.3);
}
.modal-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 20px 24px;
  border-bottom: 1px solid #ede8e0;
}
.modal-title {
  font-family: 'Cormorant Garamond', serif;
  font-size: 20px;
  font-weight: 500;
  color: #3a2e26;
}
.modal-close {
  background: none;
  border: none;
  cursor: pointer;
  padding: 4px;
  color: #9e9080;
}
.modal-body {
  padding: 24px;
}
.modal-footer {
  display: flex;
  justify-content: flex-end;
  gap: 12px;
  padding: 16px 24px 24px;
  border-top: 1px solid #ede8e0;
}
.empty-state {
  text-align: center;
  padding: 60px 20px;
  background: #faf8f5;
  border: 1px solid #ede8e0;
  border-radius: 12px;
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
.btn {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  height: 38px;
  padding: 0 20px;
  font-family: 'Jost', sans-serif;
  font-size: 13px;
  font-weight: 500;
  letter-spacing: 0.04em;
  border-radius: 6px;
  border: none;
  cursor: pointer;
  transition: opacity .15s, background .15s;
  text-decoration: none;
}
.btn-primary {
  background: #3a2e26;
  color: #fff;
}
.btn-primary:hover { opacity: .85; }
.btn-secondary {
  background: transparent;
  color: #3a2e26;
  border: 1px solid #ddd6cc;
}
.btn-secondary:hover { border-color: #b89b6a; }
.btn-sm {
  height: 32px;
  padding: 0 16px;
  font-size: 12px;
}
.form-group {
  margin-bottom: 20px;
}
.form-label {
  display: block;
  font-family: 'Jost', sans-serif;
  font-size: 12px;
  font-weight: 500;
  letter-spacing: 0.07em;
  text-transform: uppercase;
  color: #8a7d72;
  margin-bottom: 7px;
}
.form-control {
  width: 100%;
  box-sizing: border-box;
  height: 40px;
  padding: 0 13px;
  font-family: 'Jost', sans-serif;
  font-size: 14px;
  color: #3a2e26;
  background: #faf8f5;
  border: 1px solid #ddd6cc;
  border-radius: 6px;
  outline: none;
  transition: border-color .15s, box-shadow .15s;
}
.form-control:focus {
  border-color: #b89b6a;
  box-shadow: 0 0 0 3px rgba(184,155,106,.12);
  background: #fff;
}
textarea.form-control {
  height: auto;
  padding: 10px 13px;
  resize: vertical;
}
.pagination {
  display: flex;
  justify-content: center;
  gap: 8px;
  margin-top: 20px;
}
</style>

{{-- Course context --}}
<div style="display:flex;align-items:center;gap:14px;margin-bottom:28px;padding:16px 20px;background:#faf8f5;border:1px solid #ede8e0;border-radius:10px;">
  <div>
    <div style="font-family:'Cormorant Garamond',serif;font-size:17px;color:#3a2e26;">{{ $course->title }}</div>
    <div style="font-size:12px;color:#9e9080;">{{ $discussions->total() }} question(s)</div>
  </div>
  <button onclick="document.getElementById('askModal').classList.add('open')"
          class="btn btn-primary btn-sm" style="margin-left:auto;">
    + Ask a Question
  </button>
</div>

{{-- Discussions list --}}
@if($discussions->count())
  <div style="display:flex;flex-direction:column;gap:12px;margin-bottom:28px;">
    @foreach($discussions as $discussion)
    <a href="{{ route('student.discussions.show', [$course, $discussion]) }}"
       style="display:block;background:#faf8f5;border:1px solid #ede8e0;border-radius:10px;padding:20px 22px;transition:all .2s;text-decoration:none;color:inherit;"
       onmouseover="this.style.boxShadow='0 4px 16px rgba(93,62,34,0.09)'"
       onmouseout="this.style.boxShadow='none'">
      <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:16px;">
        <div style="flex:1;">
          <div style="display:flex;align-items:center;gap:8px;margin-bottom:6px;flex-wrap:wrap;">
            @if($discussion->is_pinned)
              <span style="font-size:11px;background:#f7f0e4;color:#8a6e4b;padding:2px 8px;border-radius:20px;letter-spacing:.5px;">📌 Pinned</span>
            @endif
            <span style="font-family:'Cormorant Garamond',serif;font-size:17px;color:#3a2e26;">{{ $discussion->title }}</span>
          </div>
          <p style="font-size:13px;color:#9e9080;margin-bottom:10px;line-height:1.5;">{{ Str::limit($discussion->body, 120) }}</p>
          <div style="display:flex;align-items:center;gap:16px;font-size:12px;color:#9e9080;flex-wrap:wrap;">
            <span>
              <span style="color:#6b5c4e;font-weight:500;">{{ $discussion->user->name }}</span>
              @if($discussion->user->isAdmin())
                <span style="background:#f7f0e4;color:#8a6e4b;padding:1px 6px;border-radius:3px;font-size:10px;margin-left:4px;">Tutor</span>
              @endif
            </span>
            <span>{{ $discussion->created_at->diffForHumans() }}</span>
          </div>
        </div>
        <div style="flex-shrink:0;text-align:center;padding:10px 16px;background:#fff8f0;border-radius:8px;min-width:52px;">
          <div style="font-family:'Cormorant Garamond',serif;font-size:20px;color:#3a2e26;">{{ $discussion->replies_count }}</div>
          <div style="font-size:10px;text-transform:uppercase;letter-spacing:1px;color:#9e9080;">{{ $discussion->replies_count == 1 ? 'reply' : 'replies' }}</div>
        </div>
      </div>
    </a>
    @endforeach
  </div>
  <div class="pagination">{{ $discussions->links('components.pagination') }}</div>
@else
  <div class="empty-state">
    <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
    <h3>No questions yet</h3>
    <p>Be the first to ask a question about this course.</p>
  </div>
@endif

{{-- Ask question modal --}}
<div class="modal-overlay" id="askModal">
  <div class="modal">
    <div class="modal-header">
      <span class="modal-title">Ask a Question</span>
      <button class="modal-close" onclick="document.getElementById('askModal').classList.remove('open')">
        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
      </button>
    </div>
    <form method="POST" action="{{ route('student.discussions.store', $course) }}">
      @csrf
      <div class="modal-body">
        <div class="form-group">
          <label class="form-label">Question Title</label>
          <input type="text" name="title" class="form-control" required
                 placeholder="e.g. What does this scripture mean in context?">
        </div>
        <div class="form-group" style="margin-bottom:0;">
          <label class="form-label">Details</label>
          <textarea name="body" class="form-control" rows="5" required
                    placeholder="Add more context or details to your question…"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="document.getElementById('askModal').classList.remove('open')">Cancel</button>
        <button type="submit" class="btn btn-primary">Post Question</button>
      </div>
    </form>
  </div>
</div>

@endsection