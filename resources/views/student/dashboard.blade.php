@extends('layouts.student')
@section('title', 'Dashboard')
@section('page-title', 'Welcome back, ' . auth()->user()->name)

@section('content')

<div class="welcome-banner">
  <div>
    <h2>Come to the Heart of God.</h2>
    <p>Continue where you left off, or explore new courses added to your account.</p>
  </div>
  <a href="{{ route('student.courses') }}" class="btn-light">My Courses</a>
</div>

<div class="student-stats">
  <div class="stu-stat">
    <div class="val">{{ $enrolledCount }}</div>
    <div class="lbl">Courses Enrolled</div>
  </div>
  <div class="stu-stat">
    <div class="val">{{ $completedLessons }}</div>
    <div class="lbl">Lessons Completed</div>
  </div>
  <div class="stu-stat">
    <div class="val">{{ $overallProgress }}%</div>
    <div class="lbl">Overall Progress</div>
  </div>
</div>

{{-- Continue Learning --}}
@if($inProgress->count())
<div class="section-head">
  <h3>Continue Learning</h3>
  <a href="{{ route('student.courses') }}">View all</a>
</div>
<div class="courses-grid" style="margin-bottom:36px;">
  @foreach($inProgress as $enrollment)
    @php $course = $enrollment->course; @endphp
    <div class="course-card">
      <div class="thumb">
        @if($course->cover_image)
          <img src="{{ $course->cover_image }}" alt="{{ $course->title }}">
        @else
          <div class="thumb-placeholder">LEV AV</div>
        @endif
      </div>
      <div class="card-body">
        <div class="card-title">{{ $course->title }}</div>
        <div class="card-meta">
          <span>{{ $course->lesson_count }} lessons</span>
          @if($course->duration)<span>{{ $course->duration }}</span>@endif
        </div>
        <div class="progress-bar-wrap">
          <div class="progress-label">
            <span>Progress</span>
            <span>{{ $enrollment->progress }}%</span>
          </div>
          <div class="progress-bar">
            <div class="progress-bar-fill" style="width:{{ $enrollment->progress }}%;"></div>
          </div>
        </div>
        <a href="{{ route('student.courses.show', $course) }}" class="btn-continue">Continue</a>
      </div>
    </div>
  @endforeach
</div>
@endif

{{-- Announcements --}}
@if($announcements->count())
<div class="section-head"><h3>Announcements</h3></div>
<div style="display:flex;flex-direction:column;gap:12px;margin-bottom:36px;">
  @foreach($announcements as $ann)
  <div style="background:var(--warm-white);border:1px solid var(--beige);border-radius:var(--radius-md);padding:18px 20px;">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:6px;">
      <span style="font-family:var(--font-serif);font-size:16px;">{{ $ann->title }}</span>
      <span style="font-size:12px;color:var(--text-hint);">{{ $ann->sent_at?->format('d M Y') }}</span>
    </div>
    <p style="font-size:14px;color:var(--text-muted);line-height:1.7;">{{ Str::limit($ann->body, 200) }}</p>
  </div>
  @endforeach
</div>
@endif

@endsection




