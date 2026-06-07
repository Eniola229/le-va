@extends('layouts.app')
@section('title', 'Come to the Heart of God')

@section('content')

{{-- Hero --}}
<section class="hero">
  <div class="hero-bg" id="heroBg"></div>
  <div class="container">
    <div class="hero-content">
      <div class="hero-eyebrow">Lev Av &nbsp;·&nbsp; לֵב אָב</div>
      <h1>Deepen your<br>relationship.<br><em>Live from His heart.</em></h1>
      <p>Lev Av is a place of spiritual growth, deep biblical learning, and intimate transformation — for those who hunger for more of God.</p>
      <div class="hero-actions">
        <a href="{{ route('register') }}" class="btn-primary">Join Community</a>
        <a href="{{ route('courses') }}"  class="btn-outline">Explore Courses</a>
      </div>
      <div class="hero-pills">
        <span class="hero-pill">Teachings</span>
        <span class="hero-pill">Courses</span>
        <span class="hero-pill">Community</span>
      </div>
    </div>
  </div>
</section>

{{-- About strip --}}
<section class="section" style="background:var(--warm-white);">
  <div class="container">
    <div class="about-grid">
    <div class="about-image">
      <img
        src="https://i.pinimg.com/736x/8b/84/5e/8b845e3bac41375b46e797910a5f1920.jpg"
        alt="Lev Av — Come to the Heart of God"
        style="width:100%;height:100%;object-fit:cover;object-position:center top;"
      >
    </div>
      <div class="about-content">
        <div class="section-label">What is Lev Av</div>
        <h2 class="section-title">The Heart of the Father</h2>
        <p class="section-sub">Lev Av (לֵב אָב) means "Heart of the Father" in Hebrew. We exist to help you encounter the deep, personal love of God — through scripture, community, and transformation.</p>
        <div class="about-features">
          <div class="about-feature">
            <h4>Biblical Depth</h4>
            <p>Rooted in scripture, taught with clarity and spiritual insight.</p>
          </div>
          <div class="about-feature">
            <h4>Intimate Community</h4>
            <p>A safe space to grow alongside others on the same journey.</p>
          </div>
          <div class="about-feature">
            <h4>Real Transformation</h4>
            <p>Not just knowledge — but a changed life from the inside out.</p>
          </div>
          <div class="about-feature">
            <h4>Prayer Culture</h4>
            <p>A community saturated in prayer and the presence of God.</p>
          </div>
        </div>
        <a href="{{ route('about') }}" class="btn-outline" style="margin-top:28px;display:inline-block;">Learn More</a>
      </div>
    </div>
  </div>
</section>

{{-- Featured Courses --}}
@if($courses->count())
<section class="section">
  <div class="container">
    <div style="display:flex;align-items:flex-end;justify-content:space-between;flex-wrap:wrap;gap:16px;">
      <div>
        <div class="section-label">Learning</div>
        <h2 class="section-title">Featured Courses</h2>
      </div>
      <a href="{{ route('courses') }}" class="btn-outline">View All Courses</a>
    </div>
    <div class="public-courses-grid">
      @foreach($courses as $course)
      <div class="public-course-card">
        <div class="thumb">
          @if($course->cover_image)
            <img src="{{ $course->cover_image }}" alt="{{ $course->title }}">
          @else
            <div class="thumb-ph">LEV AV</div>
          @endif
        </div>
        <div class="body">
          <div class="title">{{ $course->title }}</div>
          <div class="desc">{{ Str::limit($course->description, 100) }}</div>
          <div class="meta">
            @if($course->duration)<span>{{ $course->duration }}</span>@endif
            <span>{{ $course->lesson_count }} lessons</span>
          </div>
          <a href="{{ route('courses') }}#course-{{ $course->id }}" class="enroll-btn">Learn More</a>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>
@endif

{{-- Community Banner --}}
<section class="section-sm" style="background:var(--ivory);">
  <div class="container">
    <div class="community-banner">
      <div>
        <h2>You were made for more than you know.</h2>
        <p>Join a community of men and women pursuing God with their whole heart. Access courses, live sessions, prayer, and community — all in one place.</p>
      </div>
      <div class="cta-stack">
        <a href="{{ route('register') }}" class="btn-gold">Apply Now</a>
        <a href="{{ route('community') }}" class="btn-ghost">Learn More</a>
      </div>
    </div>
  </div>
</section>

{{-- Testimonials --}}
<section class="section" style="background:var(--warm-white);">
  <div class="container">
    <div class="section-label">Stories</div>
    <h2 class="section-title">What students say</h2>
    <div class="testimonials-grid">
      <div class="testimonial-card">
        <p class="testimonial-quote">Lev Av has completely transformed the way I approach God's word. The depth of teaching is unlike anything I've experienced.</p>
        <div class="testimonial-author"><strong>Sarah O.</strong> Lagos, Nigeria</div>
      </div>
      <div class="testimonial-card">
        <p class="testimonial-quote">I came looking for knowledge and found intimacy with God. This community is truly special.</p>
        <div class="testimonial-author"><strong>Emmanuel K.</strong> London, UK</div>
      </div>
      <div class="testimonial-card">
        <p class="testimonial-quote">The courses are beautifully designed and the teaching goes so deep. I'm genuinely being transformed.</p>
        <div class="testimonial-author"><strong>Grace A.</strong> Atlanta, USA</div>
      </div>
    </div>
  </div>
</section>

@endsection