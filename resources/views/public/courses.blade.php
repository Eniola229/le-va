{{-- resources/views/public/courses.blade.php --}}
@extends('layouts.app')
@section('title', 'Courses & Programs')
@section('meta-desc', 'Explore all Lev Av courses and programs designed to take you deeper in God.')

@section('content')

<div style="padding-top:var(--nav-h);">

  {{-- Page Hero --}}
  <section style="padding:80px 0 56px;background:var(--warm-white);border-bottom:1px solid var(--beige);">
    <div class="container" style="max-width:680px;margin:0 auto;text-align:center;">
      <div class="section-label" style="justify-content:center;">Learning</div>
      <h1 class="section-title">Courses & Programs</h1>
      <p class="section-sub" style="text-align:center;">
        Each course is designed with one goal — to take you deeper. Biblically, spiritually, and personally.
      </p>
    </div>
  </section>

  {{-- Courses grid --}}
  <section class="section">
    <div class="container">
      @if($courses->count())
        <div class="public-courses-grid">
          @foreach($courses as $course)
          <div class="public-course-card" id="course-{{ $course->id }}">

            <div class="thumb">
              @if($course->cover_image)
                <img src="{{ $course->cover_image }}" alt="{{ $course->title }}">
              @else
                <div class="thumb-ph">LEV AV</div>
              @endif
            </div>

            <div class="body">
              <div class="title">{{ $course->title }}</div>
              <div class="desc">{{ Str::limit($course->description, 140) }}</div>

              <div class="meta">
                @if($course->duration)
                  <span>{{ $course->duration }}</span>
                @endif
                <span>{{ $course->lesson_count }} lessons</span>
              </div>

              {{-- What you will learn --}}
              @if($course->what_you_will_learn)
              <div style="margin-bottom:18px;">
                <div style="font-size:11px;text-transform:uppercase;letter-spacing:1.5px;color:var(--text-hint);margin-bottom:8px;">
                  You will learn
                </div>
                @foreach(array_slice(explode("\n", trim($course->what_you_will_learn)), 0, 4) as $outcome)
                  @if(trim($outcome))
                  <div style="display:flex;align-items:flex-start;gap:8px;font-size:13px;color:var(--text-muted);margin-bottom:5px;">
                    <span style="color:var(--gold);flex-shrink:0;margin-top:2px;">✦</span>
                    {{ trim($outcome) }}
                  </div>
                  @endif
                @endforeach
              </div>
              @endif

              {{-- CTA --}}
              @auth
                @if(auth()->user()->isAdmin())
                  <a href="{{ route('admin.courses.edit', $course) }}" class="enroll-btn">
                    Edit Course (Admin)
                  </a>
                @elseif(auth()->user()->enrollments()->where('course_id', $course->id)->exists())
                  <a href="{{ route('student.courses.show', $course) }}" class="enroll-btn"
                     style="background:var(--success-bg);color:var(--success);border-color:#c3dbc5;">
                    Continue Learning →
                  </a>
                @else
                  <form method="POST" action="{{ route('student.courses.enroll', $course) }}">
                    @csrf
                    <button type="submit" class="enroll-btn" style="width:100%;cursor:pointer;font-family:inherit;">
                      Enroll in Course
                    </button>
                  </form>
                @endif
              @else
                <a href="{{ route('register') }}" class="enroll-btn">Apply to Enroll</a>
              @endauth
            </div>

          </div>
          @endforeach
        </div>

      @else
        {{-- Empty state --}}
        <div style="text-align:center;padding:96px 24px;">
          <div style="font-family:var(--font-serif);font-size:32px;font-weight:300;color:var(--text-muted);margin-bottom:14px;">
            Coming Soon
          </div>
          <p style="font-size:15px;color:var(--text-hint);margin-bottom:32px;">
            New courses are being prepared with care. Join the community to be the first to know.
          </p>
          <a href="{{ route('register') }}" class="btn-primary">Join the Waitlist</a>
        </div>
      @endif
    </div>
  </section>

  {{-- Bottom CTA banner --}}
  <section class="section-sm" style="background:var(--ivory);border-top:1px solid var(--beige);">
    <div class="container">
      <div class="community-banner">
        <div>
          <h2>Not sure where to start?</h2>
          <p>
            Apply to join Lev Av and our team will help guide you to the right course for your season.
          </p>
        </div>
        <div class="cta-stack">
          <a href="{{ route('register') }}" class="btn-gold">Apply Now</a>
          <a href="{{ route('contact') }}" class="btn-ghost">Ask a Question</a>
        </div>
      </div>
    </div>
  </section>

</div>

@endsection