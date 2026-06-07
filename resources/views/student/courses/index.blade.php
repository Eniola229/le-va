@extends('layouts.student')
@section('title', 'My Courses')
@section('page-title', 'My Courses')

@section('content')

@if($enrollments->count())
  <div class="courses-grid">
    @foreach($enrollments as $enrollment)
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
          <a href="{{ route('student.courses.show', $course) }}" class="btn-continue">
            {{ $enrollment->progress == 0 ? 'Start Course' : 'Continue' }}
          </a>
        </div>
      </div>
    @endforeach

    {{-- Browse CTA --}}
    <div class="course-card enroll-cta">
      <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
      <p>Looking for more?</p>
      <a href="{{ route('courses') }}" class="btn-continue" style="display:inline-block;padding:10px 20px;">Browse All Courses</a>
    </div>
  </div>
@else
  <div style="text-align:center;padding:80px 24px;">
    <div style="font-family:var(--font-serif);font-size:28px;color:var(--text-muted);margin-bottom:12px;">Begin your journey</div>
    <p style="font-size:15px;color:var(--text-hint);margin-bottom:28px;">You haven't enrolled in any courses yet.</p>
    <a href="{{ route('courses') }}" class="btn-continue" style="display:inline-block;padding:12px 28px;">Explore Courses</a>
  </div>
@endif

@endsection
