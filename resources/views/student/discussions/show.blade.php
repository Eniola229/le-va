@extends('layouts.student')
@section('title', $discussion->title)
@section('page-title', 'Discussion')

@section('topbar-actions')
  <a href="{{ route('student.discussions.index', $course) }}" style="font-size:13px;color:#9e9080;text-decoration:none;">← All Questions</a>
@endsection

@section('content')

<style>
/* Inline CSS styles */
:root {
  --warm-white: #faf8f5;
  --beige: #ede8e0;
  --gold-light: #f7f0e4;
  --brown-dark: #8a6e4b;
  --brown-deep: #5c3d22;
  --gold: #b89b6a;
  --ivory: #f5f0ea;
  --text-primary: #3a2e26;
  --text-muted: #6b5c4e;
  --text-hint: #9e9080;
  --danger: #c0392b;
  --radius-md: 8px;
  --radius-lg: 12px;
  --font-serif: 'Cormorant Garamond', serif;
}

.form-group {
  margin-bottom: 20px;
}
.form-control {
  width: 100%;
  box-sizing: border-box;
  padding: 12px 16px;
  font-family: 'Jost', sans-serif;
  font-size: 14px;
  color: #3a2e26;
  background: #faf8f5;
  border: 1px solid #ddd6cc;
  border-radius: 8px;
  outline: none;
  transition: border-color .15s, box-shadow .15s;
  resize: vertical;
}
.form-control:focus {
  border-color: #b89b6a;
  box-shadow: 0 0 0 3px rgba(184,155,106,.12);
  background: #fff;
}
.btn {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  height: 40px;
  padding: 0 24px;
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
</style>

<div style="max-width:760px;margin:0 auto;">

  {{-- Question --}}
  <div style="background:#faf8f5;border:1px solid #ede8e0;border-radius:12px;padding:28px 30px;margin-bottom:24px;">
    <div style="display:flex;align-items:center;gap:8px;margin-bottom:14px;">
      @if($discussion->is_pinned)
        <span style="font-size:11px;background:#f7f0e4;color:#8a6e4b;padding:2px 8px;border-radius:20px;">📌 Pinned</span>
      @endif
      <span style="font-size:11px;text-transform:uppercase;letter-spacing:1.5px;color:#9e9080;">Question</span>
    </div>
    <h2 style="font-family:'Cormorant Garamond',serif;font-size:22px;font-weight:400;margin-bottom:14px;color:#3a2e26;">
      {{ $discussion->title }}
    </h2>
    <p style="font-size:15px;color:#6b5c4e;line-height:1.85;margin-bottom:20px;">
      {{ $discussion->body }}
    </p>
    <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;">
      <div style="display:flex;align-items:center;gap:10px;">
        <div style="width:32px;height:32px;border-radius:50%;background:#f7f0e4;display:flex;align-items:center;justify-content:center;font-family:'Cormorant Garamond',serif;font-size:13px;color:#8a6e4b;">
          {{ strtoupper(substr($discussion->user->name,0,2)) }}
        </div>
        <div>
          <span style="font-size:13px;font-weight:500;color:#3a2e26;">{{ $discussion->user->name }}</span>
          @if($discussion->user->isAdmin())
            <span style="background:#f7f0e4;color:#8a6e4b;padding:1px 6px;border-radius:3px;font-size:10px;margin-left:6px;">Tutor</span>
          @endif
          <div style="font-size:11px;color:#9e9080;">{{ $discussion->created_at->format('d M Y · g:ia') }}</div>
        </div>
      </div>
      @if($discussion->user_id === auth()->id() || auth()->user()->isAdmin())
      <form method="POST" action="{{ route('student.discussions.destroy', [$course, $discussion]) }}" onsubmit="return confirm('Delete this question and all replies?')">
        @csrf @method('DELETE')
        <button type="submit" style="font-size:12px;color:#c0392b;background:none;border:none;cursor:pointer;padding:4px 8px;">
          Delete
        </button>
      </form>
      @endif
    </div>
  </div>

  {{-- Replies --}}
  @if($discussion->replies->count())
  <div style="margin-bottom:24px;">
    <div style="font-size:12px;text-transform:uppercase;letter-spacing:1.5px;color:#9e9080;margin-bottom:14px;padding-left:4px;">
      {{ $discussion->replies->count() }} {{ $discussion->replies->count() == 1 ? 'Reply' : 'Replies' }}
    </div>
    @foreach($discussion->replies as $reply)
    <div style="display:flex;gap:14px;margin-bottom:20px;">
      {{-- Avatar --}}
      <div style="flex-shrink:0;">
        <div style="width:34px;height:34px;border-radius:50%;background:{{ $reply->is_tutor_reply ? '#8a6e4b' : '#f5f0ea' }};display:flex;align-items:center;justify-content:center;font-family:'Cormorant Garamond',serif;font-size:12px;color:{{ $reply->is_tutor_reply ? '#f7f0e4' : '#9e9080' }};">
          {{ strtoupper(substr($reply->user->name,0,2)) }}
        </div>
      </div>
      {{-- Reply bubble --}}
      <div style="flex:1;background:{{ $reply->is_tutor_reply ? 'rgba(92,61,34,0.05)' : '#faf8f5' }};border:1px solid {{ $reply->is_tutor_reply ? 'rgba(201,169,110,0.4)' : '#ede8e0' }};border-radius:8px;padding:16px 18px;position:relative;">
        @if($reply->is_tutor_reply)
          <div style="position:absolute;top:-1px;left:16px;transform:translateY(-50%);background:#b89b6a;color:#5c3d22;font-size:10px;font-weight:600;padding:2px 10px;border-radius:20px;letter-spacing:.5px;">
            TUTOR
          </div>
        @endif
        <p style="font-size:14px;color:#3a2e26;line-height:1.8;margin-bottom:12px;{{ $reply->is_tutor_reply ? 'margin-top:8px;' : '' }}">
          {{ $reply->body }}
        </p>
        <div style="display:flex;align-items:center;justify-content:space-between;">
          <div style="font-size:12px;color:#9e9080;">
            <strong style="color:#6b5c4e;">{{ $reply->user->name }}</strong>
            · {{ $reply->created_at->diffForHumans() }}
          </div>
          @if($reply->user_id === auth()->id() || auth()->user()->isAdmin())
          <form method="POST" action="{{ route('student.discussions.reply.destroy', [$course, $discussion, $reply]) }}" onsubmit="return confirm('Delete this reply?')">
            @csrf @method('DELETE')
            <button type="submit" style="font-size:11px;color:#9e9080;background:none;border:none;cursor:pointer;">
              Remove
            </button>
          </form>
          @endif
        </div>
      </div>
    </div>
    @endforeach
  </div>
  @endif

  {{-- Reply form --}}
  <div style="background:#faf8f5;border:1px solid #ede8e0;border-radius:12px;padding:24px 28px;">
    <div style="font-family:'Cormorant Garamond',serif;font-size:16px;margin-bottom:16px;color:#3a2e26;">Post a Reply</div>
    <form method="POST" action="{{ route('student.discussions.reply', [$course, $discussion]) }}">
      @csrf
      <div class="form-group">
        <textarea name="body" class="form-control" rows="4" required
                  placeholder="Write your reply here..."></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Post Reply</button>
    </form>
  </div>

</div>

@endsection